
## **Go时间戳和日期字符串的相互转换**

获取时间戳用  `time.Now().Unix()`，格式化时间用 `t.Format`，解析时间用`time.Parse`。

格式化时间格式 `2006-01-02 15:04:05` 记忆方法 1月2号3点4分5秒6年

```go
import (
	"fmt"
  "time"
)
func main() {
  //获取当前时间戳
  fmt.Println(time.Now().Unix()) 
  timeTpl := "2006-01-02 15:04:05"
  fmt.Println(time.Now.Unix().Format(timeTpl))
  t := "2001-01-02 13:09:21"
  time.Parse(timeTpl,t)
}
```

- 时间戳转时间

  ```go
  timestamp := 1564483130
  time.Unix(int64(timestamp),1).Format("2006-01-02 15:04:05")
  ```

- 时间转时间戳

  ```go
  t := "2018-01-02 01:02:03"
  T,_ := t.Parse("2006-01-02 15:04:05",t)
  T.Unix()
  ```

  

**格式化时间字符串**

- 月份 1,01,Jan,January

- 日　 2,02,_2

- 时　 3,03,15,PM,pm,AM,am

- 分　 4,04

- 秒　 5,05

- 年　 06,2006

- 周几 Mon,Monday

- 时区时差表示 -07,-0700,Z0700,Z07:00,-07:00,MST

- 时区字母缩写 MST
