## 数据类型

> javascript 共有6种数据类型。

1. 数值 包括整型和浮点型
2. 字符串
3. null 
4. undefined
5. 对象
6. 布尔类型

其中对象可以细分为数组，函数，object

### 类型判断

1. typeof
2. instanceof
3. Object.prototype.toString

**typeof**

- 对于数值返回 number
- 对于布尔返回 boolean
- 对于字符串返回 string
- 对于函数返回 function
- 对于undefined 返回undefined
- 其他都返回object

```
typeof 1 //number
typeof false //boolean
typeof "hello" //string
typeof function(){} //function
typeof undefined //undefined

typeof null //object

```

### null 和undefined的区别

null和undefined都可以表示“没有”

**null是一个表示”无”的对象**，转为数值时为0；undefined是一个表示”无”的原始值，转为数值时为NaN。

```
typeof null //object
Number(null) //0

```

**undefined表示未定义**


```
var a 
typeof a //undefined

function f(x){
	return x
}
f() undefined

// 对象没有赋值的属性
var o = {}
o.a //undefined

//函数没有返回值
function f(){}

f()//undefined

```

### 布尔值
布尔只有两个值 true和false

空数组（[]）和空对象（{}）对应的布尔值，都是true


### 整型

javaScript 内部，所有数字都是以64位浮点数形式储存.由于浮点数不是精确的值

JavaScript 语言的底层根本没有整数，所有数字都是小数
```
1===1.0 //true
```
**数值精度**

JavaScript 浮点数的64个二进制

- 第一位 0  表示整数 1 表示负数
- 2-10位表示 指数部分
- 13-64位表示有效的数字

JavaScript 提供的有效数字最长为53个二进制位

**数值范围**

> 64位浮点数的指数部分的长度是11个二进制位，意味着指数部分的最大值是2047（2的11次方减1）。也就是说，64位浮点数的指数部分的值最大为2047
JavaScript 能够表示的数值范围为21024到2-1023（开区间）

**数值的进制**

> JavaScript 对整数提供四种进制的表示方法：十进制、十六进制、八进制、2进制

- 十进制：没有前导0的数值。
- 八进制：有前缀0o或0O的数值，或者有前导0、且只用到0-7的八个阿拉伯数字的数值。
- 十六进制：有前缀0x或0X的数值。
- 二进制：有前缀0b或0B的数值

```
0xff // 255
0o377 // 255
0b11 // 3
```

**特殊值**

1. 正零和负零

在JavaScript内部，实际上存在2个0：一个是+0，一个是-0。它们是等价

2. NaN

> NaN是 JavaScript 的特殊值，表示“非数字”（Not a Number），主要出现在将字符串解析成数字出错的场合。
isNaN只对数值有效，如果传入其他值，会被先转成数值
```
5-x //NaN
typeof NaN //number
NaN === NaN // false
Boolean(NaN) // false
//判断NaN
isNaN(NaN) // true
isNaN('Hello') // true
```

**Infinity**

> Infinity表示“无穷”，用来表示两种场景。一种是一个正的数值太大，或一个负的数值太小

- Infinity大于一切数值（除了NaN），-Infinity小于一切数值（除了NaN）
- Infinity有正负之分，Infinity表示正的无穷，-Infinity表示负的无穷
- Infinity与NaN比较，总是返回false

```
Infinity === -Infinity // false
Infinity > 1000 // true
-Infinity < -1000 // true
Infinity > NaN // false
```

**和进制相关的函数**

- parseInt

> parseInt方法还可以接受第二个参数（2到36之间），表示被解析的值的进制
> 如果第二个参数不是数值，会被自动转为一个整数

```
parseInt("010") //10
parseInt(100，2) //转成二进制 8
parseInt('10', undefined) // 10
```

- parseFloat()

> parseFloat方法用于将一个字符串转为浮点数

注意事项

- parseFloat会将空字符串转为NaN
- 如果参数不是字符串，或者字符串的第一个字符不能转化为浮点数，则返回NaN
- parseFloat方法会自动过滤字符串前导的空格

```
parseFloat('0.0314E+2') // 3.14
parseFloat(true)  // NaN
parseFloat('3.14more non-digit characters') // 3.14
```

### 字符串

字符串就是零个或多个排在一起的字符，放在单引号或双引号之中。单引号里面可以嵌套双引号，但是要嵌套单引号需要转义

```

'aaa'
"aaa"
"a'a'"
'a"aa"\'bb'
```

1. 字符串与数组

> 字符串可以被视为字符数组，因此可以使用数组的方括号运算符
> 字符串数组是只读的。所以修改会无效。

```
var s = "hello"
s[0] //h
``` 
2. length属性

> length属性返回字符串的长度，该属性也是无法改变的。

```
length("hello") //5
```

#### 字符集

> JavaScript使用Unicode字符集。也就是说，在JavaScript引擎内部，所有字符都用Unicode表示

```
var s = '\u00A9';
s // "©"

```
utf-16的字符串的范围

	([\0-\uD7FF\uE000-\uFFFF]|[\uD800-\uDBFF][\uDC00-\uDFFF])

#### Base64转码

btoa()：字符串或二进制值转为Base64编码
atob()：Base64编码转为原来的编码
atob btoa 不能用于非assii码

    var string = 'Hello World!';
    btoa(string) // "SGVsbG8gV29ybGQh"
    atob('SGVsbG8gV29ybGQh') // "Hello World!"

要将非ASCII码字符转为Base64编码，必须中间插入一个转码环节

```
function b64Encode(str) {
  return btoa(encodeURIComponent(str));
}

function b64Decode(str) {
  return decodeURIComponent(atob(str));
}

b64Encode('你好') // "JUU0JUJEJUEwJUU1JUE1JUJE"
b64Decode('JUU0JUJEJUEwJUU1JUE1JUJE') // "你好"

```