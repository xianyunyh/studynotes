##  类型转换


> 强制转换主要指使用**Number、String**和**Boolean**三个构造函数，手动将各种类型的值，转换成数字、字符串或者布尔值


### Number

Number函数将字符串转为数值，要比parseInt函数严格很多。基本上，只要有一个字符无法转成数值，整个字符串就会被转为NaN

```

parseInt('42 cats') // 42
Number('42 cats') // NaN

//parseInt逐个解析字符，而Number函数整体转换字符串的类型

Number({a: 1}) // NaN
Number([1, 2, 3]) // NaN
Number([5]) // 5

```

1. 调用对象自身的valueOf方法。如果返回原始类型的值，则直接对该值使用Number函数，不再进行后续步骤。

2. 如果valueOf方法返回的还是对象，则改为调用对象自身的toString方法。如果toString方法返回原始类型的值，则对该值使用Number函数，不再进行后续步骤。

3. 如果toString方法返回的是对象，就报错

```

var obj = {x: 1};
Number(obj) // NaN

// 等同于
if (typeof obj.valueOf() === 'object') {
  Number(obj.toString());
} else {
  Number(obj.valueOf());
}

```

### String

String函数，可以将任意类型的值转化成字符串

- 数值：转为相应的字符串。
- 字符串：转换后还是原来的值。
- 布尔值：true转为"true"，false转为"false"。
- undefined：转为"undefined"。
- null：转为"null"
- 对象 如果是对象，返回一个类型字符串；如果是数组，返回该数组的字符串形式

```
String({a: 1}) // "[object Object]"
String([1, 2, 3]) // "1,2,3"

```

### Boolean()

除了以下六个值的转换结果为false，其他的值全部为true。

    undefined
    null
    -0
    0或+0
    NaN
    ''（空字符串）