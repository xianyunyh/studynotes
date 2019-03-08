OpenAPI的前身是swagger规范。Swagger是一套有助于前后端分离，接口管理和测试工具集。 

## swagger

SwaggerTM是一个用于描述和文档化RESTful接口的项目。  Swagger规范定义了一系列的文件，用以描述API。这些文件可以被Swagger-UI项目用于展示API，也可以被Swagger-Codegen项目用于生成代码。一些其他的工具也可以利用这些文件，例如测试工具。 

主要的工具包括三个 `swagger-ui`、`swagger-codegen`、`swagger-editor`

- swagger-ui 主要用显示文档接口
- swagger-codegen 主要用于生成各种客户端的sdk代码
- swagger-editor 主要用于编辑swagger文件



### swagger.yaml

swagger文件使用yaml进行编写，也可以使用json

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



### Servers

服务器部分指定API服务器和基本URL。 您可以定义一个或多个服务器，例如生产环境和开发环境（sandbox）。

所有API路径都与服务器URL有关。 在上面的示例中，/ users表示http://api.example.com/v1/users或http://staging-api.example.com/v1/users，具体取决于所使用的服务器。



### Paths

Paths定义了API中的各个端点（路径）以及这些端点支持的HTTP方法（操作）。 例如，GET /users可以描述为：

操作定义包括参数，请求主体（如果有），可能的响应状态代码（如200 OK或404 Not Found）和响应内容。

有关更多信息，请参阅路径和操作。

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