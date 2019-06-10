json 和struct、map之间的转换

### 1. json 转map

```go
package main

import (
	"encoding/json"
	"fmt"
)
func main()  {

	jstring := `{"id":1,"name":"zhang"}`
	jMap := make(map[string]interface{})
	_ = json.Unmarshal([]byte(jstring),&jMap)
}
```

### 2. json 转sturct

利用结构体的标签`tag`

```
package main

import (
	"encoding/json"
	"fmt"
)

type User struct {
	Id int `json:"id"`
	Name string `json:"name"`
}
func main()  {

	jstring := `{"id":1,"name":"zhang"}`
	jStruct := User{}
	_ = json.Unmarshal([]byte(jstring),&jStruct)
	fmt.Println(jStruct.Id)
}
```

### 3. map 转 json

```go
package main

import (
	"encoding/json"
	"fmt"
)
func main()  {
	map1 := map[string]string{"id":"张三","name":"李四"}
	sMap,_ := json.Marshal(map1)
	fmt.Println(string(sMap))
}
```

### 4. struct 转 json

```go
package main

import (
	"encoding/json"
	"fmt"
)

type User struct {
	Id int `json:"id"`
	Name string `json:"name"`
}
func main()  {
	user1 := User{Id:1,Name:"王二"}
	sMap1,_ := json.Marshal(user1)
	fmt.Println(string(sMap1))
}
```

### 5. map 转struct

需要安装一个第三方库

在命令行中运行： `go get github.com/goinggo/mapstructure`

```go
package main

import (
	"encoding/json"
	"fmt"
	"github.com/goinggo/mapstructure"
)

type User struct {
	Id int `json:"id"`
	Name string `json:"name"`
}
func main()  {
	map2:= map[string]interface{}{"Id":12,"Name":"李四"}
	user2 := User{}
	_ = mapstructure.Decode(map2,&user2)
	fmt.Println(user2.Id)
}

```



### 5. sturct 转map

```go
package main

import (
	"encoding/json"
	"fmt"
	"github.com/goinggo/mapstructure"
	"reflect"
)

type User struct {
	Id int `json:"id"`
	Name string `json:"name"`
}
func Struct2Map(obj interface{}) map[string]interface{} {
	t := reflect.TypeOf(obj)
	v := reflect.ValueOf(obj)

	var data = make(map[string]interface{})
	for i := 0; i < t.NumField(); i++ {
		data[t.Field(i).Name] = v.Field(i).Interface()
	}
	return data
}
func main()  {
	user1 := User{Id:1,Name:"王二"}
	map3 := Struct2Map(user1)
	fmt.Println(map3)
}

```

