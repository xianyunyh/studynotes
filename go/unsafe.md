利用golang unsafe读取私有变量
unsafe.Pointer是一种特殊意义的指针，它可以包含任意类型的地址

```go
//a.go
type bodyJson struct {
  v interface{}
}

func Body(a interface{}) *bodyJson{

  return &bodyJson{v:a}
}

//b.go

type Temp struct {
  v interface{}
}

s := a.Body(1212)
t := (*Temp)(unsafe.Pointer(&s))

fmt.Println(t.v)


```
