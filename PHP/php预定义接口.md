# php预定义接口


## Traversable（遍历）接口 

> 无法被单独实现的基本抽象接口。它必须由 IteratorAggregate 或 Iterator 接口实现  

##  Iterator（迭代器）接口

接口需要实现以下四个方法

    Iterator extends Traversable {
        /* 方法 */
        abstract public mixed current ( void )
        abstract public scalar key ( void )
        abstract public void next ( void )
        abstract public void rewind ( void )
        abstract public boolean valid ( void )
    }
    
    
    // 代码实现iterator接口
    
    class Citerator
    {
    
    
    	private $values = ['apple','orange','banana'];
    
    	private $position = 0;
    	/**
    	 * @return mixed
    	 */
    	public function current()
    	{
    		return current($this->values);
    	}
    
    	/**
    	 * @return mixed
    	 */
    	public function next()
    	{
    		return next($this->values);
    	}
    
    	/**
    	 * @return mixed
    	 */
    	public function key()
    	{
    		return key($this->values);
    	}
    
    	/**
    	 * @return mixed
    	 */
    	public function valid()
    	{
    		return $this->key() !== null;
    	}
    
    	/**
    	 * @return mixed
    	 */
    	public function rewind()
    	{
    		return reset($this->values);
    	}
    
    }
    
        $a = new Citerator();
        
        forearch($a as $k=>$v){
            echo $k.$v;
        }
        
        
## ArrayAccess（数组式访问）接口

提供像访问数组一样访问对象的能力的接口。

    ArrayAccess {
        /* 方法 */
        abstract public boolean offsetExists ( mixed $offset ) //检查一个偏移位置是否存在
        abstract public mixed offsetGet ( mixed $offset ) //获取一个偏移位置的值
        abstract public void offsetSet ( mixed $offset , mixed $value ) //设置一个偏移位置的值
        abstract public void offsetUnset ( mixed $offset ) //复位一个偏移位置的值
    } 
    
    class CarrayCess implements ArrayAccess
    {
    	private $values = [];
    
    	/**
    	 * @param mixed $offset
    	 * @return mixed
    	 */
    	public function offsetExists($offset)
    	{
    		return  isset($this->values[$offset]);
    	}
    
    	/**
    	 * @param mixed $offset
    	 * @return mixed
    	 */
    	public function offsetGet($offset)
    	{
    		if(false === $this->values[$offset]){
    			return null;
    		}
    		return $this->values[$offset];
    	}
    
    	/**
    	 * @param mixed $offset
    	 * @param mixed $value
    	 */
    	public function offsetSet($offset, $value)
    	{
    		 $this->values[$offset] = $value;
    	}
    
    	/**
    	 * @param mixed $offset
    	 */
    	public function offsetUnset($offset)
    	{
    		 unset($this->values[$offset]);
    	}
    
    
    }
    
    $class = new CarrayCess()
    
    $class['a'] = '111'
    
    echo $class['a'];
    
    
## 序列化接口 Serializable

自定义对象序列化的接口

接口摘要

    Serializable {
    /* 方法 */
        abstract public string serialize ( void )
        abstract public mixed unserialize ( string $serialized )
    }


    // 类实现接口
    
    class MyClass implements Serializable {
    
        private $data;
        
        public function __construct($data) {
            $this->data = $data;
        }
        
        public function getData() {
            return $this->data;
        }
        
        public function serialize() {
           
            return serialize($this->data);
        }
        
        public function unserialize($data) {
            $this->data = unserialize($data);
        }
    }
    
    $obj = new MyClass;
    $ser = serialize($obj);
    
    $newobj = unserialize($ser);
    
    
    
## Closure 类


用于代表 匿名函数 的类.这个类带有一些方法，允许在匿名函数创建后对其进行更多的控制

有bind、bindTo(静态)两个方法。

    // 闭包函数
    $a = function ($i) {
    	return $i+10;
    };
    
    
    class A{
        
        public function test(Closure $call){
            return $call(10);
        }
    }
    
    $classA = new A();
    
    $aClosure = $classA->test($a);
    
##　生成器类

((PHP 5 >= 5.5.0, PHP 7))

Generator 对象是从 generators返回的.．Generator 对象不能通过 new 实例化

    Generator implements Iterator ｛｝
    
一个生成器函数看起来像一个普通的函数，不同的是普通函数返回一个值，而一个生成器可以yield生成许多它所需要的值

> 生成器函数的核心是yield关键字。它最简单的调用形式看起来像一个return申明，不同之处在于普通return会返回值并终止函数的执行，而yield会返回一个值给循环调用此生成器的代码并且只是暂停执行生成器函数

生成器允许你在 foreach 代码块中写代码来迭代一组数据而不需要在内存中创建一个数组, 那会使你的内存达到上限，或者会占据可观的处理时间


        function xrange($num){
            
            for($i=0;$i<$num;$i++){
                yield  $i;
            }
        }
        
        $yeildTest = xrange(10);
        
        forearch($yeildTest as $k=>$v){
            echo $v;
        }