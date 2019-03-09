# swagger和openAPI: 描述响应



## 描述响应

API规范需要指定`responses`所有API操作。每个操作必须至少定义一个响应，通常是成功的响应。响应由其**HTTP状态代码和响应正文**和/或标题中返回的数据定义。

这是一个简单的例子：

```yaml
paths:
  /ping:
    get:
      responses:
        '200':
          description: OK
          content:
            text/plain:
              schema:
                type: string
                example: pong
```

### 响应媒体类型

API可以用各种媒体类型进行响应。JSON是数据交换中最常用的格式，但不是唯一可能的格式。

要指定响应媒体类型，请`content`在操作级别使用关键字。

```yaml
yapaths:
  /users:
    get:
      summary: Get all users
      responses:
        '200':
          description: A list of users
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ArrayOfUsers'
            application/xml:
              schema:
                $ref: '#/components/schemas/ArrayOfUsers'
            text/plain:
              schema:
                type: string

  # This operation returns image
  /logo:
    get:
      summary: Get the logo image
      responses:
        '200':
          description: Logo image in PNG format
          content:
            image/png:
              schema:
                type: string
                format: binary
```



### HTTP状态码

在下`responses`，每个响应定义以状态代码开始，例如200或404.一个操作通常会返回一个成功的状态代码和一个或多个错误状态。要定义一系列响应代码，您可以使用以下范围定义：1XX，2XX，3XX，4XX和5XX。如果使用显式代码定义响应范围，则显式代码定义优先于该代码的范围定义。

每个响应状态都需要一个`description`。例如，您可以描述错误响应的条件。Markdown（CommonMark）可用于富文本表示。

```yaml
      responses:
        '200':
          description: OK
        '400':
          description: Bad request. User ID must be an integer and larger than 0.
        '401':
          description: Authorization information is missing or invalid.
        '404':
          description: A user with the specified ID was not found.
        '5XX':
          description: Unexpected error.
```

请注意，API规范不一定需要涵盖*所有可能的* HTTP响应代码，因为它们可能不会提前知道。但是，预计将涵盖成功的回应和任何*已知的*错误。对于“已知错误”，例如，对于通过ID返回资源的操作，或者对于无效操作参数，返回400错误请求响应，则表示404 Not Found响应。

### 响应体

所述`schema`关键字被用于描述响应主体。模式可以定义：

- 一个`object`或一个`array`- 通常与JSON和XML API一起使用，
- 原始数据类型，如数字或字符串 - 用于纯文本响应，
- 一个文件 - （见[下文](https://swagger.io/docs/specification/describing-responses/#response-that-returns-a-file)）。

架构可以在操作中内联定义：

```yaml
      responses:
        '200':
          description: A User object
          content:
            application/json:
              schema:
                type: object
                properties:
                  id:
                    type: integer
                    description: The user ID.
                  username:
                    type: string
                    description: The user name.
```

或在全局`components.schemas`部分定义并通过引用`$ref`。如果多种媒体类型使用相同的模式，这很有用。

```yaml
      responses:
        '200':
          description: A User object
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/User'
components:
  schemas:
    User:
      type: object
      properties:
        id:
          type: integer
          description: The user ID.
        username:
          type: string
          description: The user name.
```

### 返回文件的响应

API操作可以返回文件，例如图像或PDF。OpenAPI 3.0 `type: string`使用`format: binary`or 定义文件输入/输出内容`format: base64`。这与`type: file`用于描述文件输入/输出内容的OpenAPI 2.0形成鲜明对比。

如果响应单独返回文件，则通常使用二进制字符串模式并为响应指定适当的媒体类型`content`：

```yaml
paths:
  /report:
    get:
      summary: Returns the report in the PDF format
      responses:
        '200':
          description: A PDF file
          content:
            application/pdf:
              schema:
                type: string
                format: binary
```

文件也可以嵌入到JSON或XML中作为base64编码的字符串。在这种情况下，您可以使用如下所示的内容：

```yaml
paths:
  /users/me:
    get:
      summary: Returns user information
      responses:
        '200':
          description: A JSON object containing user name and avatar
          content:
            application/json:
              schema:
                type: object
                properties:
                  username:
                    type: string
                  avatar:          # <-- image embedded into JSON
                    type: string
                    format: byte
                    description: Base64-encoded contents of the avatar image
```

### anyOf，oneOf

OpenAPI 3.0也支持`oneOf`和`anyOf`，**因此您可以为响应主体指定备用模式。**

```yaml
      responses:
        '200':
          description: A JSON object containing pet information
          content:
            application/json:
              schema:
                oneOf:
                  - $ref: '#/components/schemas/Cat'
                  - $ref: '#/components/schemas/Dog'
                  - $ref: '#/components/schemas/Hamster'
```

### 空响应体

一些响应，如204无内容，没有任何内容。要指示响应正文为空，请不要`content`为响应指定一个响应：

```yaml
      responses:
        '204':
          description: The resource was deleted successfully.
```

### 响应头

来自API的响应可以包含自定义标题，以提供有关API调用结果的附加信息。例如，限速API可以通过响应标头提供速率限制状态，如下所示：

```yaml
HTTP 1/1 200 OK
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 99
X-RateLimit-Reset: 2016-10-12T11:00:00Z

{ ... }
```

您可以`headers`为每个响应定义自定义，如下所示：

```yaml
paths:
  /ping:
    get:
      summary: Checks if the server is alive.
      responses:
        '200':
          description: OK
          headers:
            X-RateLimit-Limit:
              schema:
                type: integer
              description: Request limit per hour.
            X-RateLimit-Remaining:
              schema:
                type: integer
              description: The number of requests left for the time window.
            X-RateLimit-Reset:
              schema:
                type: string
                format: date-time
              description: The UTC date/time at which the current rate limit window resets.
```

请注意，目前，OpenAPI规范不允许为不同的响应代码或不同的API操作定义通用的响应头。您需要分别为每个响应定义标题。

### 默认响应

有时，一个操作可以用不同的HTTP状态码返回多个错误，但它们都具有相同的响应结构：

```yaml
      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/User'

        # These two error responses have the same schema
        '400':
          description: Bad request
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Error'
        '404':
          description: Not found
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Error'
```

**您可以使用`default`回复来集体描述这些错误**，而不是单独描述。“默认”表示此响应用于此操作未单独涵盖的所有HTTP代码。

```yaml
      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/User'

        # Definition of all error statuses
        default:
          description: Unexpected error
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Error'
```

### 重复使用响应

如果多个操作返回相同的响应（状态码和数据），则可以`responses`在全局`components`对象的部分中定义它，然后通过`$ref`操作级别引用该定义。这对于具有相同状态代码和响应主体的错误响应非常有用。

```yaml
paths:
  /users:
    get:
      summary: Gets a list of users.
      response:
        '200':
          description: OK
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ArrayOfUsers'
        '401':
          $ref: '#/components/responses/Unauthorized'   # <-----
  /users/{id}:
    get:
      summary: Gets a user by ID.
      response:
        '200':
          description: OK
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/User'
        '401':
          $ref: '#/components/responses/Unauthorized'   # <-----
        '404':
          $ref: '#/components/responses/NotFound'       # <-----

# Descriptions of common components
components:
  responses:
    NotFound:
      description: The specified resource was not found
      content:
        application/json:
          schema:
            $ref: '#/components/schemas/Error'
    Unauthorized:
      description: Unauthorized
      content:
        application/json:
          schema:
            $ref: '#/components/schemas/Error'

  schemas:
    # Schema for error response body
    Error:
      type: object
      properties:
        code:
          type: string
        message:
          type: string
      required:
        - code
        - message
```

请注意，**定义的响应`components.responses`不会自动应用于所有操作**。这些只是可以被多个操作引用和重用的定义。

### 将响应值链接到其他操作

响应中的某些值可以用作其他操作的参数。一个典型的例子是“创建资源”操作，该操作返回创建的资源的ID，并且可以使用该ID获取该资源，更新或删除该资源。

OpenAPI 3.0提供了`links`关键字来描述响应和其他API调用之间的这种关系。

### 常问问题

**基于请求参数我可以有不同的响应吗？如：**

```
GET /something -> {200, schema_1}
GET /something?foo=bar -> {200, schema_2}
```

在OpenAPI 3.0中，您可以使用`oneOf`指定响应的备用模式，并在响应中口头记录可能的依赖关系`description`。但是，没有办法将特定模式链接到某些参数组合。
