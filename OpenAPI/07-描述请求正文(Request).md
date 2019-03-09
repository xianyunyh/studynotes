## swagger和openAPI: 描述请求正文

请求主体通常用于“创建”和“更新”操作（POST，PUT，PATCH）。例如，当使用POST或PUT创建资源时，请求主体通常包含要创建的资源的表示形式。

OpenAPI 3.0提供了`requestBody`描述请求体的关键字。

### 与OpenAPI 2.0的差异

如果您之前使用过OpenAPI 2.0，以下是可帮助您开始使用OpenAPI 3.0的更改摘要：

- 正文和表单参数被替换为`requestBody`。
- 现在操作可以使用表单数据和其他媒体类型，例如JSON。
- 该`consumes`阵列被替换为`requestBody.content`其中媒体类型映射到其模式图。
- 模式可以因媒体类型而异。
- `anyOf`和`oneOf`可用于指定备用模式。
- 表单数据现在可以包含对象，并且您可以指定对象和数组的序列化策略。
- GET，DELETE和HEAD不再具有请求体，因为它没有按照RFC 7231定义的语义。

### requestBody，内容和媒体类型

与使用OpenAPI 2.0 `body`和`formData`参数定义请求主体不同，OpenAPI 3.0使用`requestBody`关键字来区分有效负载和参数（如查询字符串）。的`requestBody`是，它可以让你消耗不同的媒体类型，如JSON，XML，表单数据，纯文本，和其他人，并使用不同的媒体类型不同的架构更加灵活。

`requestBody`包含`content`对象，可选的Markdown格式`description`和可选`required`标志（`false`默认情况下）。`content`列出操作使用的媒体类型（如`application/json`）并指定`schema`每种媒体类型。

**请求主体默认是可选的**。要按要求标记身体，请使用`required: true`。

```yaml
paths:
  /pets:
    post:
      summary: Add a new pet

      requestBody:
        description: Optional description in *Markdown*
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/Pet'
          application/xml:
            schema:
              $ref: '#/components/schemas/Pet'
          application/x-www-form-urlencoded:
            schema:
              $ref: '#/components/schemas/PetForm'
          text/plain:
            schema:
              type: string

      responses:
        '201':
          description: Created
```

`content`允许通配符媒体类型。例如，`image/*`表示所有图像类型; `*/*` 代表所有类型，在功能上等同于`application/octet-stream`。特定媒体类型具有优于通配符的媒体类型偏好解释规范时，例如，`image/png`> `image/*`> `*/*`。 

```yaml
paths:
  /avatar:
    put:
      summary: Upload an avatar
      requestBody:
        content:
          image/*:    # Can be image/png, image/svg, image/gif, etc.
            schema:
              type: string
              format: binary
```

### anyOf，oneOf

OpenAPI 3.0支持`anyOf`和`oneOf`，因此您可以为请求主体指定备用模式：

```yaml
      requestBody:
        description: A JSON object containing pet information
        content:
          application/json:
            schema:
              oneOf:
                - $ref: '#/components/schemas/Cat'
                - $ref: '#/components/schemas/Dog'
                - $ref: '#/components/schemas/Hamster'
```

### 上传文件

要了解如何描述文件上传，请参阅文件上传和多部分请求。

### 请求正文示例

请求主体可以有一个`example`或多个`examples`。`example`并且`examples`是`requestBody.content.<media-type>`对象的属性。如果提供，这些示例会覆盖架构提供的示例。例如，如果请求和响应使用相同的模式，但您希望具有不同的示例，则这很方便。

`example` 允许一个内联示例：

```yaml
      requestBody:
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/Pet'
            example:
              name: Fluffy
              petType: dog
```

所述`examples`（多个）都更灵活-你可以有一个内联例如，`$ref`参考，或指向包含所述有效负载例如一个外部URL。每个示例还可以具有可选`summary`和`description`用于文档目的。

```yaml
      requestBody:
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/Pet'
            examples:

              dog:  # <--- example name
                summary: An example of a dog
                value:
                  # vv Actual payload goes here vv
                  name: Fluffy
                  petType: dog

              cat:  # <--- example name
                summary: An example of a cat
                externalValue: http://api.example.com/examples/cat.json   # cat.json contains {"name": "Tiger", "petType": "cat"}

              hamster:  # <--- example name
                $ref: '#/components/examples/hamster'

components:
  examples:
    hamster:  # <--- example name
      summary: An example of a hamster
      value:
        # vv Actual payload goes here vv
        name: Ginger
        petType: hamster
```

请参阅添加示例了解更多信息。

### 可重复使用的组件

您可以将请求主体定义放在全局`components.requestBodies`部分中，`$ref`并将它们放在其他地方。如果多个操作具有相同的请求主体，这很方便 - 这样可以轻松地重复使用相同的定义。

```yaml
paths:
  /pets:
    post:
      summary: Add a new pet
      requestBody:
        $ref: '#/components/requestBodies/PetBody'

  /pets/{petId}
    put:
      summary: Update a pet
      parameters: [ ... ]
      requestBody:
        $ref: '#/components/requestBodies/PetBody'

components:
  requestBodies:
    PetBody:
      description: A JSON object containing pet information
      required: true
      content:
        application/json:
          schema:
            $ref: '#/components/schemas/Pet'
```

### 表单数据

术语“表单数据”用于媒体类型`application/x-www-form-urlencoded`和`multipart/form-data`，它们通常用于提交HTML表单。

- `application/x-www-form-urlencoded`用于以`key=value`成对的方式发送简单的ASCII文本数据。有效载荷格式与查询参数类似。
- `multipart/form-data`允许在单个消息中提交二进制数据以及多种媒体类型（例如，图像和JSON）。每个表单字段在有效内容中都有自己的部分，并带有内部HTTP标头。`multipart`请求通常用于文件上传。

为了演示表单数据，请考虑HTML POST表单：

```yaml
<form action="http://example.com/survey" method="post">
  <input type="text"   name="name" />
  <input type="number" name="fav_number" />
  <input type="submit"/>
</form>
```

此表单将数据POST到表单的端点：

```yaml
POST /survey HTTP/1.1
Host: example.com
Content-Type: application/x-www-form-urlencoded
Content-Length: 28

name=Amy+Smith&fav_number=42
```

在OpenAPI 3.0中，表单数据使用`type: object`对象属性表示表单字段的模式进行建模：

```yaml
paths:
  /survey:
    post:
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:          # <!--- form field name
                  type: string
                fav_number:    # <!--- form field name
                  type: integer
              required:
                - name
                - email
```

表单字段可以包含基元值，数组和对象。默认情况下，数组被序列化为`array_name=value1&array_name=value2`对象`prop1=value1&prop=value2`，但您可以使用OpenAPI 3.0规范定义的其他序列化策略。序列化策略在`encoding`部分中指定，如下所示：

```yaml
      requestBody:
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                color:
                  type: array
                  items:
                    type: string
            encoding:
              color:            # color=red,green,blue
                style: form
                explode: false
```

默认情况下，主体`:/?#[]@!$&'()*+,;=`中表单字段值中的保留字符在发送时`application/x-www-form-urlencoded`为百分比编码。要允许这些字符按原样发送，请使用如下所示的`allowReserved`关键字：

```yaml
      requestBody:
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                foo:
                  type: string
                bar:
                  type: string
                baz:
                  type: string
            encoding:
              # Don't percent-encode reserved characters in the values of "bar" and "baz" fields
              bar:
                allowReserved: true
              baz:
                allowReserved: true
```

任意`key=value`对可以使用自由格式模式进行建模：

```yaml
      requestBody:
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              additionalProperties: true    # this line is optional
```

#### 表单数据中的复杂序列化

由关键字`style`和`explode`关键字提供的序列化规则只对具有原始属性的基元和对象的数组定义了行为。对于更复杂的sceharios，例如表单数据中的嵌套数组或JSON，您需要使用`contentType`关键字指定用于编码复杂字段值的媒体类型。

考虑Slack传入的webhooks的例子。消息可以直接作为JSON发送，或者JSON数据可以在`payload`像这样命名的表单字段中发送（在应用URL编码之前）：

```
payload={"text":"Swagger is awesome"}
```

这可以被描述为：

```yaml
openapi: 3.0.0
info:
  version: 1.0.0
  title: Slack Incoming Webhook
externalDocs:
  url: https://api.slack.com/incoming-webhooks

servers:
  - https://hooks.slack.com

paths:
  /services/T00000000/B00000000/XXXXXXXXXXXXXXXXXXXXXXXX:
    post:
      summary: Post a message to Slack
      requestBody:
        content:
        
          application/json:
            schema:
              $ref: '#/components/schemas/Message'

          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                payload:     # <--- form field that contains the JSON message
                  $ref: '#/components/schemas/Message'
            encoding:
              payload:
                contentType: application/json

      responses:
        '200':
          description: OK

components:
  schemas:
    Message:
      title: A Slack message
      type: object
      properties:
        text:
          type: string
          description: Message text
      required:
        - text
```

 