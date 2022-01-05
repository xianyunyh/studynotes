## json 序列化

### 1. omitempty

当值为空的时候，序列化会忽略掉该字段
```go
type Demo struct {
	Ids *[]int `json:"ids,omitempty"`
}

func main() {
	var arr []int
	d := &Demo{
		Ids: &arr,
	}
	b, _ := json.Marshal(d)
	fmt.Println(string(b)) // {"ids":null}
  
  d2 := &Demo{Ids: nil}
  b,_ := json.Marshal(d2)
  fmt.Println(string(b)) // {}
}

````
