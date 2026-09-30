## String对象


```
var s = "11"

var s1 = new String(s)

type s // string

type s1 //object

s1.valueOf === s1 //true

```
### String.fromCharCode()

String对象提供的静态方法（即定义在对象本身，而不是定义在对象实例的方法），主要是fromCharCode()。该方法的参数是一系列Unicode码点，返回对应的字符串

```
String.fromCharCode(104, 101, 108, 108, 111)
// "hello"

```

### 实例对象的属性和方法

1. length 属性 返回字符串的长度

2. charAt()

charAt方法返回指定位置的字符

```
"hello".charAt(0) //h
```
3. charCodeAt()

charCodeAt方法返回给定位置字符的Unicode码点（十进制表示）

4. concat()

concat方法用于连接两个字符串

5. slice(begin,end) 

截取字符

```

"hello".slice(0,2) // he
```

6. substr()

substr方法用于从原字符串取出子字符串并返回，不改变原字符串。

substr方法的第一个参数是子字符串的开始位置，第二个参数是子字符串的长度

7. indexOf()，lastIndexOf()

返回字符串在一个子串的位置

```
"hello".indexOf("h") //0
```

7. toLowerCase()，toUpperCase()

toLowerCase方法用于将一个字符串全部转为小写，toUpperCase则是全部转为大写。它们都返回一个新字符串，

8. localeCompare()

> localeCompare方法用于比较两个字符串。它返回一个整数，如果小于0，表示第一个字符串小于第二个字符串；如果等于0，表示两者相等；如果大于0，表示第一个字符串大于第二个字符串

```
'apple'.localeCompare('banana')
// -1

'apple'.localeCompare('apple')
// 0

```

9. match

match方法用于确定原字符串是否匹配某个子字符串，返回一个数组

```

"hello".match("h") // ["h"]
```

10. splite 分割字符串

```
"h,2,2,3".splite(',') ['h','2','2','3']
```

11. search 

字符串查找。如果大于0 则是找到了，否则返回-1