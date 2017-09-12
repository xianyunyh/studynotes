# Laravel的生命周期
## 概述
Laravel 的生命周期从public\index.php开始，从public\index.php结束。

注意：以下几图箭头均代表Request流向

![image](https://static.lufficc.com/image/abf66eba461a765d18080cc238cee956.png?_=6642399)


这么说有点草率，但事实确实如此。下面是public\index.php的全部源码（Laravel源码的注释是最好的Laravel文档），更具体来说可以分为四步：

    require __DIR__.'/../bootstrap/autoload.php';
    
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle($request = Illuminate\Http\Request::capture()   );   $response->send();
    
    $kernel->terminate($request, $response);
    
这四步详细的解释是：
1. 注册加载composer自动生成的class loader，包括所有你composer require的依赖（对应代码1）
.
2. 生成容器Container，Application实例，并向容器注册核心组件（HttpKernel，ConsoleKernel，ExceptionHandler）（对应代码2，容器很重要，后面详细讲解）。

3. 处理请求，生成并发送响应（对应代码3，毫不夸张的说，你99%的代码都运行在这个小小的handle方法里面）。

4. 请求结束，进行回调（对应代码4，还记得可终止中间件吗？没错，就是在这里回调的）。

### 启动Laravel基础服务 

我们不妨再详细一点：
第一步注册加载composer自动生成的class loader就是加载初始化第三方依赖，不属于Laravel核心，到此为止。
第二步生成容器Container，并向容器注册核心组件，这里牵涉到了容器Container和合同Contracts，这是Laravel的重点，下面将详细讲解。
重点是第三步处理请求，生成并发送响应。
首先Laravel框架捕获到用户发到public\index.php的请求，生成Illuminate\Http\Request实例，传递给这个小小的handle方法。在方法内部，将该$request实例绑定到第二步生成的$app容器上。让后在该请求真正处理之前，调用bootstrap方法，进行必要的加载和注册，如检测环境，加载配置，注册Facades（假象），注册服务提供者，启动服务提供者等等。这是一个启动数组，具体在Illuminate\Foundation\Http\Kernel中，包括：

    

```
protected $bootstrappers = [        
        'Illuminate\Foundation\Bootstrap\DetectEnvironment',        
        'Illuminate\Foundation\Bootstrap\LoadConfiguration',        
        'Illuminate\Foundation\Bootstrap\ConfigureLogging',        
        'Illuminate\Foundation\Bootstrap\HandleExceptions',        
        'Illuminate\Foundation\Bootstrap\RegisterFacades',       
        'Illuminate\Foundation\Bootstrap\RegisterProviders',       
        'Illuminate\Foundation\Bootstrap\BootProviders',    
    ];
    
```

        
看类名知意，Laravel是按顺序遍历执行注册这些基础服务的，注意顺序：Facades先于ServiceProviders，Facades也是重点，注册Facades就是注册config\app.php中的aliases 数组，你使用的很多类，如Auth，Cache,DB等等都是Facades；而ServiceProviders的register方法永远先于boot方法执行，以免产生boot方法依赖某个实例而该实例还未注册的现象。
所以，你可以在ServiceProviders的register方法中使用任何Facades，在ServiceProviders的boot方法中使用任何register方法中注册的实例或者Facades，这样绝不会产生依赖某个类而未注册的现象。

![image](https://static.lufficc.com/image/00e3ebc1e40f785536274ca1bf2af15b.png?_=6642399)

将请求传递给路由#
注意到目前为止，Laravel 还没有执行到你所写的主要代码（ServiceProviders中的除外），因为还没有将请求传递给路由。

在Laravel基础的服务启动之后，就要把请求传递给路由了。传递给路由是通过Pipelin，但是Pipeline有一堵墙，在传递给路由之前所有请求都要经过，这堵墙定义在app\Http\Kernel.php中的$middleware数组中，没错就是中间件，默认只有一个CheckForMaintenanceMode中间件，用来检测你的网站是否暂时关闭。这是一个全局中间件，所有请求都要经过，你也可以添加自己的全局中间件。
然后遍历所有注册的路由，找到最先符合的第一个路由，经过它的路由中间件，进入到控制器或者闭包函数，执行你的具体逻辑代码。

所以，在请求到达你写的代码之前，Laravel已经做了大量工作，请求也经过了千难万险，那些不符合或者恶意的的请求已被Laravel隔离在外。

### 服务容器

服务容器就是一个普通的容器，用来装类的实例，然后在需要的时候再取出来。用更专业的术语来说是服务容器实现了控制反转（Inversion of Control，缩写为IoC），意思是正常情况下类A需要一个类B的时候，我们需要自己去new类B，意味着我们必须知道类B的更多细节，比如构造函数，随着项目的复杂性增大，这种依赖是毁灭性的。控制反转的意思就是，将类A主动获取类B的过程颠倒过来变成被动，类A只需要声明它需要什么，然后由容器提供。
这样做的好处是，类A不依赖于类B的实现，这样在一定程度上解决了耦合问题。
在Laravel的服务容器中，为了实现控制反转，可以有以下两种：
  1. 依赖注入（Dependency Injection）。
  
依赖注入是一种类型提示，我们所做的仅仅是声明我们所需要的类型，所有的依赖问题都交给容器去解决。


    public function build($concrete)
    {
        如果concreate是闭包。然后闭包
        if ($concrete instanceof Closure) {
            return $concrete($this, $this->getLastParameterOverride());
        }
        //

        $reflector = new ReflectionClass($concrete);

        // If the type is not instantiable, the developer is attempting to resolve
        // an abstract type such as an Interface of Abstract Class and there is
        // no binding registered for the abstractions so we need to bail out.
        if (! $reflector->isInstantiable()) {
            return $this->notInstantiable($concrete);
        }

        $this->buildStack[] = $concrete;

        $constructor = $reflector->getConstructor();

       
        if (is_null($constructor)) {
            array_pop($this->buildStack);

            return new $concrete;
        }

        $dependencies = $constructor->getParameters();

       
        $instances = $this->resolveDependencies(
            $dependencies
        );

        array_pop($this->buildStack);

        return $reflector->newInstanceArgs($instances);
    }


2. 绑定

绑定操作一般在ServiceProviders中的register方法中，最基本的绑定是容器的bind方法，它接受一个类的别名或者全名和一个闭包来获取实例：

    $this->app->bind('XblogConfig',function ($app) {    
        return new MapRepository();
        
    });
    
还有一个singleton方法，和bind写法没什么区别。你也可以绑定一个已经存在的对象到容器中，上文中提到的request实例就是通过这种方法绑定到容器的：

    $this->app->instance('request', $request);。

绑定之后，我们可以通过一下几种方式来获取绑定实例：

    1.  app('XblogConfig');
    2.  app()->make('XblogConfig');
    3.  app()['XblogConfig'];
    4.  resolve('XblogConfig');
    
以上四种方法均会返回获得**MapRepository**的实例，唯一的区别是，在一次请求的生命周期中，

bind方法的闭包会在每一次调用以上四种方法时执行，

singleton方法的闭包只会执行一次。(单例)

在使用中，如果每一个类要获的不同的实例，或者需要“个性化”的实例时，这时我们需要用bind方法以免这次的使用对下次的使用造成影响；如果实例化一个类比较耗时或者类的方法不依赖该生成的上下文，那么我们可以使用singleton方法绑定。singleton方法绑定的好处就是，如果在一次请求中我们多次使用某个类，那么只生成该类的一个实例将节省时间和空间。
你也可以绑定接口与实现，例如：

    $app->singleton(    
    Illuminate\Contracts\Http\Kernel::class,    App\Http\Kernel::class);
    
上文讲述的Laravel的生命周期的第二步，Laravel默认（在bootstrap\app.php文件中）绑定了

    Illuminate\Contracts\Http\Kernel，
    Illuminate\Contracts\Console\Kernel，
    Illuminate\Contracts\Debug\ExceptionHandler
    
接口的实现类，这些是实现类框架的默认自带的。但是你仍然可以自己去实现。
还有一种上下文绑定，就是相同的接口，在不同的类中可以自动获取不同的实现，例如：


```
$this->app->when(PhotoController::class)->needs(Filesystem::class)->give(function () {return Storage::disk('local');}
);
$this->app->when(VideoController::class)->needs(Filesystem::class) > give(function () {
    return Storage::disk('s3');
});

```

上述表明，同样的接口Filesystem，使用依赖注入时，在PhotoController中获取的是local存储而在VideoController中获取的是s3存储。


### Contracts & Facades（合同&门面）


![image](https://static.lufficc.com/image/36743f12afc5794016ee7fe3ac431d03.png?_=6642399)

Laravel定义了一系列Contracts（翻译：合同），本质上是一系列PHP接口，一系列的标准，用来解耦具体需求对实现的依赖关系。其实真正强大的公司是制定标准的公司，程序也是如此，好的标准（接口）尤为重要。当程序变得越来大，这种通过合同或者接口来解耦所带来的可扩展性和可维护性是无可比拟的。


上图不使用Contracts的情况下，对于一种逻辑，我们只能得到一种结果（方块），如果变更需求，意味着我们必须重构代码和逻辑。但是在使用Contracts的情况下，我们只需要按照接口写好逻辑，然后提供不同的实现，就可以在不改动代码逻辑的情况下获得更加多态的结果。

#### Facades

系统的Facades的路径

    \Illuminate\Support\Facades
    
说一说Facades。在我们学习了容器的概念后，Facades就变得十分简单了。在我们把类的实例绑定到容器的时候相当于给类起了个**别名**，然后覆盖Facade的静态方法getFacadeAccessor并返回你的别名，然后你就可以使用你自己的Facade的静态方法来调用你绑定类的动态方法了。

其实Facade类利用了**__callStatic()** 这个魔术方法来延迟调用容器中的对象的方法，Facade实现了将对它调用的静态方法映射到绑定类的动态方法上，这样你就可以使用简单类名调用而不需要记住长长的类名。
        
举个例子 比如定义路由的时候实用**Router::get**、其实访问的就是 ==\Illuminate\Support\Facades\Route==。然后这个Router并调用魔术callStaic方法。通过后期静态绑定==static::getFacadeAccessor()==;返回router字符串。然后调用staitc


        public static function getFacadeRoot()
        {
            return static::resolveFacadeInstance(static::getFacadeAccessor());
            //app(static::getFacadeAccessor())
        }



      public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();
      

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }

### 总结

Laravel强大是因为他提供的很多功能，还有它的设计模式和思想。
 
  1. 理解Laravel生命周期和请求的生命周期概念。
  2. 所有的静态变量和单例，在下一个请求到来时都会重新初始化。
  3. 将耗时的类或者频繁使用的类用singleton绑定。
  4. 将变化选项的抽象为Contracts，依赖接口不依赖具体实现。
  5. 善于利用Laravel提供的容器。