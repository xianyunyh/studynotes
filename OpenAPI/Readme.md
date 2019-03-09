OpenAPI的前身是swagger规范。Swagger是一套有助于前后端分离，接口管理和测试工具集。 

## openapi

SwaggerTM是一个用于描述和文档化RESTful接口的项目。  Swagger规范定义了一系列的文件，用以描述API。这些文件可以被Swagger-UI项目用于展示API，也可以被Swagger-Codegen项目用于生成代码。一些其他的工具也可以利用这些文件，例如测试工具。 

主要的工具包括三个 `swagger-ui`、`swagger-codegen`、`swagger-editor`

- swagger-ui 主要用显示文档接口
- swagger-codegen 主要用于生成各种客户端的sdk代码
- swagger-editor 主要用于编辑swagger文件



### openapi.yaml

openapi文件使用yaml进行编写，也可以使用json

```yaml
openapi: 3.0.0
info:
  title: Sample API
  description: Optional multiline or single-line description in [CommonMark](http://commonmark.org/help/) or HTML.
  version: 0.1.9
 
servers:
  - url: http://api.example.com/v1
    description: Optional server description, e.g. Main (production) server
  - url: http://staging-api.example.com
    description: Optional server description, e.g. Internal staging server for testing
 
paths:
  /users:
    get:
      summary: Returns a list of users.
      description: Optional extended description in CommonMark or HTML.
      responses:
        '200':    # status code
          description: A JSON array of user names
          content:
            application/json:
              schema: 
                type: array
                items: 
                  type: string
```

### Metadata

每个OpenAPI规范都以提及规范格式版本的openapi关键字开始。 该版本定义了API规范的整体结构 - 您可以记录什么以及如何记录它。
此前，格式字段包含两个组件（例如2.0）。 从版本3开始，OpenAPI正在使用包含三个组件的语义版本。 最新版本是3.0.0：

info部分包含API信息：title，description（可选），version：

- title是您的API名称。
- description是关于您的API的扩展信息。 它可以是多行的，并支持用于富文本表示的Markdown的CommonMark方言。 在CommonMark提供的范围内支持HTML（请参阅CommonMark 0.27规范中的HTML块）。
- version是一个任意的字符串，用于指定您的API的版本（不要将其与文件版本或openapi版本混淆）。 您可以使用major.minor.patch之类的语义版本，或1.0至beta或2017-07-25之类的任意字符串。
- info还支持联系信息，许可证，服务条款和其他详细信息的其他关键字。

将API的一般信息纳入规范被认为是一种很好的做法：版本号，许可证说明，联系人数据，文档链接等。我们特别建议为公共可用的API执行此操作; 因为这可以增加用户对服务的信心，贵公司提供。

要指定API元数据，请使用顶级`info`对象的属性：

```yaml
openapi: 3.0.0
info:

  # You application title. Required.
  title: Sample Pet Store App

  # API version. You can use semantic versioning like 1.0.0, 
  # or an arbitrary string like 0.99-beta. Required.
  version: 1.0.0 

  # API description. Arbitrary text in CommonMark or HTML.
  description: This is a sample server for a pet store.

  # Link to the page that describes the terms of service.
  # Must be in the URL format.
  termsOfService: http://example.com/terms/

  # Contact information: name, email, URL.
  contact:
    name: API Support
    email: support@example.com
    url: http://example.com/support

  # Name of the license and a URL to the license description.
  license:
    name: Apache 2.0
    url: http://www.apache.org/licenses/LICENSE-2.0.html

  # Link to the external documentation (if any).
  # Code or documentation generation tools can use description as the text of the link. 
  externalDocs:
    description: Find out more
    url: http://example.com
```

`title`和`version`属性是必需的，其他都是可选的。

### Servers

服务器部分指定API服务器和基本URL。 您可以定义一个或多个服务器，例如生产环境和开发环境（sandbox）。

所有API路径都与服务器URL有关。 在上面的示例中，/ users表示http://api.example.com/v1/users或http://staging-api.example.com/v1/users，具体取决于所使用的服务器。

```yaml
servers:
  - url: http://api.example.com/v1
    description: Optional server description, e.g. Main (production) server
  - url: http://staging-api.example.com
    description: Optional server description, e.g. Internal staging server for testing
```

### Paths

Paths定义了API中的各个端点（路径）以及这些端点支持的HTTP方法（操作）。 例如，GET /users可以描述为：

操作定义包括参数，请求主体（如果有），可能的响应状态代码（如200 OK或404 Not Found）和响应内容。

有关更多信息，请参阅路径和操作。

```yaml
paths:
  /users:
    get:
      summary: Returns a list of users.
      description: Optional extended description in CommonMark or HTML
      responses:
        '200':
          description: A JSON array of user names
          content:
            application/json:
              schema: 
                type: array
                items: 
                  type: string
```



### Parameters

操作可以通过URL路径（/ users / {userId}），查询字符串（/ users？role = admin），标头（X-CustomHeader：Value）或Cookie（Cookie：debug = 0）传递参数。 您可以定义参数的数据类型，格式，它们是必需的还是可选的以及其他详细信息：

```yaml
paths:
  /user/{userId}:
    get:
      summary: Returns a user by ID.
      parameters:
        - name: userId
          in: path
          required: true
          description: Parameter description in CommonMark or HTML.
          schema:
            type : integer
            format: int64
            minimum: 1
      responses: 
        '200':
          description: OK
```

### Request Body

如果操作发送请求主体，请使用requestBody关键字来描述主体内容和媒体类型。

有关更多信息，请参阅描述请求正文。

```yaml
paths:
  /users:
    post:
      summary: Creates a user.
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              properties:
                username:
                  type: string
      responses: 
        '201':
          description: Created
```



### Responses

对于每个操作，可以定义可能的状态代码，例如200 OK或404 Not Found，以及响应主体模式。 模式可以通过$ ref内联或引用来定义。 您还可以为不同的内容类型提供示例响应：

请注意，响应HTTP状态代码必须用引号引起来：“200”（OpenAPI 2.0不需要这样做）。
有关更多信息，请参阅描述响应。



### Input and Output Models

全局组件/模式部分允许您定义API中使用的通用数据结构。 无论何时需要模式，它们都可以通过$ ref进行引用 - 在参数，请求主体和响应主体中。



### Authentication

securitySchemes和security关键字用于描述您的API中使用的身份验证方法。



## Swagger 2与OpenAPI 3的区别

![img](https://upload-images.jianshu.io/upload_images/10155679-76de82b1da8282bb.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/418/format/webp) ![img](https://upload-images.jianshu.io/upload_images/10155679-dadb513b42e951db.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/401/format/webp) 

### 网址结构

Swagger 2.0 基础URL结构

```yaml
info:  
  title: Swagger Sample App
  host: example.com  
  basePath: /v1  
  schemes: ['http', 'https']
```

OpenAPI 3.0 基础URL结构

```yaml
 servers:  
 - url: https://{subdomain}.site.com/{version}
   description: The main prod server
     variables:
       subdomain:
         default: production
       version:
         enum:
           - v1
           - v2
         default: v2
```



###  组件

Swagger 2中的definitions概念在OpenAPI 3中标准化为【组件】，可以在多个地方重复使用且可定义，组件列表如下：

- 响应 responses （已存在）
- 参数 parameters （已存在）
- 示例 examples （新）
- 请求体 requestBodies（新）
- 标题 headers （新）
- 链接 links （新）
- 回调 callbacks （新）
- 模式 schemas （更新）
- 安全体系 securitySchemes（更新）

 

###  请求格式

**Swagger 2**

```
/pets/{petId}:
  post:
    parameters:
    - name: petId
      in: path
      description: ID of pet to update
      required: true
      type: string
    - name: user
      in: body
      description: user to add to the system
      required: true
      schema:
        type: array
        items:
          type: string
```

Swagger 2最容易混淆的方面之一是body / formData。它们是参数的子集，只能有一个或另一个，如果你使用body，格式与参数的其余部分不同（只能使用body参数，名称不相关，格式不同，等等）

**OpenAPI 3**

```
/pets/{petId}:
  post:
    requestBody:
      description: user to add to the system
      required: true
      content:
        application/json: 
          schema:
            type: array
            items:
              $ref:     '#/components/schemas/Pet'
          examples:
            - name: Fluffy
              petType: Cat
            - http://example.com/pet.json
    parameters:
      - name: petId
        in: path
        description: ID of pet to update
        required: true
        type: string
```

现在，body已经被移入了它自己的叫做requestBody的部分，并且formData也已经被合并到里面。另外，cookies已经被添加为参数类型（除了现有的标题，路径和查询选项之外）。

requestBody有很多新的功能。现在可以提供example（或数组examples）for requestBody。这是非常灵活的（你可以传入一个完整的例子，一个参考，甚至是一个URL的例子）。

新的requestBody支持不同的媒体类型（content是一个MIME_Types的数组，像application/json或者text/plain，当然你也可以用*/*捕捉所有）。

对于参数，你有两个选择你想如何定义它们。你可以定义一个“模式”（像原来2.0那样），可以尽情地描述项目。如果更复杂，可以使用“requestBody”中的“content”。

###  响应格式

通配符的出现，我们可以以“4XX”来定义响应，而不必单独定义每个响应码。
响应和响应头可以更复杂。可以使用“content”对象（如在请求中）的有效载荷。

### 回调概念

```
 myWebhook:
  '$request.body#/url':
    post:
      requestBody:
        description: Callback payload
      content:
        'application/json':
          schema:
            $ref: '#/components/schemas/SomePayload'
          responses:
            200:
              description: webhook processed!
```

 

###  链接

链接是OpenAPI 3最有趣的补充之一。它有点复杂，但可能非常强大。这基本上是描述“下一步是什么”的一种方式。

比方说，你得到一个用户，它有一个addressId。这addressId本身是无用的。您可以使用链接来展示如何“扩大”，并获得完整的地址。

```
paths:  
  /users/{userId}:
    get:
      responses:
        200:
          links:
            address:
              operationId: getAddressWithAddressId
              parameters:
                addressId: '$response.body#/addressId'
```

在“/ users / {userId}”的响应中，我们找回了一个addressId。“链接”描述了如何通过引用“$ response.body＃/ addressId”来获取地址。

另一个用例是分页。如果要获取100个结果，links可以显示如何获得结果101-200。它是灵活的，这意味着它可以处理任何分页方案limits来cursors。

 

###  安全

**Swagger 2**

```
securityDefinitions:  
  UserSecurity:
    type: basic
  APIKey:
    type: apiKey
    name: Authorization
    in: header
security:  
  - UserSecurity: []
  - APIKey: []
```

**OpeanAPI 3**

```
components:  
  securitySchemes:
    UserSecurity:
      type: http
      scheme: basic
    APIKey:
      type: http
      scheme: bearer
      bearerFormat: TOKEN
security:  
  - UserSecurity: []
  - APIKey: []
```

一堆安全性的变化！它已被重命名，OAuth2流名已更新，您可以有多个流，并且支持OpenID Connect。“基本”类型已被重命名为“http”，现在安全可以有一个“方案”和“bearerFormat”。

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 