## 字符串拓展

### 二进制和八进制

ES6 提供了二进制和八进制数值的新的写法，分别用前缀0b（或0B）和0o（或0O）


### Number.isFinite(), Number.isNaN()

ES6在Number对象上，新提供了Number.isFinite()和Number.isNaN()两个方法

    Number.isFinite(10)
    Number.isNaN('SS')
    

### Number.parseInt(), Number.parseFloat()

ES6将全局方法parseInt()和parseFloat()，移植到Number对象上面，行为完全保持不变

### Number.isInteger()
Number.isInteger()用来判断一个值是否为整数。需要注意的是，在JavaScript内部，整数和浮点数是同样的储存方法，所以3和3.0被视为同一个值

### 安全整数和Number.isSafeInteger() 

avaScript能够准确表示的整数范围在-2^53到2^53之间（不含两个端点），超过这个范围，无法精确表示这个值


## Math对象的扩展

ES6在Math对象上新增了17个与数学相关的方法

**Math.trunc**方法

用于去除一个数的小数部分，返回整数部分

- Math.sign()

    - 参数为正数，返回+1；
    - 参数为负数，返回-1；
    - 参数为0，返回0；
    - 参数为-0，返回-0;
    - 其他值，返回NaN

判断一个数是不是整数 负数 或者 0 

- Math.cbrt()  计算一个数的立方根
- Math.clz32() 返回一个数的32位无符号整数形式有多少个前导0
- Math.fround  返回一个数的单精度浮点数形式

- Math.hypot() 方法返回所有参数的平方和的平方根

      Math.hypot(3,4) //5
      
- Math.sinh(x) 返回x的双曲正弦（hyperbolic sine）
- Math.cosh(x) 返回x的双曲余弦（hyperbolic cosine）
- Math.tanh(x) 返回x的双曲正切（hyperbolic tangent）
- Math.asinh(x) 返回x的反双曲正弦（inverse hyperbolic sine）
- Math.acosh(x) 返回x的反双曲余弦（inverse hyperbolic cosine）
- Math.atanh(x) 返回x的反双曲正切（inverse hyperbolic tangent）

> ES2016 新增了一个指数运算符（**）
