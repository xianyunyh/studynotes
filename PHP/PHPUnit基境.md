## 基境

“基境”就是编写代码来将整个场景设置成某个已知的状态，并在测试结束后将其复原到初始状态。这个已知的状态称为测试的 基境(fixture)

PHPUnit 支持共享建立基境的代码。在运行某个测试方法前，会调用一个名叫 setUp() 的模板方法。setUp() 是创建测试所用对象的地方。当测试方法运行结束后，不管是成功还是失败，都会调用另外一个名叫 tearDown() 的模板方法。tearDown() 是清理测试所用对象的地方


    class StackTest extends TestCase
    {
        protected $stack;
    
        protected function setUp()
        {
            $this->stack = [];
        }
    
        public function testEmpty()
        {
            $this->assertTrue(empty($this->stack));
        }
    
        public function testPush()
        {
            array_push($this->stack, 'foo');
            $this->assertEquals('foo', $this->stack[count($this->stack)-1]);
            $this->assertFalse(empty($this->stack));
        }
    
        public function testPop()
        {
            array_push($this->stack, 'foo');
            $this->assertEquals('foo', array_pop($this->stack));
            $this->assertTrue(empty($this->stack));
        }
    }
    
## 组织测试

1. 编排测试

> 编排测试套件的各种方式中，最简单的大概就是把所有测试用例源文件放在一个测试目录中。通过对测试目录进行递归遍历，PHPUnit 能自动发现并运行测试

phpunit --bootstrap src/autoload.php tests

        src                                 tests
    `-- Currency.php                    `-- CurrencyTest.php
    `-- IntlFormatter.php               `-- IntlFormatterTest.php
    `-- Money.php                       `-- MoneyTest.php
    `-- autoload.php
    
> 当 PHPUnit 命令行测试执行器指向一个目录时，它会在目录下查找 *Test.php 文件

- 用 XML 配置来编排测试套件

配置

    <phpunit
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.5/phpunit.xsd"
         backupGlobals="true"
         backupStaticAttributes="false"
         <!--bootstrap="/path/to/bootstrap.php"-->
         cacheTokens="false"
         colors="false"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         forceCoversAnnotation="false"
         mapTestClassNameToCoveredClassName="false"
         printerClass="PHPUnit_TextUI_ResultPrinter"
         <!--printerFile="/path/to/ResultPrinter.php"-->
         processIsolation="false"
         stopOnError="false"
         stopOnFailure="false"
         stopOnIncomplete="false"
         stopOnSkipped="false"
         stopOnRisky="false"
         testSuiteLoaderClass="PHPUnit_Runner_StandardTestSuiteLoader"
         <!--testSuiteLoaderFile="/path/to/StandardTestSuiteLoader.php"-->
         timeoutForSmallTests="1"
         timeoutForMediumTests="10"
         timeoutForLargeTests="60"
         verbose="false">
      <!-- ... -->
    </phpunit>
    
例子

    <phpunit bootstrap="src/autoload.php">
      <testsuites>
        <testsuite name="money">
          <file>tests/IntlFormatterTest.php</file>
          <file>tests/MoneyTest.php</file>
          <file>tests/CurrencyTest.php</file>
        </testsuite>
      </testsuites>
    </phpunit>