PHP 7 改变了大多数错误的报告方式。不同于传统（PHP 5）的错误报告机制，现在大多数错误被作为 Error 异常抛出


Error 类并非继承自 Exception 类，所以不能用 catch (Exception $e) { ... } 来捕获 Error。你可以用 catch (Error $e) { ... }，或者通过注册异常处理函数（ set_exception_handler()）来捕获 Error

    try{
        
    }catch( Throwable $e){
        
    }
    
    
## 引用计数基本知识 


每个php变量存在一个叫"zval"的变量容器中。一个zval变量容器，除了包含变量的类型和值，还包括两个字节的额外信息。第一个是"is_ref"，是个bool值，用来标识这个变量是否是属于引用集合(reference set)。通过这个字节，php引擎才能把普通变量和引用变量区分开来，由于php允许用户通过使用&来使用自定义引用，zval变量容器中还有一个内部引用计数机制，来优化内存使用。第二个额外字节是"refcount"，用以表示指向这个zval变量容器的变量(也称符号即symbol)个数


    $a = 'hello';
    xdebug_debug_zval('a'); // refCount=1 is_ref=0
    $b = $a;
    xdebug_debug_zval('a'); // refCount=2 is_ref=0
    $c = &$a;
    xdebug_debug_zval('a'); // refCount=2 is_ref=1
    
    unset($b);

    xdebug_debug_zval('a');// refCount=2 is_ref =1

### 复合类型(Compound Types) 

array和 object类型的变量把它们的成员或属性存在自己的符号表中

    
      $a = array( 
            'meaning' => 'life', 
            'number' => 42
        );
        xdebug_debug_zval( 'a' );
        
        a(refCount=2,is_ref=0)
            meaning(refCount=1,is_ref=0)
            number(refCount=1,is_ref=0)