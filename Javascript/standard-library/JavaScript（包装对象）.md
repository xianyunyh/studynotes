## 包装对象

包装对象”，就是分别与数值、字符串、布尔值相对应的Number、String、Boolean三个原生对象。这三个原生对象可以把原始类型的值变成（包装成）对象

```
var v1 = new Number(123);
var v2 = new String('abc');
var v3 = new Boolean(true);

typeof v1 // "object"
typeof v2 // "object"
typeof v3 // "o

```
注意事项：

Number、String和Boolean如果不作为构造函数调用（即调用时不加new），常常用于将任意类型的值转为数值、字符串和布尔值

### 包装对象的方法

1. valueOf()

函数对象的原始值

```
new Number(124).valueOf() //124
```

2. toString 

返回实例对应的字符串

new Number(2).toString() // '2'


### Boolean对象

主要用于生成布尔值的包装对象的实例

```

var b = new Boolean(false)


```

如果不使用new 就表示一个构造

```
Boolean(undefined) // false
Boolean(null) // false
Boolean(0) // false
Boolean('') // false
Boolean(NaN) // false

Boolean(1) // true
Boolean('false') // true
Boolean([]) // true
Boolean({}) // true
Boolean(function () {}) // true
Boolean(/foo/) // true
```

双重的否运算符（!）也可以将任意值转为对应的布尔值

```
!!undefined // false
!!null // false
!!0 // false
!!'' // false
!!NaN // false
!!1 // true
!!'false' // true
!![] // true
!!{} // true
!!function(){} // true
!!/foo/ // true

```