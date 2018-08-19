## 依赖注入和控制反转

> 依赖注入（Dependency Injection）又叫控制反转（Inversion of Control）是一个重要的面向对象编程的法则来削减计算机程序的耦合问题，它能消除组件间的直接依赖关系，让组件的开发更独立，使用更灵活

Ioc意味着将你设计好的对象交给容器控制，而不是传统的在你的对象内部直接控制。如何理解好Ioc呢？理解好Ioc的关键是要明确“谁控制谁，控制什么，为何是反转（有反转就应该有正转了），哪些方面反转了”

### 谁控制谁，控制什么

我们直接在对象内部通过new进行创建对象，是程序主动去创建依赖对象；而IoC是有专门一个容器来创建这些对象，即由Ioc容器来控制对象的创建；谁控制谁？当然是IoC 容器控制了对象；控制什么？那就是主要控制了外部资源获取

### 为何是反转，哪些方面反转了

传统应用程序是由我们自己在对象中**主动控制**去直接获取依赖对象，也就是正转；而反转则是由容器来帮忙创建及注入依赖对象；为何是反转？因为由容器帮我们查找及注入依赖对象，对象只是被动的接受依赖对象。

传统应用程序

![](http://sishuok.com/forum/upload/2012/2/19/a02c1e3154ef4be3f15fb91275a26494__1.JPG)

当有了IoC/DI的容器后，在客户端类中不再主动去创建这些对象了

![](http://sishuok.com/forum/upload/2012/2/19/6fdf1048726cc2edcac4fca685f050ac__2.JPG)

通过上图可以看出。各个类之间。通过依赖容器，由容器去主动去创建需要的类。

代码问题


	class A{
	
	}
	
	class B{
		public function test(){
			$c = new A();
		}
	}

B的内部依赖了A。是一个紧耦合。



真实的container会提供更多的特性，如

- 自动绑定（Autowiring）或 自动解析（Automatic Resolution）
- 注释解析器（Annotations）
- 延迟注入（Lazy injection）

	 class Bim
    {
        public function doSomething()
        {
            echo __METHOD__, '|';
        }
    }
    
    class Bar
    {
        private $bim;
    
        public function __construct(Bim $bim)
        {
            $this->bim = $bim;
        }
    
        public function doSomething()
        {
            $this->bim->doSomething();
            echo __METHOD__, '|';
        }
    }
    
    class Foo
    {
        private $bar;
    
        public function __construct(Bar $bar)
        {
            $this->bar = $bar;
        }
    
        public function doSomething()
        {
            $this->bar->doSomething();
            echo __METHOD__;
        }
    }
    
    class Container
    {
        private $s = array();
    
        public function __set($k, $c)
        {
            $this->s[$k] = $c;
        }
    
        public function __get($k)
        {
            // return $this->s[$k]($this);
            return $this->build($this->s[$k]);
        }
    
        /**
         * 自动绑定（Autowiring）自动解析（Automatic Resolution）
         *
         * @param string $className
         * @return object
         * @throws Exception
         */
        public function build($className)
        {
            // 如果是匿名函数（Anonymous functions），也叫闭包函数（closures）
            if ($className instanceof Closure) {
                // 执行闭包函数，并将结果
                return $className($this);
            }
    
            /** @var ReflectionClass $reflector */
            $reflector = new ReflectionClass($className);
    
            // 检查类是否可实例化, 排除抽象类abstract和对象接口interface
            if (!$reflector->isInstantiable()) {
                throw new Exception("Can't instantiate this.");
            }
    
            /** @var ReflectionMethod $constructor 获取类的构造函数 */
            $constructor = $reflector->getConstructor();
    
            // 若无构造函数，直接实例化并返回
            if (is_null($constructor)) {
                return new $className;
            }
    
            // 取构造函数参数,通过 ReflectionParameter 数组返回参数列表
            $parameters = $constructor->getParameters();
    
            // 递归解析构造函数的参数
            $dependencies = $this->getDependencies($parameters);
    
            // 创建一个类的新实例，给出的参数将传递到类的构造函数。
            return $reflector->newInstanceArgs($dependencies);
        }
    
        /**
         * @param array $parameters
         * @return array
         * @throws Exception
         */
        public function getDependencies($parameters)
        {
            $dependencies = [];
    
            /** @var ReflectionParameter $parameter */
            foreach ($parameters as $parameter) {
                /** @var ReflectionClass $dependency */
                $dependency = $parameter->getClass();
    
                if (is_null($dependency)) {
                    // 是变量,有默认值则设置默认值
                    $dependencies[] = $this->resolveNonClass($parameter);
                } else {
                    // 是一个类，递归解析
                    $dependencies[] = $this->build($dependency->name);
                }
            }
    
            return $dependencies;
        }
    
        /**
         * @param ReflectionParameter $parameter
         * @return mixed
         * @throws Exception
         */
        public function resolveNonClass($parameter)
        {
            // 有默认值则返回默认值
            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }
    
            throw new Exception('I have no idea what to do here.');
        }
    }
    
    // ----
    $c = new Container();
    $c->bar = 'Bar';
    $c->foo = function ($c) {
        return new Foo($c->bar);
    };
    // 从容器中取得Foo
    $foo = $c->foo;
    $foo->doSomething(); // Bim::doSomething|Bar::doSomething|Foo::doSomething
    
    // ----
    $di = new Container();
    
    $di->foo = 'Foo';
    
    /** @var Foo $foo */
    $foo = $di->foo;
    
    var_dump($foo);
    /*
    Foo#10 (1) {
      private $bar =>
      class Bar#14 (1) {
        private $bim =>
        class Bim#16 (0) {
        }
      }
    }
    */
    
    $foo->doSomething(); // Bim::doSomething|Bar::doSomething|Foo::doSomething