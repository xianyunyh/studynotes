## 

生成器对象Generator 继承Iterator
Generator 对象不能通过 new 实例化.必须通过子类去实现。
迭代器需要实现的方法：

- Generator::current — 返回当前产生的值
- Generator::key — 返回当前产生的键
- Generator::next — 生成器继续执行
- Generator::rewind — 重置迭代器
- Generator::valid — 检查迭代器是否被关闭


## yeild 关键字

> yield 与 return 相似，不同的是 yield 不会终止函数的执行，而是为循环提供一个值并暂停生成器函数的执行

    foreach(range(1,100) as $k=>$v){
        
        echo $v;
    }
    
    function xrange($start,$end){
        for($i=$start;$i<$end;$i++){
            yeild $i;
        }
    }
    
    foreach(xrange(1,1000) as $v){
        
        echo $v;
    }
    
    
send

向生成器中传入一个值，并且当做 yield 表达式的结果，然后继续执行生成器。