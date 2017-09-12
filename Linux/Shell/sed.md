## sed命令

sed全名叫stream editor，流编辑器，用程序的方式来编辑文本。sed基本上就是玩正则模式匹配。主要用于文本的替换。

```
sed [options] 'command' file
```

### sed 命令


```
a\ 在当前行下面插入文本。 
i\ 在当前行上面插入文本。 
c\ 把选定的行改为新的文本。 
d 删除，删除选择的行。 
D 删除模板块的第一行。 
s 替换指定字符 
h 拷贝模板块的内容到内存中的缓冲区。 
H 追加模板块的内容到内存中的缓冲区。 
g 获得内存缓冲区的内容，并替代当前模板块中的文本。 
G 获得内存缓冲区的内容，并追加到当前模板块文本的后面。 
l 列表不能打印字符的清单。 
n 读取下一个输入行，用下一个命令处理新的行而不是用第一个命令。 
N 追加下一个输入行到模板块后面并在二者间嵌入一个新行，改变当前行号码。 
p 打印模板块的行。 
P(大写) 打印模板块的第一行。 
q 退出Sed。
b lable 分支到脚本中带有标记的地方，如果分支不存在则分支到脚本的末尾。 
r file 从file中读行。 
t label if分支，从最后一行开始，条件一旦满足或者T，
t命令，将导致分支到带有标号的命令处，或者到脚本的末尾。 
T label 错误分支，从最后一行开始，一旦发生错误或者T，t命令，将导致分支到带有标号的命令处，或者到脚本的末尾。
w file 写并追加模板块到file末尾。 W file 写并追加模板块的第一行到file末尾。
! 表示后面的命令对所有没有被选定的行发生作用。
= 打印当前行号码。 
# 把注释扩展到下一个换行符以前。


```

### sed元字符


```
^ 匹配行开始，如：/^sed/匹配所有以sed开头的行。 
$ 匹配行结束，如：/sed$/匹配所有以sed结尾的行。 
. 匹配一个非换行符的任意字符，如：/s.d/匹配s后接一个任意字符，最后是d。 
* 匹配0个或多个字符，如：/*sed/匹配所有模板是一个或多个空格后紧跟sed的行。 
[] 匹配一个指定范围内的字符，如/[ss]ed/匹配sed和Sed。 
[^] 匹配一个不在指定范围内的字符，如：/[^A-RT-Z]ed/匹配不包含A-R和T-Z的一个字母开头，紧跟ed的行。
\(..\) 匹配子串，保存匹配的字符，如s/\(love\)able/\1rs，loveable被替换成lovers。
& 保存搜索字符用来替换其他字符，如s/love/**&**/，love这成**love**。 
\< 匹配单词的开始，如:/\ 匹配单词的结束，如/love\>/匹配包含以love结尾的单词的行。
x\{m\} 重复字符x，m次，如：/0\{5\}/匹配包含5个0的行。 x\{m,\} 重复字符x，至少m次，如：/0\{5,\}/匹配至少有5个0的行。
x\{m,n\} 重复字符x，至少m次，不多于n次，如：/0\{5,10\}/匹配5~10个0的行。

```

### 1. s命令

s替换内容 

`'s/原内容/替换后内容/模式'`
g表示全局替换

```
test.txt文件内容为1133aaabb
cat test.txt | sed 's/a/b/g'

cat test.txt | sed 's/^/开头添加内容/g'

cat test.txt | sed 's/$/结尾内容/g'

cat html.html | sed 's/[]'
```

- 替换指定行的内容

```
sed '1s/test/111/g' #全局替换第一行的内容

sed '2,20s/test/222/g' #在第2行到第20行替换内容


```

- 替换对应位置

```
sed 's/t/test/1' #替换每行的第一个t

sed 's/t/test/2' #替换每行的第二个t

sed 's/t/test/3g' # 替换第三行以后的t
```

- 多匹配替换

```
sed 's/t/test/g;3,s/a/3333/g' #替换第一行的a和替换t

```

- 使用&占位

```
sed 's/t/[&]/g' #给t附近添加[]

```

- 圆括号匹配

圆括号中匹配中的数据，可以作为变量，后面需要使用\1 \2等 正则中的反向引用。

```
sed 's/This is my \([^,&]*\),.*is \(.*\)/\1:\2/g ' #

```

### 2. N命令

把下一行的内容纳入当成缓冲区做匹配

```
sed 'N;s/my/your/' #

```

### a命令和i命令

a命令就是append， i命令就是insert，它们是用来添加行的

n i 表示在第n行前插入
n a 表示在第n行后插入

```
sed '1 i hellowold' test.txt #在第一行前插入

sed '1 a test ' test.txt # 在第一行最后append

# 表示匹配到fish后面添加数据

sed "/fish/a This is my monkey, my monkey's name is wukong" my.txt


```

### c 命令和d命令

c命令是替换匹配行
d命令是删除匹配行

2 c 替换第二行

2 d 删除第二行

```
sed "2 c This is my monkey, my monkey" my.txt
sed "/test/c hello" my.txt #匹配到test对应的行替换

sed "2d " my.txt
sed "/test/d" my.txt #匹配到test对应的行替换

sed "2,4d" my.txt #删除第二到第四行
```

### p命令

通过-n -p可以打印

```
sed -n '/fish/p' my.txt

```

### 命令打包

```
# 对3行到第6行，执行命令/This/d
$ sed '3,6 {/This/d}' pets.txt

# 对3行到第6行，匹配/This/成功后，再匹配/fish/，成功后执行d命令
$ sed '3,6 {/This/{/fish/d}}' pets.txt

# 从第一行到最后一行，如果匹配到This，则删除之；如果前面有空格，则去除空格
$ sed '1,${/This/d;s/^ *//g}' pets.txt

```

### e命令

多点编辑：e命令 -e选项允许在同一行里执行多条命令：


```
sed -e '1,5d' -e 's/test/check/' file 
```

### w命令和r命令

r命令是将文件内容读出来。w是将内容写到文件

```
sed '/test/r file' filename #从文件读取匹配到的test
sed -n '/test/w file' example #在example中所有包含test的行都被写入file里
```

### 常用

```
sed '/^$/d' file # 删除空白行

sed -n '1~2p' test.txt #奇数行 
sed -n '2~2p' test.txt #偶数行



```

### Hold Space

![image](http://coolshell.cn//wp-content/uploads/2013/02/sed_demo_00.jpg)

```
g： 将hold space中的内容拷贝到pattern space中，原来pattern space里的内容清除
G： 将hold space中的内容append到pattern space\n后
h： 将pattern space中的内容拷贝到hold space中，原来的hold space里的内容被清除
H： 将pattern space中的内容append到hold space\n后
x： 交换pattern space和hold space的内容

```