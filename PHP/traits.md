## PHP Traits 新特性

> Trait 是为类似 PHP 的单继承语言而准备的一种代码复用机制。Trait 为了减少单继承语言的限制，使开发人员能够自由地在不同层次结构内独立的类中复用 method。Trait 和 Class 组合的语义定义了一种减少复杂性的方式，避免传统多继承和 Mixin 类相关典型问题。

> 通过在类中使用use关键字声明要组合的Trait名称，而具体某个Trait的声明使用trait关键词，Trait不能直接实例化

	trait Test {
    public function connect() {
        echo " connect";
    }
    public function close() {

    }

	}
	
	class Db {
	    public function query() {
	        echo "query";
	    }
	}
	
	class Mysql extends Db {
	    use Test;
	}
	
	$a1 = new Mysql();
	$a1->connect();

> 当方法或属性同名时，当前类中的方法会覆盖 trait的 方法，而 trait 的方法又覆盖了基类中的方法


	<?php 
    trait Drive {
        public function hello() {
            echo "hello drive\n";
        }
        public function driving() {
            echo "driving from drive\n";
        }
    }
    class Person {
        public function hello() {
            echo "hello person\n";
        }
        public function driving() {
            echo "driving from person\n";
        }
    }
    class Student extends Person {
        use Drive;
        public function hello() {
            echo "hello student\n";
        }
    }
    $student = new Student();
    $student->hello();
    $student->driving();
	
结果是 hello student
	 driving from drive

- 组合使用traits 

如果要组合多个Trait，通过逗号分隔 Trait名称

	use Trait1, Trait2;

当组合的多个Trait包含同名属性或者方法时，需要明确声明解决冲突，否则会产生一个致命错误。

使用insteadof和as操作符来解决冲突，insteadof是使用某个方法替代另一个，而as是给方法取一个别名

	<?php
	trait Trait1 {
	    public function hello() {
	        echo "Trait1::hello\n";
	    }
	    public function hi() {
	        echo "Trait1::hi\n";
	    }
	}
	trait Trait2 {
	    public function hello() {
	        echo "Trait2::hello\n";
	    }
	    public function hi() {
	        echo "Trait2::hi\n";
	    }
	}
	class Class1 {
	    use Trait1, Trait2 {
	        Trait2::hello insteadof Trait1;
	        Trait1::hi insteadof Trait2;
	    }
	}
	class Class2 {
	    use Trait1, Trait2 {
	        Trait2::hello insteadof Trait1;
	        Trait1::hi insteadof Trait2;
	        Trait2::hi as hei;
	        Trait1::hello as hehe;
	    }
	}
	$Obj1 = new Class1();
	$Obj1->hello();
	$Obj1->hi();
	echo "\n";
	$Obj2 = new Class2();
	$Obj2->hello();
	$Obj2->hi();
	$Obj2->hei();
	$Obj2->hehe();


- **as作用**

1. 给方法起一个别名
2. 修改方法的访问控制权限

> as关键词还有另外一个用途，那就是修改方法的访问控制：


	<?php
    trait Hello {
        public function hello() {
            echo "hello,trait\n";
        }
    }
    class Class1 {
        use Hello {
            hello as protected;
        }
    }
    class Class2 {
        use Hello {
            Hello::hello as private hi;
        }
    }
    $Obj1 = new Class1();
    $Obj1->hello(); # 报致命错误，因为hello方法被修改成受保护的
    $Obj2 = new Class2();
    $Obj2->hello(); # 原来的hello方法仍然是公共的
    $Obj2->hi();  # 报致命错误，因为别名hi方法被修改成私有的


> Trait 也能组合Trait，Trait中支持抽象方法、静态属性及静态方法

	trait Hello {
	    public function sayHello() {
	        echo "Hello\n";
	    }
	}
	trait World {
	    use Hello;
	    public function sayWorld() {
	        echo "World\n";
	    }
	    abstract public function getWorld();
	    public function inc() {
	        static $c = 0;
	        $c = $c + 1;
	        echo "$c\n";
	    }
	    public static function doSomething() {
	        echo "Doing something\n";
	    }
	}


文章内容参考：[http://php.net/manual/zh/language.oop5.traits.php](http://php.net/manual/zh/language.oop5.traits.php "http://php.net/manual/zh/language.oop5.traits.php")
[https://segmentfault.com/a/1190000002970128](https://segmentfault.com/a/1190000002970128 "https://segmentfault.com/a/1190000002970128")