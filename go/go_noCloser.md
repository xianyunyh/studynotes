在http handler之前需要对body进行处理就带来了麻烦
由于 Request.Body 为公共变量,我们在对原有的buffer读取完成后,只要手动创建一个新的buffer然后以同样接口形式替换掉原有的Request.Body即可。


```go
var bodyBytes []byte // 我们需要的body内容

// 从原有Request.Body读取
bodyBytes, err := ioutil.ReadAll(c.Request.Body)
if err != nil {
	return 0, nil, fmt.Errorf("Invalid request body")
}

// 新建缓冲区并替换原有Request.body
c.Request.Body = ioutil.NopCloser(bytes.NewBuffer(bodyBytes))

// 当前函数可以使用body内容
_ := bodyBytes
```
