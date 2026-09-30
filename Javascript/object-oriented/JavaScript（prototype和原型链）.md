## prototype对象

JavaScript 的每个对象都继承另一个对象，后者称为“原型”（prototype）对象。只有null除外，它没有自己的原型对象

原型对象上的所有属性和方法，都能被派生对象共享

原型对象的属性不是实例对象自身的属性。只要修改原型对象，变动就立刻会体现在所有实例对象上

所有构造函数都有prototype属性（其实是所有函数都有prototype属性）

```

var person = function (name){
    this.name = name
}
person.prototype.age = 100

p1 = new person("张三")

p1.age //100

p2 = new person("李四")

p2.age //100
p2.age = 101

p1.age // 101

```

### 原型链

对象的属性和方法，有可能是定义在自身，也有可能是定义在它的原型对象。由于原型本身也是对象，又有自己的原型，所以形成了一条原型链（prototype chain）.所有对象的原型最终都可以上溯到Object.prototype 

> 原型链”的作用是，读取对象的某个属性时，JavaScript 引擎先寻找对象本身的属性，如果找不到，就到它的原型去找，如果还是找不到，就到原型的原型去找。如果直到最顶层的Object.prototype还是找不到，则返回undefined

对象自身和它的原型，都定义了一个同名属性，那么优先读取对象自身的属性，这叫做“覆盖”（overriding）

```
var obj = {}
obj.name = "属性"

obj.prototype.name="原型"

obj.name //属性


```


#### constructor 属性

prototype对象有一个constructor属性，默认指向prototype对象所在的构造函数


由于constructor属性定义在prototype对象上面，意味着可以被所有实例对象继承

```

function P() {}

P.prototype.constructor === P //true

p1 = new P()

p1.constructor//

p.hasOwnProperty('constructor') //false


```

调用自身的函数


```
Constr.prototype.createCopy = function () {
  return new this.constructor();
};

```


### instanceof 运算符

instanceof运算符返回一个布尔值，表示指定对象是否为某个构造函数的实例

```
var p1 = new P()

P1.instanceof P //true

```
利用instanceof运算符，还可以巧妙地解决，调用构造函数时，忘了加new命令的问题

```
function f(){
    if (! this instanceof f){
        return new Error('')
    }
}

```

### Object.getPrototypeOf()

Object.getPrototypeOf方法返回一个对象的原型。这是获取原型对象的标准方法


```
Object.getPrototypeOf({}) === Object.prototype

```

### Object.setPrototypeOf()

Object.setPrototypeOf方法可以为现有对象设置原型，返回一个新对象。

接收两个参数。一个是现有对象，一个原型对象

```

var obj1 = {
    name:"test"
}

var obj2 = {
    
}

Object.setprototypeOf(obj2,obj1)

obj2.name //test
```

### Object.prototype.isPrototypeOf()

对象实例的isPrototypeOf方法，用来判断一个对象是否是另一个对象的原型

```
var o1 = {};
var o2 = Object.create(o1);
var o3 = Object.create(o2);

o2.isPrototypeOf(o3) // true
```

### Object.prototype.__proto__

__proto__属性（前后各两个下划线）可以改写某个对象的原型对象.属于浏览器端的。

__proto__属性只有浏览器才需要部署，其他环境可以没有这个属性，而且前后的两根下划线，表示它本质是一个内部属性，不应该对使用者暴露。因此，应该尽量少用这个属性，而是用Object.getPrototypeof()（读取）和Object.setPrototypeOf()（设置），进行原型对象的读写操作

```
var obj = {};
var p = {};

obj.__proto__ = p;
Object.getPrototypeOf(obj) === p // true

//通过__proto__属性，将p对象设为obj对象的原型。

```

获取对象原型的方法

一般推荐第三种


    obj.__proto__
    obj.constructor.prototype
    Object.getPrototypeOf(obj)
    
## 继承

通过原型链，对象的属性分成两种：自身的属性和继承的属性

### Object.getOwnPropertyNames(object)

```
Object.getOwnPropertyNames(Number)
```

Object.getOwnPropertyNames方法返回一个数组，成员是对象本身的所有属性的键名，不包含继承的属性键名

###　Object.prototype.hasOwnProperty(key)

判断一个属性是不是原型上的属性

```
Number.hasOwnProperty('name') //true
```

### in 运算符和 for…in 循环

> in运算符返回一个布尔值，表示一个对象是否具有某个属性。它不区分该属性是对象自身的属性，还是继承的属性。

```
'length' in Date // true
'toString' in Date // true

```

### 对象的拷贝

对象赋值是指针指向的。所以有时候需要ｃｏｐｙ一个对象的副本

如果要拷贝一个对象，需要做到下面两件事情。

确保拷贝后的对象，与原对象具有同样的prototype原型对象。
确保拷贝后的对象，与原对象具有同样的属性。

```

function copyObject(orig) {
  var copy = Object.create(Object.getPrototypeOf(orig));
  copyOwnPropertiesFrom(copy, orig);
  return copy;
}

function copyOwnPropertiesFrom(target, source) {
  Object
  .getOwnPropertyNames(source)
  .forEach(function(propKey) {
    var desc = Object.getOwnPropertyDescriptor(source, propKey);
    Object.defineProperty(target, propKey, desc);
  });
  return target;
}

```