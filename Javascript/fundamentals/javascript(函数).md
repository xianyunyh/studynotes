## 函数

函数就是一段可以反复调用的代码块。函数还能接受输入的参数，不同的参数会返回不同的值


### 函数的声明

函数的声明有三种方式

- （1）function命令


```

function f(){
    
}
```

- （2） 函数表达式

```

var f = function(){}

```

- (3) 函数构造函数

Function构造函数接受多个参数，除了最后一个参数是add函数的“函数体”，其他参数都是add函数的参数。如果只有一个参数，该参数就是函数体

```
var add = new Function(
  'x',
  'y',
  'return x + y'
);

//等价于

function add(x, y) {
  return x + y;
}
```
函数的重复声明


函数重复声明并不会报错，最后声明的会覆盖之前的函数。

### 函数一等公民

> JavaScript语言将函数看作一种值，与其它值（数值、字符串、布尔值等等）地位相同。凡是可以使用值的地方，就能使用函数。比如，可以把函数赋值给变量和对象的属性，也可以当作参数传入其他函数，或者作为函数的结果返回


```
function f(){}

var a = f


function add(x, y) {
  return x + y;
}

// 将函数赋值给一个变量
var operator = add;

// 将函数作为参数和返回值
function a(op){
  return op;
}
a(add)(1, 1)

```

### 函数名的提升


JavaScript引擎将函数名视同变量名，所以采用function命令声明函数时，整个函数会像变量声明一样，被提升到代码头部

```
f();

function f() {} //正常运行


```

- 不能在条件语句中声明函数


### 函数的属性和方法

- name 属性

获取函数的名字


```
function f1() {}
f1.name // 'f1'
```

- length属性

length属性返回函数预期传入的参数个数

```

function f(a,b,c){}

f.length //3
```

- toString()

打印函数的源码



### **函数作用域**

> 作用域（scope）指的是变量存在的范围。Javascript只有两种作用域：一种是全局作用域，变量在整个程序中一直存在，所有地方都可以读取；另一种是函数作用域，变量只在函数内部存在

在函数外面定义的叫做全局变量,函数内部可以获取到。


```

var g = "hello"

function f(){
    console.log(g)
}

```

在函数内部定义的变量，外部无法读取，称为“局部变量”（local variable）函数外部获取不到

函数内部定义的变量，会在该作用域内覆盖同名全局变量
```

function f(){
    
    var v = 1;
}
v //undefined
```

- 函数内部的变量提升

与全局作用域一样，函数作用域内部也会产生“变量提升”现象。var命令声明的变量，不管在什么位置，变量声明都会被提升到函数体的头部

```
function foo(x) {
  if (x > 100) {
    var tmp = x - 100;
  }
  return tmp
}
等价于

function foo(x) {
    var x 
    if(x>100) {
        var tmp = x-100
    }
    return tmp
}
foo(101) // 1

```

-  函数本身的作用域

函数本身也是一个值，也有自己的作用域。它的作用域与变量一样，就是其声明时所在的作用域，与其运行时所在的作用域无关。

**==函数执行时所在的作用域，是定义时的作用域，而不是调用时所在的作用域==**

```

var a = 1;
var x = function () {
  console.log(a);
};

function f() {
  var a = 2;
  x();
}

f() // 1

//函数x是在函数f的外部声明的，所以它的作用域绑定外层，
//内部变量a不会到函数f体内取值，所以输出1，而不是2


```

函数体内部声明的函数，作用域绑定函数体内部

```

function foo() {
  var x = 1;
  function bar() {
    console.log(x);
  }
  return bar;
}

var x = 2;
var f = foo();
f() // 1

```

函数foo内部声明了一个函数bar，bar的作用域绑定foo。当我们在foo外部取出bar执行时，变量x指向的是foo内部的x，而不是foo外部的x


### 函数参数

- 参数的省略


js允许省略参数。被省略的参数的值就变为**undefined**。需要注意的是，函数的length属性与实际传入的参数个数无关，只反映函数预期传入的参数个数

只省略靠前的参数，而保留靠后的参数，只能显式省略最前面的参数


```
function f(a, b) {
  return a;
}

f(1, 2, 3) // 1
f(1) // 1
f() // undefined

f(undefined,1)

```

- 默认值

默认值在es6中被加入。但是在之前可以这样写


```
function f(a){
    
    a= a||1
}
```

- 参数传递

在参数传递的过程中，原始类型的值（数值、字符串、布尔值） 是值传递，并不会导致原始值的变化。

函数参数是复合类型的值（数组、对象、其他函数），传递方式是传址传递

```
var a = 10
function f(a){
    a=100
}
f(a)
```

#### arguments对象

由于JavaScript允许函数有不定数目的参数，所以我们需要一种机制，可以在函数体内部读取所有参数。虽然arguments很像数组，但它是一个对象.


```

function f (a,b,c){
    console.log(arguments[0])
}

f(1,2,3)//1

var args = Array.prototype.slice.call(arguments);//让arguments 变成数组


```


### 闭包

函数内部的变量无法在函数外部读取到，需要用到闭包。

闭包的最大用处有两个，一个是可以读取函数内部的变量，另一个就是让这些变量始终保持在内存中，即闭包可以使得它诞生环境一直存在

```
function f(){
    var a = 100;
}

a //未定义

function f(){
    var a = 100
    
    f1 = function(){
        return a
    }
    return f1
}

f1 = f()
f1() // 100

```

### 立即调用的函数表达式

在Javascript中，一对圆括号()是一种运算符，跟在函数名之后，表示调用该函数

```

(function(){alert(1)}())

```
