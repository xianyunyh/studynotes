## 面向对象基础

JavaScript 语言的对象体系，不是基于“类”的，而是基于构造函数（constructor）和原型链（prototype）因为JavaScript没有class这个概念。

JavaScript 语言使用构造函数（constructor）作为对象的模板。所谓”构造函数”，就是专门用来生成对象的函数。它提供模板，描述对象的基本结构

```
var Obj = function() {
    this.name = 'hello'
    
}


```
函数内容的this 指向对象实例。对于python 语言更好理解this是怎么进来的，其实是通过 参数隐藏了this。

```

var obj = function(this,name){
    this.name = name
}
```

### 生产对象实例

```

var obj1 = new Obj()

```

如果不使用new对象，那么name 就创建了一个全局的变量.

```

var s = Obj();
name // hello

```
在构造函数内部使用严格模式，即第一行加上use strict.可以避免name指向window顶级对象

```
var obj = function(this,name){
    use strict;
    this.name = name
}
```

### new 命令的原理

1. 创建一个空对象，作为将要返回的对象实例 {}
2. 将这个空对象的原型，指向构造函数的prototype属性
3. 将这个空对象赋值给函数内部的this关键字
4. 开始执行构造函数内部的代码


this指的是一个新生成的空对象，所有针对this的操作，都会发生在这个空对象上


### new.target

函数内部可以使用new.target属性。如果当前函数是new命令调用，new.target指向当前函数，否则为undefined 。可以通过该特性判断是不是new 

```
function f() {
  console.log(new.target === f);
}

f() // false
new f() // true

```

### 使用 Object.create() 创建实例对象

Object.create()方法，直接以某个实例对象作为模板，生成一个新的实例对象。


```
var obj = {
    name :"test",
    fn:function(){
        console.log('fn')
    }
}

var o1 = Object.create(obj) 
o1.name //test

``` 


## this 关键字

this总是返回一个对象，简单说，就是返回属性或方法“当前”所在的对象。在函数外部执行window顶级对象:

```
console.log(this)//window{}

var p = {
    name:"t",
    age:19,
    run:function(){
        return this.name+"run"
    }
}
p.run()// t run
```

### this使用场合

在全局环境中，指向window对象

在函数内，指向实例对象的

```

var obj = function (p){
    
    this.p = p
}
var p1 = new obj("aaa")

obj.prototype.n = function() {
    console.log(this.p)
}
p1.n()// aaa
```

3. 对象的方法

当 A 对象的方法被赋予 B 对象，该方法中的this就从指向 A 对象变成了指向 B 对象


### this 注意事项

1. 避免多层this

由于this的指向是不确定的，所以切勿在函数中包含多层的this

```

var o = {
  f1: function () {
    console.log(this);
    var f2 = function () {
      console.log(this);
    }();
  }
}

o.f1()
// Object
// Window

上面的代码等价于


var t = function(){
    console.log(this)
}

var o = {
    p:function(){
        console.log(this)
        var f2 = t
        t();
    }
}
```

2. 避免数组处理方法中的this

数组的map和foreach方法，允许提供一个函数作为参数。这个函数内部不应该使用this

3. 避免回调函数中的this


### 绑定 this 的方法

> this的动态切换，固然为JavaScript创造了巨大的灵活性，但也使得编程变得困难和模糊。有时，需要把this固定下来，避免出现意想不到的情况。JavaScript提供了call、apply、bind这三个方法，来切换/固定this的指向


- function.prototype.call() 函数的原型方法

函数实例的call方法，可以指定函数内部this的指向（即函数执行时所在的作用域），然后在所指定的作用域中，调用该函数

```

var obj = {}

var f = function (){
    return this;
}

f.call(obj)


```

call方法的参数，应该是一个对象。如果参数为空、null和undefined，则默认传入全局对象

```
var t = 'window'
var obj = {
    name:"t"
}

var f = function () {
    console.log(this.t)
}

f();//window

f.call() //window

f.call(obj) //t
```

- function.prototype.apply()

apply方法的作用与call方法类似，也是改变this指向，然后再调用该函数。唯一的区别就是，它接收一个数组作为函数执行时的参数

```
func.apply(thisValue, [arg1, arg2, ...])
```
> apply方法的第一个参数也是this所要指向的那个对象，如果设为null或undefined，则等同于指定全局对象。第二个参数则是一个数组，该数组的所有成员依次作为参数，传入原函数。原函数的参数，在call方法中必须一个个添加，但是在apply方法中，必须以数组形式添加

- 转换类似数组的对象


```
Array.prototype.slice.apply({0:1,length:1})
// [1]

Array.prototype.slice.apply({0:1})
// []

Array.prototype.slice.apply({0:1,length:2})
// [1, undefined]

Array.prototype.slice.apply({length:1})
// [undefined]

```

- 绑定回调函数的对象


```
var o = new Object();

o.f = function () {
  console.log(this === o);
}

var f = function (){
  o.f.apply(o);
  // 或者 o.f.call(o);
};

$('#button').on('click', f);

```

### function.prototype.bind()

bind方法用于将函数体内的this绑定到某个对象，然后返回一个新函数。

```
var d = new Date();
d.getTime() // 1481869925657

var print = d.getTime.bind(d)

print()


```

 bind 注意事项
 
 - 每一次返回一个新函数
 
```

//bad
element.addEventListener('click', o.m.bind(0));
//good
var listener = o.m.bind(o);
element.addEventListener('click', listener);
//  ...
element.removeEventListener('click', listener);
```
- 结合回调函数使用 

将包含this的方法直接当作回调函数会改变this的指向。


```
var counter = {
  count: 0,
  inc: function () {
    'use strict';
    this.count++;
  }
};

function callIt(callback) {
  callback();
}

callIt(counter.inc) //TypeError

//解决方法

callIt(counter.inc.bind(counter));
counter.count // 1

```