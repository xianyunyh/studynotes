## golang rune 和int 之间的区别

>  rune is an alias for int32 and is equivalent to int32 in all ways. It is // used, by convention, to distinguish character values from integer values.

 

官方的解释，就是rune 在大部分情况都等于`int32`

golang中string底层是通过byte数组实现的。 

```go
package main

import "fmt"

func main() {

    var str = "hello 你好"
    fmt.Println("len(str):", len(str)) //12
    fmt.Println(len([]rune(str))) //8

}

```

 

- byte 等同于int8，常用来处理ascii字符
- rune 等同于int32,常用来处理unicode或utf-8字符

1字节=8位(1 byte = 8bit【位】) 
在英文字符中一个字符占一个字节。
字符0 在ascii编码中就是0011 0000
换成十进制就是48

都是标识原始字符数据。

 

 
