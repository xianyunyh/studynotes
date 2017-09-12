## 对象

### 创建对象

创建对象有三种方法

```
var o = {}
var o = new Object()
var o3 = Object.create(Object.prototype);
```

### 键名

对象的所有键名都是**字符串**，所以加不加引号都可以

**注意事项**

1. 如果键名不符合标识名的条件（比如第一个字符为数字，或者含有空格或运算符），也不是数字，则必须加上引号，否则会报错

2. JavaScript的保留字可以不加引号当作键名
```
var o = {
  k:"helo"
}
//error
var obj = {
  for: 1,
  class: 2
};
```

### 属性

> 对象的每一个“键名”又称为“属性”（property）它的“键值”可以是任何数据类型。如果一个属性的值为函数，通常把这个属性称为“方法”，它可以像函数那样调用

- **对象的引用**

> 如果不同的变量名指向同一个对象，那么它们都是这个对象的引用，也就是说指向同一个内存地址。修改其中一个变量，会影响到其他所有变量

```
var o1 = {};
var o2 = o1;

o1.a = 1;
o2.a // 1

o2.b = 2;
o1.b // 2
```

- **消除歧义**

为了避免这种歧义，JavaScript规定，如果行首是大括号，一律解释为语句（即代码块）。如果要解释为表达式（即对象），必须在大括号前加上圆括号。

```
eval('{foo: 123}') // 123
eval('({foo: 123})') // {foo: 123}
```

### 属性的读取和赋值

- **属性的读取**

属性的读取可以使用.或者使用[]获取

```

var a = {a1:"test"}

a["a1"]
a.a1
```

- **属性的赋值**

点运算符和方括号运算符，不仅可以用来读取值，还可以用来赋值

```
o.p = 'abc';
o['p'] = 'abc';
```

- **获取所有keys**

```
o = {}
o.keys //0

```

- **删除对象的属性**

delete命令用于删除对象的属性，删除成功后返回true

删除一个不存在的属性，delete不报错，而且返回true。

只有一种情况，delete命令会返回false，那就是该属性存在，且不得删除

```

ar o = Object.defineProperty({}, 'p', {
  value: 123,
  configurable: false
});

o.p // 123
delete o.p // false

```

- **in 运算符**

in运算符用于检查对象是否包含某个属性（注意，检查的是键名，不是键值），如果包含就返回true，否则返回false

```
var o = { p: 1 };
'p' in o // true

```

- **对象遍历**


	var o = {a: 1, b: 2, c: 3};
	
	for (var i in o) {
	  console.log(o[i]);
	}

- **with语句**
它的作用是操作同一个对象的多个属性时，提供一些书写的方便

```
// 例二
with (document.links[0]){
  console.log(href);
  console.log(title);
  console.log(style);
}
// 等同于
console.log(document.links[0].href);
console.log(document.links[0].title);
console.log(document.links[0].style);
```

注意事项
> with区块内部的变量，必须是当前对象已经存在的属性，否则会创造一个当前作用域的全局变量。这是因为with区块没有改变作用域，它的内部依然是当前作用域

```

var o = {};

with (o) {
  x = "abc";
}

o.x // undefined
x // "abc"

```