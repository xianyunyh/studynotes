## makefile

代码到可执行文件的过程需要编译，但是编译的过程先编译哪个，再编译哪个，叫构建。make就是构建的过程

### 1. makefile文件格式

makefile 文件由一些了的规则构成 

```makefile
<target> : <prerequisites> 
[tab]  <commands>
```

target是目标。prerequisites是前置条件。tab后面跟着命令。

- 目标target

  一个目标构成一个规则。指明要做的事情

  ```makefile
  clean:
  	rm *.o
  
  # make clean
  ```

  `.PHONY: clean` 声明伪类。就是如果clean文件存在，也执行clean的目标

  

- 前置条件 prerequisites

  > 前置条件通常是一组文件名，之间用空格分隔。它指定了"目标"是否重新构建的判断标准：只要有一个前置文件不存在，或者有过更新（前置文件的last-modification时间戳比目标的时间戳新），"目标"就需要重新构建。 

  ```makefile
  java: java.exe
  	java -v
  ```

  如果java.exe再当前目录存在。还需要指定一条规则定义`java.exe`

  ```makefile
  java.exe:
  	echo 'java.exe'
  ```

- 命令 command

  > 命令（commands）表示如何更新目标文件，由一行或多行的Shell命令组成。它是构建"目标"的具体指令，它的运行结果通常就是生成目标文件。 

  每行命令之前必须有一个tab键。如果想用其他键，可以用内置变量`.RECIPEPREFIX`声明。 

  ```makefile
  .RECIPEPREFIX = >
  all:
  > echo Hello, world
  ```

  **每行命令在一个单独的shell中执行。这些Shell之间没有继承关系。** 

  ```makefile
  var-lost:
      export foo=bar
      echo "foo=[$$foo]"
  # 取不到foo的值
  ```

  解决方法：

  - 写在同一行
  - 用`\` 分割

## makefile 语法

- 注释 以`#` 注释

- 回声 以`@`

- 通配符

  > 通配符（wildcard）用来指定一组符合条件的文件名。Makefile 的通配符与 Bash 一致，主要有星号（*）、问号（？）和 [...]  

  - *****     : 表示任意一个或多个字符
  - **?**     :表示任意一个字符
  - **[...]** : ex. [abcd] 表示a,b,c,d中任意一个字符, `[^abcd]`表示除a,b,c,d以外的字符, [0-9]表示 0~9中任意一个数字
  - **~**     : 表示用户的home目录

- 模式匹配 `%`

  > Make命令允许对文件名，进行类似正则运算的匹配，主要用到的匹配符是%。比如，假定当前目录下有 f1.c 和 f2.c 两个源码文件，需要将它们编译为对应的对象文件。 

### 变量和赋值

Makefile一共提供了四个赋值运算符 （=、:=、？=、+=） 

- `=`

  ```makefile
  VARIABLE = value
  # 在执行时扩展，允许递归扩展。
  ```

- `:=`

  ```makefile
  VARIABLE := value
  # 在定义时扩展。
  ```

- `?=`

  ```makefile
  VARIABLE ?= value
  # 在定义时扩展。
  ```

- `+=`

  ```makefile
  VARIABLE += value
  # 将值追加到变量的尾端。
  ```

  

### 内置变量

Make命令提供一系列内置变量，比如，`$(CC) `指向当前使用的编译器，`$(MAKE) `指向当前使用的Make工具。这主要是为了跨平台的兼容性 

### 自动变量

Make命令还提供一些自动变量，它们的值与当前规则有关。主要有以下几个。

- `$@`

  $@指代当前目标，就是Make命令当前构建的那个目标 

- `$<`

  第一个前置条件

  

- `$?`

  `$?` 指代比目标更新的所有前置条件，之间以空格分隔。比如，规则为 t: p1 p2，其中 p2 的时间戳比 t 新，`$?`就指代p2。

- `$^`

  `$^` 指代所有前置条件，之间以空格分隔。比如，规则为 t: p1 p2，那么 `$^ `就指代 p1 p2 。

- `$*`

  `$*` 指代匹配符 % 匹配的部分， 比如% 匹配 f1.txt 中的f1 ，`$* `就表示 f1。

- `$(@D) 和 $(@F)`

  $(@D) 和 $(@F) 分别指向 $@ 的目录名和文件名。比如，$@是 src/input.c，那么$(@D) 的值为 src ，$(@F) 的值为 input.c。

- `$(<D) 和 $(<F)`

  `$(<D) 和 $(<F) `分别指向` $< `的目录名和文件名。

### 循环和判断

- 判断

  ```makefile
  ifeq ($(CC),gcc)
  	echo 'y'
  else
  	echo 'n'
  endif
  ```

- 循环

  ```makefile
  LIST = one two three
  all:
      for i in $(LIST); do \
          echo $$i; \
      done
  
  ```

### 函数

Makefile 还可以使用函数 

```makefile
$(function arguments)
//或者
${function arguments}
```

- **（1）shell 函数**

  shell 函数用来执行 shell 命令

   ```
   srcfiles := $(shell echo src/{00..99}.txt)
   ```

   

**2）wildcard 函数**

wildcard 函数用来在 Makefile 中，替换 Bash 的通配符。

 ```
 srcfiles := $(wildcard src/*.txt)
 ```

**（3）subst 函数**

subst 函数用来文本替换，格式如下。

 ```
 $(subst from,to,text)
 ```

下面的例子将字符串"feet on the street"替换成"fEEt on the strEEt"。

```
 $(subst ee,EE,feet on the street)
```
