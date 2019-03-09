所有的API端点都是相对于基本URL的。例如，假设https://api.example.com/v1的基本URL，/ users端点指的是https://api.example.com/v1/users。

```
https://api.example.com/v1/users?role=admin&status=active
\ __________________ / \__/ \ ______________________ /
         服务器URL      端点路径        查询参数
```



在OpenAPI 3.0中，您可以使用servers数组为您的API指定一个或多个基本URL。服务器将替换OpenAPI 2.0中使用的主机，basePath和schemes关键字。

每个服务器都有一个url和一个可选的Markdown格式描述。

```yaml
servers:
  - url: https://api.example.com/v1 ＃需要“url：”前缀
```



您也可以有多个servers，例如生产和沙箱：

```yaml
servers:
  - url: https://api.example.com/v1
    description: Production server (uses live data)
  - url: https://sandbox-api.example.com:8443/v1
    description: Sandbox server (uses test data)
```



服务器URL格式
服务器URL格式遵循RFC 3986，通常如下所示：

```yaml
scheme://host[:port][/path]
```

主机可以是名称或IP地址（IPv4或IPv6）。 OpenAPI 3.0也支持WebSocket方案ws：//和wss：//来自OpenAPI 2.0。

有效的服务器URL示例：

```
https://api.example.com
https://api.example.com:8443/v1/reports
http://localhost:3025/v1
http://10.0.81.36/v1
ws://api.example.com/v1
wss://api.example.com/v1
/v1/reports
/
//api.example.com
```

如果服务器URL是相对的，它将根据托管给定OpenAPI定义文件的服务器进行解析（更多内容在下面）。

注意：服务器URL不能包含查询字符串参数。例如，这是无效的：

```
https://api.example.com/v1?route=
```



如果servers阵列未提供或为空，则服务器URL默认为/：

```yaml
servers:
  - url: /
```

服务器模板
可以使用变量对服务器URL的任何部分 - 方案，主机名或其部分，端口，子路径 - 进行参数化。变量在服务器url中用{花括号}表示，如下所示：

```yaml
servers:
  - url: https://{customerId}.saas-app.com:{port}/v2
    variables:
      customerId:
        default: demo
        description: Customer ID assigned by the service provider
      port:
        enum:
          - '443'
          - '8443'
        default: '443'
```



与路径参数不同，服务器变量不使用模式。相反，它们被假定为字符串。变量可以具有任意值，或者可以限制为枚举。在任何情况下，都需要默认值，如果客户端不提供值，将使用该值。变量描述是可选的，但对于具有和支持用于富文本格式的Markdown（CommonMark）很有用。

服务器模板的常见用例：

指定多个协议（例如HTTP vs HTTPS）。
SaaS（托管）应用程序，每个客户都有自己的子域。
区域服务器在不同地理区域（例如：亚马逊网络服务）。
针对SaaS和内部部署API的单一API定义。

例子
HTTPS和HTTP

```yaml
servers:
  - url: http://api.example.com
  - url: https://api.example.com
```



或者使用模板：

```yaml
servers:
  - url: '{protocol}://api.example.com'
    variables:
      protocol:
        enum:
          - http
          - https
        default: https
```



注意：这两个示例在语义上是不同的。第二个示例明确地将HTTPS服务器设置为默认服务器，而第一个示例没有默认服务器。

生产，开发和分期

```yaml
servers:
  - url: https://{environment}.example.com/v2
    variables:
      environment:
        default: api    # Production server
        enum:
          - api         # Production server
          - api.dev     # Development server
          - api.staging # Staging server
```

SaaS和内部部署

不同地理区域的区域端点

```yaml
servers:
  - url: https://{region}.api.cognitive.microsoft.com
    variables:
      region:
        default: westus
        enum:
          - westus
          - eastus2
          - westcentralus
          - westeurope
          - southeastasia
```



覆盖服务器
全局服务器数组可以在路径级别或操作级别上被覆盖。如果某些端点使用与API其余部分不同的服务器或基本路径，这很方便。常见的例子是：

```yaml
servers:
  - url: https://api.example.com/v1
 
paths:
  /files:
    description: File upload and download operations
    servers:
      - url: https://files.example.com
        description: Override base path for all operations with the /files path
    ...
 
  /ping:
    get:
      servers:
        - url: https://echo.example.com
          description: Override base path for the GET /ping operation
```



文件上传和下载操作的基本URL不同，
弃用但仍然有用的终端。

```yaml
servers:
  - url: https://api.example.com/v1
 
paths:
  /files:
    description: File upload and download operations
    servers:
      - url: https://files.example.com
        description: Override base path for all operations with the /files path
    ...
 
  /ping:
    get:
      servers:
        - url: https://echo.example.com
          description: Override base path for the GET /ping operation
        
```



相对URL
服务器阵列中的URL可以是相对的，例如/ v2。在这种情况下，URL已解析
此外，API定义中的几乎所有其他URL都可以相对于服务器URL进行指定，包括OAuth 2流程端点，termsOfService，外部文档URL等。

请注意，如果使用多台服务器，则预计在所有服务器上都会存在由相对URL指定的资源。