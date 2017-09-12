## 匿名类

> php7开始支持匿名类。可以 创建一次性对象。

在php7之前

	class User {
	    public function getName() {
			return "name";
	    }
	}
	
	class X {
	    public $ins;
	    public function __construct( $user) {
	        $this->_user = $user;
	
	    }
	}
	$a = new User();
	$x = new X($a);
	var_dump($x->ins->getName());


在php7时候

	class X {
	    public $_user;
	    public function __construct($user) {
	        $this->_user = $user;
	
	    }
	}
	$a = new User();
	$x = new X(new class {public function getName() {return "111";}});
	var_dump($x->_user->getName());

> 匿名类被嵌套进普通 Class 后，不能访问这个外部类（Outer class）的 private（私有）、protected（受保护）方法或者属性。 为了访问外部类（Outer class）protected 属性或方法，匿名类可以 extend（扩展）此外部类。 为了使用外部类（Outer class）的 private 属性，必须通过构造器传进来：

	class Outer
	{
	    private $prop = 1;
	    protected $prop2 = 2;
	
	    protected function func1()
	    {
	        return 3;
	    }
	
	    public function func2()
	    {
	        return new class($this->prop) extends Outer {
	            private $prop3;
	
	            public function __construct($prop)
	            {
	                $this->prop3 = $prop;
	            }
	
	            public function func3()
	            {
	                return $this->prop2 + $this->prop3 + $this->func1();
	            }
	        };
	    }
	}
	
	echo (new Outer)->func2()->func3();
	