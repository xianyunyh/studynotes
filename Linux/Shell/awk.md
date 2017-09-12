## awk

awk 也是一个非常棒的数据处理工具！sed 常常用于一整个行的处理， awk 则比较倾向于一行当中分成数个『栏位』（或者称为一个域，也就是一列）来处理.

awk有3个不同版本: awk、nawk和gawk，未作特别说明，一般指gawk，gawk 是 AWK 的 GNU 版本。

awk其名称得自于它的创始人 Alfred Aho 、Peter Weinberger 和 Brian Kernighan 姓氏的首个字母。实际上 AWK 的确拥有自己的语言： AWK 程序设计语言

```
awk '{pattern + action}' {filenames}

```
pattern 表示 AWK 在数据中查找的内容，而 action 是在找到匹配内容时所执行的一系列命令

- 调用awk

```
1.命令行方式
awk [-F  field-separator]  'commands'  input-file(s)
其中，commands 是真正awk命令，[-F域分隔符]是可选的。 input-file(s) 是待处理的文件。
在awk中，文件的每一行中，由域分隔符分开的每一项称为一个域。通常，在不指名-F域分隔符的情况下，默认的域分隔符是空格。

2.shell脚本方式
将所有的awk命令插入一个文件，并使awk程序可执行，然后awk命令解释器作为脚本的首行，一遍通过键入脚本名称来调用。
相当于shell脚本首行的：#!/bin/sh
可以换成：#!/bin/awk

3.将所有的awk命令插入一个单独文件，然后调用：
awk -f awk-script-file input-file(s)
其中，-f选项加载awk-script-file中的awk脚本，input-file(s)跟上面的是一样的。
```

![image](https://www.tutorialspoint.com/awk/images/awk_workflow.jpg)

awk工作流程是这样的：读入有'\n'换行符分割的一条记录，然后将记录按指定的域分隔符划分域，填充域，$0则表示所有域,$1表示第一个域,$n表示第n个域。默认域分隔符是"空白键" 或 "[tab]键

```
cat access.log |awk 'print $1'

cat /etc/passwd | awk -F ":" "print $1"

```

## awk 编程


```

awk 'BEGIN{} {} END{}'
```
BEGI、ENDN之间的的{}执行开始、结束的代码。

中间的{} 是处理的部分，每次读取一行数据

### awk内置变量


```
$n	当前记录的第n个字段，字段间由 FS分隔。
$0	完整的输入记录。
ARGC	命 令行参数的数目。
ARGIND	命令行中当前文件的位置(从0开始算)。
ARGV	包 含命令行参数的数组。
CONVFMT	数字转换格式(默认值为%.6g)
ENVIRON	环 境变量关联数组。
ERRNO	最后一个系统错误的描述。
FIELDWIDTHS	字 段宽度列表(用空格键分隔)。
FILENAME	当前文件名。
FNR	同 NR，但相对于当前文件。
FS	字段分隔符(默认是任何空格)。
IGNORECASE	如 果为真，则进行忽略大小写的匹配。
NF	当前记录中的字段数。
NR	当 前记录数。
OFMT	数字的输出格式(默认值是%.6g)。
OFS	输 出字段分隔符(默认值是一个空格)。
ORS	输出记录分隔符(默认值是一个换行符)。
RLENGTH	由 match函数所匹配的字符串的长度。
RS	记录分隔符(默认是一个换行符)。
RSTART	由 match函数所匹配的字符串的第一个位置。
SUBSEP	数组下标分隔符(默认值是\034)。

```
```

cat /etc/passwd | awk -F ":" '{print NR}'

```


### awk 运算符

```
运算符	描述
= += -= *= /= %= ^= **=	赋值
?:	C条件表达式
||	逻 辑或
&&	逻辑与
~ ~!	匹 配正则表达式和不匹配正则表达式
< <= > >= != ==	关 系运算符
空格	连接
+ -	加，减
* / &	乘，除与求余
+ - !	一元加，减和逻辑非
^ ***	求幂
++ --	增加或减少，作为前缀或后缀
$	字 段引用
in	数组成员

```

### awk 正则

```

匹配符	描述
\Y	匹配一个单词开头或者末尾的空字符串
\B	匹配单词内的空字符串
\<	匹配一个单词的开头的空字符串，锚定开始
\>	匹配一个单词的末尾的空字符串，锚定末尾
\W	匹配一个非字母数字组成的单词
\w	匹配一个字母数字组成的单词
\'	匹配字符串末尾的一个空字符串
\‘	匹配字符串开头的一个空字符串

```

### 内置函数

```
sub()	匹配记录中最大、最靠左边的子字符串的正则表达式，并用替换字符串替换这些字符串。如果没有指定目标字符串就默认使用整个记录。替换只发生在第一次匹配的 时候
gsub()	整个文档中进行匹配
index()	返回子字符串第一次被匹配的位置，偏移量从位置1开始
substr()	返回从位置1开始的子字符串，如果指定长度超过实际长度，就返回整个字符串
split()	可按给定的分隔符把字符串分割为一个数组。如果分隔符没提供，则按当前FS值进行分割
length()	返回记录的字符数
match()	返回在字符串中正则表达式位置的索引，如果找不到指定的正则表达式则返回0。match函数会设置内建变量RSTART为字符串中子字符串的开始位 置，RLENGTH为到子字符串末尾的字符个数。substr可利于这些变量来截取字符串
toupper()和tolower()	可用于字符串大小间的转换，该功能只在gawk中有效

atan2(x,y)	y,x 范围内的余切
cos(x)	余弦函数
exp(x)	求 幂
int(x)	取整
log(x)	自然对 数
rand()	随机数
sin(x)	正弦
sqrt(x)	平 方根
srand(x)	x是rand()函数的种子
int(x)	取 整，过程没有舍入
rand()	产生一个大于等于0而小于1的随机数

```

### 条件判断

awk中的条件语句是从C语言中借鉴来的。基本上和c语言一致

```
if (expression) {
    statement;
    statement;
    ... ...
}

if (expression) {
    statement;
} else {
    statement2;
}

if (expression) {
    statement1;
} else if (expression1) {
    statement2;
} else {
    statement3;
}

cat /etc/passwd | awk -F ":" '{if(NR==1){print $0}} ' 打印第一行的数据

```

### 循环语句

awk中的循环语句同样借鉴于C语言，支持while、do/while、for、break、continue，这些关s键字的语义和C语言中的语义完全相同

```
cat awk01.bash | awk 'BEGIN{for(i=0;i<10;i++){print i}}'



```

#### 数组

  因为awk中数组的下标可以是数字和字母，数组的下标通常被称为关键字(key)。值和关键字都存储在内部的一张针对key/value应用hash的表格里。由于hash不是顺序存储，因此在显示数组内容时会发现

```
cat /etc/passwd | awk -F ":" 'BEGIN{print "begin"} {arr[NR]=$1} END{print arr[1]}'

```

### 格式化printf

```

1、其与print命令的最大不同是，printf需要指定format；
2、format用于指定后面的每个item的输出格式；
3、printf语句不会自动打印换行符；\\n

format格式的指示符都以%开头，后跟一个字符；如下：
%c: 显示字符的ASCII码；
%d, %i：十进制整数；
%e, %E：科学计数法显示数值；
%f: 显示浮点数；
%g, %G: 以科学计数法的格式或浮点数的格式显示数值；
%s: 显示字符串；
%u: 无符号整数；
%%: 显示%自身；

修饰符：
N: 显示宽度；
-: 左对齐；
+：显示数值符号；


awk 'BEGIN { printf "Percentags = %d%%\n", 80.66 }' //80%
```
