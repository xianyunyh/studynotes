Go 语言结构体是实现自定义类型的一种重要数据类型。

结构体是复合类型（composite types），它由一系列属性组成，每个属性都有自己的类型和值的，结构体通过属性把数据聚集在一起。

**结构体是值类型，因此可以通过 new 函数来创建。** 

我们一般的惯用方法是：t := new(T)，变量 t 是一个指向 T的指针，此时结构体字段的值是它们所属类型的零值。 

我们通过对结构体使用new(T)，struct{filed:value}两种方式来声明初始化，这两种方式分别得到*T，和T。 

```go
t := new (T) //返回指向T的指针
t1 := &T{}
```



表达式 new(Type) 和 &Type{} 是等价的。&struct1{a, b, c} 是一种简写，底层仍然会调用 new () 

使用点号符“.”可以获取结构体字段的值：structname.fieldname。在 Go 语言中“.”叫选择器（selector）。无论变量是一个结构体类型还是一个结构体类型指针，都使用同样的选择表示法来引用结构体的字段： 

```go
type User{
    name string
    age int
}

u1 := User{"张三",11}
fmt.Println(u1.age)
```

## 结构体特性

结构体的内存布局 Go 语言中，结构体和它所包含的数据在内存中是以连续块的形式存在的，即使结构体中嵌套有其他的结构体，这在性能上带来了很大的优势。 

- 递归结构体 结构体类型可以通过引用自身（指针类型）来定义。这在定义链表或二叉树的节点时特别有用，此时节点包含指向临近节点的链接。 

- 使用工厂方法 通过参考应用可见性规则，我们可以设定结构体名不能导出，就可以达到使用 new 函数，强制使用工厂方法的目的。

  ```go
  type matrix struct {
      ...
  }
  
  func NewMatrix(params) *matrix {
      m := new(matrix) // 初始化 m
      return m
  }
  ```

- 带标签的结构体

  结构体中的字段除了有名字和类型外，还可以有一个可选的标签（tag）：它是一个附属于字段的字符串，可以是文档或其他的重要标记。标签的内容不可以在一般的编程中使用，只有 reflect 包能获取它。

  reflect包可以在运行时自省类型、属性和方法，如变量是结构体类型，可以通过 Field 来索引结构体的字段，然后就可以使用 Tag 属性。

  ```
  package main
  
  import (
  	"fmt"
  	"reflect"
  )
  
  type Student struct {
  	name string "学生名字"          // 结构体标签
  	Age  int    "学生年龄"          // 结构体标签
  	Room int    `json:"Roomid"` // 结构体标签
  }
  
  func main() {
  	st := Student{"Titan", 14, 102}
  	fmt.Println(reflect.TypeOf(st).Field(0).Tag)
  	fmt.Println(reflect.TypeOf(st).Field(1).Tag)
  	fmt.Println(reflect.TypeOf(st).Field(2).Tag)
  }
  
  程序输出：
  学生名字
  学生年龄
  json:"Roomid"
  ```

  

## 匿名

Go语言结构体中可以包含一个或多个匿名（内嵌）字段，即这些字段没有显式的名字，只有字段的类型是必须的，此时类型就是字段的名字（这一特征决定了在一个结构体中，**每种数据类型只能有一个匿名字段**）。 

```go
type Human struct {
	name string
}

type Student struct { // 含内嵌结构体Human
	Human // 匿名（内嵌）字段
	int   // 匿名（内嵌）字段
}
```

**Go语言结构体中这种含匿名（内嵌）字段和内嵌结构体的结构，可近似地理解为面向对象语言中的继承概念。**

Go 语言中的继承是通过内嵌或者说组合来实现的，所以可以说，在 Go 语言中，相比较于继承，组合更受青睐。
