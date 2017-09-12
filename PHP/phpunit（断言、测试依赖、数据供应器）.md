## 断言


1. 针对类 Class 的测试写在类 ClassTest中。

2. ClassTest（通常）继承自 PHPUnit\Framework\TestCase。

3. 测试都是命名为 test* 的公用方法。

也可以在方法的文档注释块(docblock)中使用 @test 标注将其标记为测试方法。

4. 在测试方法内，类似于 assertEquals()（参见 附录 A）这样的断言方法用来对实际值与预期值的匹配做出断言

    
    class StackTest extends TestCase
    {
    
        /* @test */
        public function testUser()
        {
            $stack = [];
            $this->assertEquals(0, count($stack));
    
            array_push($stack, 'foo');
            $this->assertEquals('foo', $stack[count($stack)-1]);
            $this->assertEquals(1, count($stack));
    
            $this->assertEquals('foo', array_pop($stack));
            $this->assertEquals(0, count($stack));
        }
    
        /*@test*/
        public function testAdd()
        {
            $arr = [
                'user'=>'xian'
            ];
            $this->assertArrayHasKey('user',$arr);
        }
    
        /*@test*/
        public function testIns()
        {
            $classA = Admin::getIns();
            $classB = Admin::getIns();
            $this->assertEquals($classA,$classB);
        }
    }
    
## 测试的依赖关系

> PHPUnit支持对测试方法之间的显式依赖关系进行声明。这种依赖关系并不是定义在测试方法的执行顺序中，而是允许生产者(producer)返回一个测试基境(fixture)的实例，并将此实例传递给依赖于它的消费者(consumer)们.

**@depends** 标注来表达测试方法之间的依赖关系

    class DependencyFailureTest extends TestCase
    {
        public function testOne()
        {
            $this->assertTrue(false);
        }
    
        /**
         * @depends testOne
         */
        public function testTwo()
        {
        }
    }
    
    
## 数据供给器

> 测试方法可以接受任意参数。这些参数由数据供给器方法（在 例 2.5中，是 additionProvider() 方法）提供。用 @dataProvider 标注来指定使用哪个数据供给器方法.
数据供给器方法必须声明为 public，其返回值要么是一个数组，其每个元素也是数组；要么是一个实现了 Iterator 接口的对象，在对它进行迭代时每步产生一个数组

    class DataTest extends TestCase
    {
        /**
         * @dataProvider additionProvider
         */
        public function testAdd($a, $b, $expected)
        {
            $this->assertEquals($expected, $a + $b);
        }
    
        public function additionProvider()
        {
            return [
                'adding zeros'  => [0, 0, 0],
                'zero plus one' => [0, 1, 1],
                'one plus zero' => [1, 0, 1],
                'one plus one'  => [1, 1, 3]
            ];
        }
    }
    
    
## 异常测试

> 使用 @expectedException 标注


    class ExceptionTest extends TestCase
    {
        /**
         * @expectedException InvalidArgumentException
         */
        public function testException()
        {
        }
    }
    
## 对输出进行测试

用 expectOutputString() 方法来设定所预期的输出。如果没有产生预期的输出，测试将计为失败


