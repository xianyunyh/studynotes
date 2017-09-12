## Number 对象

Number对象是数值对应的包装对象，可以作为构造函数使用，也可以作为工具函数使用

```

var n = new Number(1) 
type n //object

Number(true) // 1
```

### Number对象的属性

- Number.POSITIVE_INFINITY：正的无限，指向Infinity。
- Number.NEGATIVE_INFINITY：负的无限，指向-Infinity。
- Number.NaN：表示非数值，指向NaN。
- Number.MAX_VALUE：表示最大的正数，相应的，最小的负数为-Number.MAX_VALUE。
- Number.MIN_VALUE：表示最小的正数（即最接近0的正数，在64位浮点数体系中为5e-324），相应的，最接近0的负数为-Number.MIN_VALUE。
- Number.MAX_SAFE_INTEGER：表示能够精确表示的最大整数，即9007199254740991。
- Number.MIN_SAFE_INTEGER：表示能够精确表示的最小整数，即-9007199254740991

```
Number.POSITIVE_INFINITY // Infinity
Number.NEGATIVE_INFINITY // -Infinity
Number.NaN // NaN

Number.MAX_VALUE
// 1.7976931348623157e+308
Number.MAX_VALUE < Infinity
// true

Number.MIN_VALUE
// 5e-324
Number.MIN_VALUE > 0
// true

Number.MAX_SAFE_INTEGER // 9007199254740991
Number.MIN_SAFE_INTEGER // -9007199254740991

```
### Number 对象实例的方法

Number对象有4个实例方法，都跟将数值转换成指定格式有关

1. toString()

```
(100).toString() // '100'

```
2. toFixed()

将一个数转为指定位数的小数，返回这个小数对应的字符串

toFixed方法的参数为指定的小数位数，有效范围为0到20

```

(101).toFiexed(2) //101.00
```

3. toExponential()

toExponential方法用于将一个数转为科学计数法形式。

4. toPrecision()

toPrecision方法用于将一个数转为指定位数的有效数字

    (12.34).toPrecision(5) // "12.340"
    
