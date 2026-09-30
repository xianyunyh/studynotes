## 对象和函数

在js中对象有三种，Function Object Array。Arrray 也是Object一种特殊的形式。

对象和数组的创建 可以使用字面量的方式 **{}** ,**[]**，也可以使用Object和Array构造去创建

对象都是通过函数创建的


```
// Object 对象也是一个函数
// object定义如下。

function Object(){
    
}

var obj = {} // 等价于 new Object()

var arr = [] // 等价于 new Array()

typeof Object //function

var f = function(){}

typeof f //function

f instanceof Object //true 函数属于对象

```

### 原型prototype

函数也是一种对象。也是有一些属性的集合，JavaScript给函数增加一个prototype属性。这个prototype 也是一个对象。这个属性对象中有一个constructor 指向这个函数本身。

```
var f = function(){} // 创建一个f
f.prototype //f上面 的prototype对象，这是f的原型对象。

// f.prototype.constructor 指向 
f.prototype.constructor === f // true

```

每个函数function都有一个prototype，即原型。—每个对象都有一个__proto__，可成为隐式原型

每个对象都有一个__proto__属性，指向创建该对象的函数的prototype


![image](http://images2015.cnblogs.com/blog/787416/201603/787416-20160323103557261-114570044.png)

![image](http://images2015.cnblogs.com/blog/787416/201603/787416-20160323103622089-1134417169.png)

每个对象obj都有一个__proto__属性。这个属性指向对象的原型(obj.prototype)

Object.prototype确实一个特例——它的__proto__指向的是null



```
var obj = {}

obj.__proto__ === Object.prototype

//对象
var fn = function(){
    
}

fn.__proto__ === Fucntion.prototype //这是函数的原型


var f1 = new fn()

f1.__proto__ === fn.prototype

```

![image](http://images2015.cnblogs.com/blog/787416/201603/787416-20160322110905589-2039017350.png)


函数也是一个对象，它是由Function对象创建的

```
var f = function(){
    
}
//等价于

var f = new Function()

```
