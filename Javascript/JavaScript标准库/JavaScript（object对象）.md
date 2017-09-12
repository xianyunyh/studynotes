## object对象

> JavaScript 原生提供Object对象（注意起首的O是大写），所有其他对象都继承自这个对象

- 部署在对象上

```

var obj = new Object()

obj.make = function() {
    console.log("make")
}
```



-  部署到prototy对象

所有的构造函数都有一个prototype属性。指向object。


```
Object.prototype.make = function() {
    
}

var obj1 = {}

var obj2 = new Object()

obj1.make()

obj2.make()

```

### Object()

Object本身当作工具方法使用时，可以将任意值转为对象

如果参数是原始类型的值，Object方法返回对应的包装对象的实例

```
Object('1') instanceof String

Object(1) instanceof Number



```

如果Object方法的参数是一个对象，它总是返回原对象

```
var arr = []

Object(arr) === arr //true

var object = {}

Object({}) == object //true

//判断是不是对象
function isObject(value) {
  return value === Object(value);
}
 
```

### 对象的静态方法

所谓“静态方法”，是指部署在Object对象自身的方法。

- Object.keys()，Object.getOwnPropertyNames()

> Object.keys方法和Object.getOwnPropertyNames方法很相似，一般用来遍历对象的属性。它们的参数都是一个对象，都返回一个数组，该数组的成员都是对象自身的（而不是继承的）所有属性名

keys 返回是可以枚举的。 getOwnPropertyNames方法还返回不可枚举的属性名

```

var a = [1,2,3]

Object.keys(a) //[0,1,2]

Object.getOwnPropertyNames(a) //[0,1,2,length]
```

### 其他方法

1. 对象属性模型的相关方法

- Object.getOwnPropertyDescriptor()：获取某个属性的attributes对象。
- Object.defineProperty()：通过attributes对象，定义某个属性。
- Object.defineProperties()：通过attributes对象，定义多个属性。
- Object.getOwnPropertyNames()：返回直接定义在某个对象上面的全部属性的名称。

```
var att = Object.getOwnPropertyDescriptor(obj3,"a")
console.log(att)
//创建属性 第一个参数要增加对象的属性，第二个参数属性名，第三个是参数是对象，value属性是要增加的属性值

Object.defineProperty(obj3,"user",{value:"t"})
console.log(obj3)
Object.defineProperties(obj3,{"att1":{value:"he"}})
		
```

2- 控制对象状态的方法

- Object.preventExtensions()：防止对象扩展。
- Object.isExtensible()：判断对象是否可扩展。
- Object.seal()：禁止对象配置。
- Object.isSealed()：判断一个对象是否可配置。
- Object.freeze()：冻结一个对象。
- Object.isFrozen()：判断一个对象是否被冻结。

3. 原型链相关方法

- Object.create()：该方法可以指定原型对象和属性，返回一个新的对象。
- Object.getPrototypeOf()：获取对象的Prototype对象


### Object对象的实例方法

Object实例对象的方法 主要有以下六个

- valueOf()：返回当前对象对应的值。
- toString()：返回当前对象对应的字符串形式。
- toLocaleString()：返回当前对象对应的本地字符串形式。
- hasOwnProperty()：判断某个属性是否为当前对象自身的属性，还是继承自原型对象的属性。
- isPrototypeOf()：判断当前对象是否为另一个对象的原型。
- propertyIsEnumerable()：判断某个属性是否可枚举

```

var obj = {
    a:"a"
    b:"b"
}
obj.valueOf() //Object {a: "a", b: "b"}

obj.toString() //[object,object]

obj.hasOwnProperty('a') //true

```