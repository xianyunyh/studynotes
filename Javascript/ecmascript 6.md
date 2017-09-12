## Ecmscript6

### let const
ES6新增了let命令，用来声明变量。它的用法类似于var，但是所声明的变量，只在let命令所在的代码块内有效。

    {
        let a =1
    }
     console.log(a)//undified
   
    例子对比
    
        for(var i =0;i<10;i++){
            
        }
        console.log(i)//10
        
        //es6
        for(let i =0;i<10;i++){
            console.log(i)
        }
        console.log(i)//undifiend
        
> 不存在变量提升问题

    // var 的情况
    console.log(foo); // 输出undefined
    var foo = 2;
    
    // let 的情况
    console.log(bar); // 报错ReferenceError
    let bar = 2;
    
> 不允许重复声明

    var a = 1;
    let a =10;
    console.log(a)//error
    
    
### const命令

> const声明一个只读的常量。一旦声明，常量的值就不能改变。

    const PI = 3.14;
    PI = 34;//TypeError
    
### ES6声明变量的6种方法

> **var**命令和function命令 let和const命令 import命令和class命令

### 顶级对象

顶层对象，在浏览器环境指的是window对象，在Node指的是global对象。ES5之中，顶层对象的属性与全局变量是等价的。

 ES6为了改变这一点，一方面规定，为了保持兼容性，var命令和function命令声明的全局变量，依旧是顶层对象的属性；另一方面规定，**======let命令====、const命令、class命令声明的全局变量==**，不属于顶层对象的属性。也就是说，从ES6开始，全局变量将逐步与顶层对象的属性脱钩。
 
    var a = "a";
    let b = "b"
    console.log(window.a)//a
    console.log(window.b)//undifind
    
    //获取顶级对象
    
    (typeof window !== 'undefined'
       ? window
       : (typeof process === 'object' &&
          typeof require === 'function' &&
          typeof global === 'object')
         ? global
         : this);