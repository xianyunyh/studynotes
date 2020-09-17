## HTTP代理

http代理通常有两种方式

- 中间人代理
- 隧道代理

### 中间人代理

![img](https://st.imququ.com/i/webp/static/uploads/2015/11/web_proxy.png.webp)

就是由代理服务器解析客户端的请求，然后发送给目标服务器，然后接收目标服务器的数据，再写回客户端的链接。

### 隧道代理

隧道代理的原因也可以用一句话来总结：

> 代理服务器和真正的服务器之间建立起 TCP 连接，然后在客户端和真正服务器端进行数据的直接转发。

下图是《HTTP 权威指南》书中的插图，它讲解了客户端通过隧道代理连接 HTTPS 服务器的过程。

![img](https://st.imququ.com/i/webp/static/uploads/2015/11/web_tunnel.png)

- （a）客户端先发送 CONNECT 请求到隧道代理服务器，告诉它建立和服务器的 TCP 连接（因为是 TCP 连接，只需要 ip 和端口就行，不需要关注上层的协议类型）
- （b，c）代理服务器成功和后端服务器建立 TCP 连接
- （d）代理服务器返回 `HTTP 200 Connection Established` 报文，告诉客户端连接已经成功建立
- （e）这个时候就建立起了连接，所有发给代理的 TCP 报文都会直接转发，从而实现服务器和客户端的通信

#### Connect 请求

`CONNECT` 请求的内容和其他 HTTP 方法的语法一样，只不过它在状态栏（status line）指定了真正服务器的地址。请求 URI 替换成了 hostname 和 port 的字符串，比如：

```bash
CONNECT realserver.com:443 HTTP/1.0
User-Agent: GoProxy
```

而其他 HTTP 请求的状态栏对应位置是路径地址，比如：

```bash
GET /about HTTP/1.0
User-Agent: GoProxy
```

知道了 hostname 和 port，代理服务器就能正确地建立，才能够继续后面的访问。需要注意的是，客户端应该尽量少地暴露其他信息，最好只有状态栏一行的内容，因为 `CONNECT` 请求是没有经过加密的。如果想通过这种方式进行 HTTPS 安全访问，那么不要在 `CONNECT` 请求中暴露敏感数据（比如 cookie）是必须的。

如果代理服务器正确接受了 `CONNECT` 请求，并且成功建立了和后端服务器的 TCP 连接，它应该返回 `200` 状态码的应答，按照大多数的约定为 `200 Connection Establised`。应答也不需要包含其他的头部和 body，因为后续的数据传输都是直接转发的，代理不会分析其中的内容。



```go
package main

import (
    "fmt"
    "io"
    "net"
    "net/http"
)

type Pxy struct {}

func NewProxy() *Pxy {
    return &Pxy{}
}

// ServeHTTP is the main handler for all requests.
func (p *Pxy) ServeHTTP(rw http.ResponseWriter, req *http.Request) {
    fmt.Printf("Received request %s %s %s\n",
        req.Method,
        req.Host,
        req.RemoteAddr,
    )

    if req.Method != "CONNECT" {
        rw.WriteHeader(http.StatusMethodNotAllowed)
        rw.Write([]byte("This is a http tunnel proxy, only CONNECT method is allowed."))
        return
    }

    // Step 1
    host := req.URL.Host
    hij, ok := rw.(http.Hijacker)
    if !ok {
        panic("HTTP Server does not support hijacking")
    }

    client, _, err := hij.Hijack()
    if err != nil {
        return
    }

    // Step 2
    server, err := net.Dial("tcp", host)
    if err != nil {
        return
    }
    client.Write([]byte("HTTP/1.0 200 Connection Established\r\n\r\n"))

    // Step 3
    go io.Copy(server, client)
    io.Copy(client, server)
}

func main() {
    proxy := NewProxy()
    http.ListenAndServe("0.0.0.0:8080", proxy
}
```



##参考链接

- [HTTP 代理原理及实现](https://imququ.com/post/web-proxy.html)

