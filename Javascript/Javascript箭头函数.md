## js箭头函数

> 一个箭头函数表达式的语法比一个函数表达式更短，并且不绑定自己的 this，arguments，super或 new.target。
> 箭头函数的引入有两个方面的作用：一是更简短的函数书写，二是对 this的词法解析

- 当只有一个参数的时候，可以省略圆括号()
	
	  a=>{console.log()}

- 当删除花括号时，它将是一个隐式的返回值，这意味着我们不需要指定我们返回

	  (a)=>a    // (a)=>{return a}

- 如果箭头函数没有参数，必须使用()或者_代替

		_=>{}  
		()=>{}

- 对函数体使用原括号, 返回一个**对象**字面表达式

	  a=>({})

- 支持 剩余参数 Rest parameters 和默认参数 default parameters:

		(a,b,c=1)=>{console.log(c)}
		(a,b,c,...reset)=>{}

### 不绑定 this

> 在箭头函数出现之前，每个新定义的函数都有其自己的 this 值

		'use strict';
		function Person(){
			this.age = '23';
			var test  = ()=>{
				console.log(this.age)
			}
			test();
		}
		var a1 = new Person() //23

### 不绑定参数

> 箭头函数不会在其内部暴露出参数（arguments )： arguments.length, arguments[0], arguments[1] 等等，都不会指向箭头函数的 arguments，而是指向了箭头函数所在作用域的一个名为 arguments 的值（如果有的话，否则，就是 undefined


### 注意事项

1. 箭头函数不能用作构造器，和 new 一起用就会抛出错误
2. 箭头函数没有原型属性
3. yield 关键字通常不能在箭头函数中使用（除非是嵌套在允许使用的函数内）。因此，箭头函数不能用作生成器。
4. 箭头函数在参数和箭头之间不能换行哦



js的this 是运行的时候调用的。一个函数作为独立使用指向window

箭头函数没有自己的this ，


箭头函数不适用的场景。

1. 箭头函数作为构造函数时。

    function Person(name){
        this.name = name;
    }
    
    let a = new Person('xiao');
    
    a.prototype.test= function(){
        
        console.log(this.name)
    }

2. 使用arguments对象的时候
3. 交互对象。click对象

