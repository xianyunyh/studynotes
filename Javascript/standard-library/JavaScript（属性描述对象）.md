## 属性描述对象

> JavaScript提供了一个内部数据结构，用来描述一个对象的属性的行为，控制它的行为。这被称为“属性描述对象”（attributes object）。每个属性都有自己对应的属性描述对象

```

{
  value: 123,
  writable: false,
  enumerable: true,
  configurable: false,
  get: undefined,
  set: undefined
}

```
- value

存放属性的值

- writable

属性是否可写

- enumerable 

属性是否可以枚举 （就是是否可以使用keys() for ..in .. ）

- configurable 

configurable属性控制了属性描述对象的可写性

- get

configurable属性控制了属性描述对象的可写性

- set

set存放一个函数，表示该属性的存值函数（setter）


### Object.getOwnPropertyDescriptor()

获取对象属性描述对象

```
var obj = {
    user:"t",
    age:14
}
obj1 = Object.getOwnPropertyDescriptor(obj,'user')

obj1.value // t
```


### Object.defineProperty()，Object.defineProperties()

Object.defineProperty方法允许通过定义属性描述对象，来定义或修改一个属性，然后返回修改后的对象。它的格式如下。

`Object.defineProperty(object, propertyName, attributesObject)`


```
Object.defineProperty(obj, 'height', {value:178,writable:false})

```

### 元属性

属性描述对象的属性，被称为“元属性”，因为它可以看作是控制属性的属性

- 可枚举性（enumerable）

> 可枚举性（enumerable）用来控制所描述的属性，是否将被包括在for...in循环之中。具体来说，如果一个属性的enumerable为false，下面三个操作不会取到该属性

1. for..in循环
2. Object.keys方法
3. JSON.stringify方法


- 可配置性（configurable）

> 可配置性（configurable）决定了是否可以修改属性描述对象。也就是说，当configurable为false的时候，value、writable、enumerable和configurable都不能被修改了

```
Object.defineProperty(obj,'user',{configurable: false})

Object.defineProperty(obj,'user',{writable:true}) //TypeError

delete obj.user // false

```

### Object.getOwnPropertyNames()

Object.getOwnPropertyNames方法返回直接定义在某个对象上面的全部属性的名称，而不管该属性是否可枚举。

```
var o = Object.defineProperties({}, {
  p1: { value: 1, enumerable: true },
  p2: { value: 2, enumerable: false }
});

Object.getOwnPropertyNames(o)
// ["p1", "p2"]


```

### Object.prototype.propertyIsEnumerable()

对象实例的propertyIsEnumerable方法用来判断一个属性是否可枚举

### getter 和setter 

有时候一些属性是动态变化的，我们就需要使用getter和setter来实现动态属性。 vue的计算属性就是用的setter和getter

```

var obj = {
    name:"",
    get user(){
        return "my"
    },
    set user(value){
        this.name = value
    }
}
```

### 控制对象状态

> JavaScript提供了三种方法，精确控制一个对象的读写状态，防止对象被改变。最弱一层的保护是Object.preventExtensions，其次是Object.seal，最强的Object.freeze

- #### Object.preventExtensions()

Object.preventExtensions方法可以使得一个对象无法再添加新的属性

```
var obj = {}

Object.preventExtensions(obj)
obj.name = "test" 
obj.name // undefined 

Object.defineProperty(obj,'user',{value:"test"}) //error
```

- #### Object.isExtensible()

> Object.isExtensible方法用于检查一个对象是否使用了Object.preventExtensions方法。也就是说，检查是否可以为一个对象添加属性。

```
var obj = {}

Object.isExtensible(obj) true

```

- #### Object.seal()

Object.seal方法使得一个对象既无法添加新属性，也无法删除旧属性

```
var o = {
  p: 'hello'
};

Object.seal(o);

delete o.p;
o.p // "hello"

o.x = 'world';
o.x // undefined

```

- #### Object.freeze()

Object.freeze方法可以使得一个对象无法添加新属性、无法删除旧属性

```
var o = {
  p: 'hello'
};

Object.freeze(o);

o.p = 'world';
o.p // hello
//无法修改

delete o.p //false 
```

### 局限性

上面的方法锁定了对象的属性。但是可以通过原型去修改。

```
var obj = new Object();
Object.preventExtensions(obj);

var proto = Object.getPrototypeOf(obj);
proto.t = 'hello';
obj.t
// hello

```