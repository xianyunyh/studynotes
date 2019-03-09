## 添加示例

您可以向参数，属性和对象添加示例，以使Web服务的OpenAPI规范更加清晰。示例可以通过以某种方式处理您的API的工具和库来读取。例如，API模拟工具可以使用样本值生成模拟请求。

您可以指定对象，单个属性和操作参数的示例。要指定一个示例，请使用`example`或`examples`键。见下文。

**注意：**不要将示例值与默认值混淆。一个例子说明了这个价值应该是什么。如果请求不提供该值，则默认值是服务器使用的值。

### 参数示例

这是一个参数值的例子：

```
parameters:
  - in: query
    name: status
    schema:
      type: string
      enum: [approved, pending, closed, new]
      example: approved     # Example of a parameter value
```

参数的多个示例：

```
parameters:
  - in: query
    name: limit
    schema:
      type: integer
      maximum: 50
    examples:       # Multiple examples
      zero:         # Distinct name
        value: 0    # Example value
        summary: A sample limit value # Optional description
      max: # Distinct name
        value: 50   # Example value
        summary: A sample limit value # Optional description
```

正如你所看到的，每个例子都有一个独特的键名。另外，在上面的代码中，我们使用了一个可选`summary`键和描述。

**注意：**您指定的样本值应与参数数据类型匹配。

### 请求和响应正文示例

以下是`example`请求正文中的关键字示例：

```
paths:
  /users:
    post:
      summary: Adds a new user
      requestBody:
        content:
          application/json:
            schema:      # Request body contents
              type: object
              properties:
                id:
                  type: integer
                name:
                  type: string
              example:   # Sample object
                id: 10
                name: Jessica Smith
      responses:
        '200':
          description: OK
```

请注意，在上面的代码中，`example`是小孩的`schema`。如果`schema`引用该`components`部分中定义的某个对象，则应该创建`example`媒体类型关键字的子元素：

```
paths:
  /users:
    post:
      summary: Adds a new user
      requestBody:
        content:
          application/json:    # Media type
            schema:            # Request body contents
              $ref: '#/components/schemas/User'   # Reference to an object
            example:           # Child of media type because we use $ref above
              # Properties of a referenced object
              id: 10
              name: Jessica Smith
      responses:
        '200':
          description: OK
```

这是必要的，因为`$ref`覆盖它下面的所有兄弟姐妹。

如果需要，您可以使用多个示例：

```
paths:
  /users:
    post:
      summary: Adds a new user
      requestBody:
        content:
          application/json:     # Media type
            schema:             # Request body contents
              $ref: '#/components/schemas/User'   # Reference to an object
            examples:    # Child of media type
              Jessica:   # Example 1
                value:
                  id: 10
                  name: Jessica Smith
              Ron:       # Example 2
                value:
                  id: 11
                  name: Ron Stewart
      responses:
        '200':
          description: OK
```

以下是`example`应答机构的一个例子：

```
responses:
  '200':
    description: A user object.
    content:
      application/json:
        schema:
          $ref: '#/components/schemas/User'   # Reference to an object
        example: 
          # Properties of the referenced object
          id: 10
          name: Jessica Smith
```

答复机构中的多个例子：

```
responses:
  '200':
    description: A user object.
    content:
      application/json:
        schema:
          $ref: '#/components/schemas/user'   # Reference to an object
        examples:
          Jessica:
            value:
              id: 10
              name: Jessica Smith
          Ron:
            value:
              id: 20
              name: Ron Stewart
```

**注意：**响应和请求主体中的示例是免费的，但预计将与主体模式兼容。

### 对象和属性的例子

您还可以在该`components`部分中指定对象和单个属性的示例。

属性：

```
components:
  schemas:
    User:    # Schema name
      type: object
      properties:
        id:
          type: integer
          format: int64
          example: 1          # Property example
        name:
          type: string
          example: New order  # Property example
          
```

在对象中：

```
components:
  schemas:
    User:       # Schema name
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
      example:   # Object-level example
        id: 1
        name: Jessica Smith
```

请注意，模式和属性支持单数，`example`但不是复数`examples`。

### 数组示例

您可以添加单个数组项目的示例：

```
components:
  schemas:
    ArrayOfInt:
      type: array
      items:
        type: integer
        format: int64
        example: 1
```

或包含多个项目的数组级别示例：

```
components:
  schemas:
    ArrayOfInt:
      type: array
      items:
        type: integer
        format: int64
      example: [1, 2, 3]
```

如果数组包含对象，则可以按如下方式指定多项目示例：

```
components:
  schemas:
    ArrayOfUsers:
      type: array
      items:
        type: object
        properties:
          id:
            type: integer
          name:
            type: string
      example:
        - id: 10
          name: Jessica Smith
        - id: 20
          name: Ron Stewart
```

请注意，数组和数组项支持单数，`example`但不是复数`examples`。

### ML和HTML数据的示例

要描述无法以JSON或YAML格式显示的示例值，请将其指定为字符串：

```
content:
  application/xml:
    schema:
      $ref: "#/components/schemas/xml"
    examples:
      xml:
        summary: A sample XML response
        value: "<objects><object><id>1</id><name>new</name></object><object><id>2</id></object></objects>"
  text/html:
    schema:
      type: string
      examples:
        html:
          summary: A list containing two items
          value: "<html><body><ul><li>item 1</li><li>item 2</li></ul></body></html>"
```

你可以在这个Stack Overflow文章中找到有关在YAML中编写多行字符串的信息：[https](https://stackoverflow.com/questions/3790454/in-yaml-how-do-i-break-a-string-over-multiple-lines) : [//stackoverflow.com/questions/3790454/in-yaml-how-do-i-break-a-string-over-multiple-lines](https://stackoverflow.com/questions/3790454/in-yaml-how-do-i-break-a-string-over-multiple-lines)。

### 外部例子

如果样本值由于某种原因无法插入到规范中，例如，它既不是YAML-也不是JSON-conformant，则可以使用`externalValue`关键字指定示例值的URL。URL应指向包含文字示例内容的资源（例如对象，文件或图像）：

```
content:
  application/json:
    schema:
      $ref: "#components/schemas/object"
    examples:
      jsonObject:
        summary: A sample object
        externalValue: http://example.com/examples/object-example.json
  application/pdf:
    schema:
      type: string
      format: binary
    examples:
      sampleFile:
        summary: A sample file
        externalValue: http://example.com/examples/example.pdf
```

### 重用示例

您可以在`components/example`规范部分定义常见示例，然后在各种参数描述，请求和响应主体描述，对象和proeprties中重新使用它们：

```
content:
  application/json:
    schema:
      $ref: "#components/schemas/Object"
    examples:
      objectExample:
        $ref: "#components/examples/objectExample"
...
components:
  examples:
    objectExample:
      value:
        id: 1
        name: new object
      summary: A sample object
```