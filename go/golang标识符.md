今天看公众号文章的时候，然后引出了一个问题。也发现对`go` 的一些细节不是很了解

```go
func (int int) int {
  return int +int
}
//出错
func (default int) int {
  return default + default
}
```

这个代码第一眼一看 ，就是错的。我们都知道int是内置类型。但是能不能作为标识符传参，以前没有了解过，主要是我们也不会这么去写，但是看到文章中，说不会出错，上班的时候，特意尝试了一下，居然正常运行。赶紧翻阅资料去查下原因。

> default 属于关键字,不能作为标识符。int  是预定义标识符，可以在局部使用

Go语言的语言符号又称记法元素，共包括5类，标签符（`identifier`）、关键字（`keyword`）、操作符（`operator`）、分隔符（`delimiter`）、字面量（`literal`），它们是组成Go语言代码和程序的最基本单位

## 标识符

标识符（变量名）就是表示代表一个变更或者一个类型。标识符是由若干字母、下划线（_）和数字组成的字符序列，第一个字符必须为字母。

`Go` 中还存在一些特殊的标识符，叫做预定义标识符

- 所有基本数据类型的名字 比如整型int
- 接口类型的error
- 常量的`true` 、`false` 、`iota`
- 所有内建函数的名称，即 `append`、`cap`、`close`、`complex`、`copy`、`delete`、`imag`、`len`、`make`、`new`、`panic`、`print`、`println`、`real`和 `recove`

- **预定义标识符不能作为变量名，但是可以在内部使用**

  ```go
  func testString() {
  	string := "111"
  	log.Println(string)
  }
  
  //下面在全局定义会报错
  var string string = ""
  ```

  

## 关键字

关键字是指被编程语言保留页不让编程人员作为标识符使用的字符序列。因此，关键字也称为保留字。

Go 语言中所有的关键只有25个：

1. 程序声明：`import`、`package`
2. 程序实体声明和定义：`chan`、`const`、`func`、`interface`、`map`、`struct`、`type`、`var`
3. 程序流程控制：`go`、`select`、`break`、`case`、`continue`、`default`、`defer`、`else`、`fallthrough`、`for`、`goto`、`if`、`range`、`return`、`switch`

**golang 关键字不能作为标识符**

```go
var default int //error
```

## 字面量

字面量就是表示值的一种标记法。简单的说就是一种语法糖

1. 用于表示基础数据类型值的各种字面量。
2. 用户构造各种自定义的复合数据类型的类型字面量
3. 用于表示复合数据类型的值的复合字面量

```go
var slice1 = []int{1,2}
var map1 = map[string]string{"a":"b"}
var struct1 = struct{}
```

## 类型

一个类型确定了一类值的集合，以及可以在这些值上施加的操作。类型可以由类型名称或者类型字面量指定，类型分为基本类型和复合类型，基本类型的名称可以代表其自身

- 字符string 
- 布尔bool
- 数值类型： byte、int/uint、int8/uint8、int16/uint16、int32/uint32、int64/uint64、float32、float64、complex64、complex128，共18个
- 复合类型 Array（数组）、Struct（结构体）、Function（函数）、Interface（接口）、Slice（切片）、Map（字典）、Channel（通道）以及Pointer（指针)

复合类型一般由若干（包括0）个其他已被定义的类型组合而成

- [https://mp.weixin.qq.com/s/F0QTzwa25e38vxPAuq0xVA][https://mp.weixin.qq.com/s/F0QTzwa25e38vxPAuq0xVA]
