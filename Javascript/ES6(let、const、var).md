## es6 const let

let const 都是块级作用域

var 函数级作用。

let 不能多次并定义。不存在变量提升

const 定义之后，不能被改重新赋值。


    var name = 10
    let name = 10 //报错。 a已经被定义了
    {
        let name = "100";// 块级
    }
    
    const a  =10 
    
    a = 20 //报错 
    
    
暂存性死区

默认使用const  需要更新变量的值用let，最后使用var



