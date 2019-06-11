##  package

- 每个go源码文件必须拥有一个package声明，表示golang代码所在的package
- 要生成golang执行程序，必须有一个名为**main**的package。在这个package里面必须有一个**main**的函数 **main包+main函数**
- 同一个路径下只能存在一个package。一个package可以拆解成多个源文件

### 工程目录结构

```
study
|---src
|--a
	|--add.go
	|--sum.go
```

add.go

```go
package a

type A struct{
    
}
function Add() {
    
}
```

### import 的用法

import 调用原理

![img](https://images2015.cnblogs.com/blog/526315/201601/526315-20160125172231942-864886599.png) 

- import 包名

  ```go
  package main
  import "a"
  import (
  	"a"
  )
  ```

  

- 点(.)操作

  点操作，意思是导入包之后，调用该包的时候，可以省略包名

  ```go
  package main
  import . "fmt"
  
  func main() {
      Println("hello world")
  }
  ```

- 别名操作

  别名操作的含义是：将导入的包命名为另一个容易记忆的别名 

  ```go
  import p "fmt"
  
  func main() {
      p.Println("hello")
  }
  ```

- 下划线操作。

  线（`_`）操作的含义是：导入该包，但不导入整个包，而是执行该包中的init函数，因此无法通过包名来调用包中的其他函数。使用下划线（_）操作往往是为了注册包里的引擎，让外部可以方便地使用 就是类型与构造

  ```go
  package a
  
  func init() {
      fmt.Println("init")
  }
  //main
  package main
  import _ "a"
  func main () {
      
  }
  ```

   
