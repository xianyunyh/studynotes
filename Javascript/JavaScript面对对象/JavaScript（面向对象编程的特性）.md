## 面向对象的特性

### 构造函数继承

第一步是在子类的构造函数中，调用父类的构造函数

```
function Sub(value) {
  Super.call(this);
  this.prop = value;
}

```
第二步，是让子类的原型指向父类的原型，这样子类就可以继承父类原型

```
Sub.prototype = Object.create(Super.prototype);
Sub.prototype.constructor = Sub;
Sub.prototype.method = '...';

例子

function Shape() {
  this.x = 0;
  this.y = 0;
}

Shape.prototype.move = function (x, y) {
  this.x += x;
  this.y += y;
  console.info('Shape moved.');
};

// 第一步，子类继承父类的实例
function Rectangle() {
  Shape.call(this); // 调用父类构造函数
}
// 另一种写法
function Rectangle() {
  this.base = Shape;
  this.base();
}

// 第二步，子类继承父类的原型
Rectangle.prototype = Object.create(Shape.prototype);
Rectangle.prototype.constructor = Rectangle;
```

### 封装私有变量

1. 封装私有变量：立即执行函数的写法


_count为私有属性，外部无法读取到。

```
var module1 = (function () {
　var _count = 0;
　var m1 = function () {
　  //...
　};
　var m2 = function () {
　　//...
　};
　return {
　　m1 : m1,
　　m2 : m2
　};
})();

```

2. 模块放大模式

```
var module1 = ( function (mod){
　//...
　return mod;
})(window.module1 || {});
```

### 输入全局变量

独立性是模块的重要特点，模块内部最好不与程序的其他部分直接交互。

为了在模块内部调用全局变量，必须显式地将其他变量输入模块

```
var module1 = (function ($, YAHOO) {
　//...
})(jQuery, YAHOO);
//显式传入jquery 和yahoo 
```