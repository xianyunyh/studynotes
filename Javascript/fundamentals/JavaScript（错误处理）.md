## 错误处理机制

JavaScript原生提供一个Error构造函数，所有抛出的错误都是这个构造函数的实例

- message：错误提示信息
- name：错误名称（非标准属性）
- stack：错误的堆栈（非标准属性）


    var err = new Error('出错了');
    err.message // "出错了"
    
    
### JavaScript的原生错误类型

> Error对象是最一般的错误类型，在它的基础上，JavaScript还定义了其他6种错误，也就是说，存在Error的6个派生对象

- SyntaxError 解析代码出错

```
var 1aaa //变量名不合法

```
- ReferenceError 存在引用错误

```

a // a 未定义

```

- RangeError

RangeError是当一个值超出有效范围时发生的错误。主要有几种情况，一是数组长度为负数，二是Number对象的方法参数超出范围，以及函数堆栈超过最大值

```
var arr = []

arr[-1] //rangeError


```

- TypeError 

类型错误。不是预期的类型


```

new false 

var obj = {}

obj.test() //typeerror


```

- URIError

URIError是URI相关函数的参数不正确时抛出的错误.主要涉及encodeURI()、decodeURI()、encodeURIComponent()、decodeURIComponent()、escape()和unescape()这六个函数


- EvalError

eval函数没有被正确执行时，会抛出EvalError错误


### 自定义错误


```

function UserError(message) {
   this.message = message || "默认信息";
   this.name = "UserError";
}

UserError.prototype = new Error();
UserError.prototype.constructor = UserError;

```

### throw 

throw可以接受各种值作为参数。JavaScript引擎一旦遇到throw语句，就会停止执行后面的语句，并将throw语句的参数值，返回给用户

```

throw new Error("error")

alert(1) //不执行

```
### try…catch结构

对错误进行处理，需要使用try...catch结构。


```

try {
    throw new Error()
}catch(e){
    console.log(1)
}

```

### finally代码块

最终执行的代码

```

try {
    
}catch(e){
    
}finnaly{
    
}
```