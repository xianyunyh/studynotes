## shell入门教程

> Linux中的shell有多种类型，其中最常用的几种是Bourne   shell（sh）、C   shell（csh）和Korn   shell（ksh）。三种shell各有优缺点。
Bourne   shell是UNIX最初使用的shell，并且在每种UNIX上都可以使用。Bourne   shell在shell编程方面相当优秀，但在处理与用户的交互方面做得不如其他几种shell。Linux操作系统缺省的shell是Bourne   Again   shell，它是Bourne   shell的扩展，简称Bash，与Bourne   shell完全向后兼容，并且在Bourne   shell的基础上增加、增强了很多特性。Bash放在/bin/bash中，它有许多特色，可以提供如命令补全、命令编辑和命令历史表等功能，它还包含了很多C   shell和Korn   shell中的优点，有灵活和强大的编程接口，同时又有很友好的用户界面。

可以使用 `cat /etc/shells` 查看支持的shell类型。我们最常用的就是bash。兼容sh

- 头声明

shell脚本第一行必须以 #！开头，它表示该脚本使用后面的解释器解释执行。

```
#!/bin/bash 

```

1. shell的变量

shell变量中间不能有空格，合法的标识符（字母、数字、_）,不能使用关键字。首字母必须是字母

**变量赋值的时候，==中间的等于号前后不能有空格==**。

```
name=11
echo $name

1name //错误

_name //错误

name = "hello" //错误
```

2. 使用变量

定义过的变量直接使用$来访问这个变量


```
name="test"
echo $name
echo ${name}
```

3. 只能变量。

在一个变量的前面加上readonly 表示该变量只读。类似于常量。

```
readonly PI=3.14
echo $PI
```

4. 删除变量

当一个变量不再使用的时候，可以使用unset删除

```
name="test"

unset $name
```

变量的类型。有局部变量、环境变量、shell变量 


### 字符串

字符串和php类似。可以由双引号和单引号括起来

但是双引号括起来的字符串，里面的变量可以解析。

单引号里面不能出现双引号(转义也不可以).所以尽量使用双引号

```

str="hello''"

str2='hello'

str3='"test"'//错误

str4="str2$str2"

echo $str4

```

- 字符串拼接

字符串拼接和其他的语言不一样。不需要.也不需要+
```
name1="hello"
name2="world"

echo $name1 $name2// hello world

```
- 获取字符串的长度

```
str="helloworld"
${#str}

```

- 字符串切片

使用冒号:

```
str="helloworld"

echo ${str:0:4} //从0开始截取4个字符 hell
```

- 字符串判断操作

```
    ${var}	变量var的值, 与$var相同
     	 
    ${var-DEFAULT}	如果var没有被声明, 那么就以$DEFAULT作为其值 *
    ${var:-DEFAULT}	如果var没有被声明, 或者其值为空, 那么就以$DEFAULT作为其值 *
     	 
    ${var=DEFAULT}	如果var没有被声明, 那么就以$DEFAULT作为其值 *
    ${var:=DEFAULT}	如果var没有被声明, 或者其值为空, 那么就以$DEFAULT作为其值 *
     	 
    ${var+OTHER}	如果var声明了, 那么其值就是$OTHER, 否则就为null字符串
    ${var:+OTHER}	如果var被设置了, 那么其值就是$OTHER, 否则就为null字符串
     	 
    ${var?ERR_MSG}	如果var没被声明, 那么就打印$ERR_MSG *
    ${var:?ERR_MSG}	如果var没被设置, 那么就打印$ERR_MSG *
     	 
    ${!varprefix*}	匹配之前所有以varprefix开头进行声明的变量
    ${!varprefix@}	匹配之前所有以varprefix开头进行声明的变量
    
```

- 字符串截取

```
${#string}	$string的长度
 	 
${string:position}	在$string中, 从位置$position开始提取子串
${string:position:length}	在$string中, 从位置$position开始提取长度为$length的子串
 	 
${string#substring}	从变量$string的开头, 删除最短匹配$substring的子串
${string##substring}	从变量$string的开头, 删除最长匹配$substring的子串
${string%substring}	从变量$string的结尾, 删除最短匹配$substring的子串
${string%%substring}	从变量$string的结尾, 删除最长匹配$substring的子串
 	 
${string/substring/replacement}	使用$replacement, 来代替第一个匹配的$substring
${string//substring/replacement}	使用$replacement, 代替所有匹配的$substring
${string/#substring/replacement}	如果$string的前缀匹配$substring, 那么就用$replacement来代替匹配到的$substring
${string/%substring/replacement}	如果$string的后缀匹配$substring, 那么就用$replacement来代替匹配到的$substring

例子

str="hello"

echo ${#str}//5
echo ${str:0:2} //he

echo ${str/l/test}//heltesto
echo ${str//l/test} //hetesttesto

```

## 逻辑运算符

```
&&	逻辑的 AND	[[ $a -lt 100 && $b -gt 100 ]] 返回 false
||	逻辑的 OR	[[ $a -lt 100 || $b -gt 100 ]] 返回 true

```

## 字符串比较

```
=	检测两个字符串是否相等，相等返回 true。	[ $a = $b ] 返回 false。
!=	检测两个字符串是否相等，不相等返回 true。	[ $a != $b ] 返回 true。
-z	检测字符串长度是否为0，为0返回 true。	[ -z $a ] 返回 false。
-n	检测字符串长度是否为0，不为0返回 true。	[ -n $a ] 返回 true。
str	检测字符串是否为空，不为空返回 true。	[ $a ] 返回 true。

```