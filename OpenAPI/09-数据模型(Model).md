OpenAPI 3.0数据类型基于扩展子集JSON Schema Specification Wright Draft 00（aka Draft 5）。数据类型使用[Schema对象](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/3.0.0.md#schemaObject)进行描述。 

## 数据类型

`type` 例如，模式的数据类型由关键字定义`type: string` 

OpenAPI定义了以下基本类型：

- `string`（这包括日期和[文件](https://www.breakyizhan.com/swagger/2965.html)）
- `number`
- `integer`
- `boolean`
- `array`
- `object`

这些类型存在于大多数编程语言中，尽管它们可能有不同的名称。使用这些类型，您可以描述任何数据结构。

请注意，没有`null`类型; 相反，该`nullable`属性用作基本类型的修饰符。

`type`可以使用其他特定的关键字来优化数据类型，例如限制字符串长度或指定[`enum`](https://swagger.io/docs/specification/data-models/enums/)可能的值。

### 混合类型

`type`采取单一的价值。`type`因为列表在OpenAPI中无效（即使它在JSON模式中有效）：

```yaml
# 错误的
type:
  - string
  - integer
```

可以使用[`oneOf`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/)和来描述混合类型[`anyOf`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/)，它们指定了备用类型的列表：

```
# 正确的方式
oneOf:
  - type: string
  - type: integer
```



### 数字

的OpenAPI有两个数字类型，`number`并且`integer`，其中`number`包括整数和浮点数。

可选`format`关键字可作为使用特定数字类型的工具的提示：

| `type`  | `format` | 描述                               |
| ------- | -------- | ---------------------------------- |
| number  | -        | 任何数字。                         |
| number  | 浮动     | 浮点数字。                         |
| number  | 双       | 双精度浮点数。                     |
| integer | -        | 整数。                             |
| integer | INT32    | 带符号的32位整数（常用整数类型）。 |
| integer | Int64的  | 有符号的64位整数（`long`类型）。   |

请注意，包含数字的字符串（如“17”）被视为字符串，而不是数字。

#### 最小和最大

使用`minimum`和`maximum`关键字来指定可能值的范围：

```
type: integer
minimum: 1
maximum: 20
```

默认情况下，`minimum`和`maximum`值包含在该范围内，即：

```
minimum ≤ value ≤ maximum
```

要排除边界值，请指定`exclusiveMinimum: true`和`exclusiveMaximum: true`。例如，您可以将浮点数范围定义为0-50并排除0值：

```
type: number
minimum: 0
exclusiveMinimum: true
maximum: 50
```

“排除”一词`exclusiveMinimum`并且`exclusiveMaximum`意味着相应的边界被*排除在外*：

| 关键词                                 | 描述          |
| -------------------------------------- | ------------- |
| `exclusiveMinimim: false` 或不包括在内 | 值≥ `minimum` |
| `exclusiveMinimim: true`               | 值> `minimum` |
| `exclusiveMaximim: false` 或不包括在内 | 值≤ `maximum` |
| `exclusiveMaximim: true`               | 值< `maximum` |

#### 倍数

使用`multipleOf`关键字指定一个数字必须是另一个数字的倍数：

```yaml
type: integer
multipleOf: 10
```

上面的例子匹配10,20,30，0，-10，-20等等。

`multipleOf` 可以与浮点数一起使用，但实际上由于精度或浮点数学的限制，这可能是不可靠的。

```yaml
type: number
multipleOf: 2.5
```

值`multipleOf`必须是正数，也就是说，你不能使用`multipleOf: -5`。

### 字符串

一串文本被定义为：

```yaml
type: string
```

使用`minLength`和可以限制字符串长度`maxLength`：

```yaml
type: string
minLength: 3
maxLength: 20
```

请注意，一个空字符串“”是一个有效的字符串，除非`minLength`或被[`pattern`](https://swagger.io/docs/specification/data-models/data-types/#pattern)指定。

#### 字符串格式

可选的`format`修饰符用作提示字符串的内容和格式。OpenAPI定义了以下内置字符串格式：

- `date`- 定义的全日制符号，例如*2017-07-21*
- `date-time`- 定义的日期时间表示法，例如*2017-07-21T17：32：28Z*
- `password` - 提示用户界面屏蔽输入
- `byte`- base64编码的字符，例如*U3dhZ2dlciByb2Nrcw ==*
- `binary`- 二进制数据，用于描述文件

但是，它`format`是一个开放的值，因此您可以使用任何格式，甚至不使用OpenAPI规范定义的格式，例如：

- `email`
- `uuid`
- `uri`
- `hostname`
- `ipv4`
- `ipv6`
- others

工具可以使用该`format`来验证输入或将值映射到所选编程语言中的特定类型。不支持特定格式的工具可以默认回到`type`单独的状态，就好像`format`没有指定。

#### 模式

该`pattern`关键字可以定义字符串值正则表达式的模板。只有符合此模板的值才会被接受。使用的正则表达式语法来自JavaScript（更具体地说，ECMA 262）。正则表达式区分大小写，即[az]和[AZ]是不同的表达式。

例如，以下模式与123-45-6789格式的社会安全号码（SSN）相匹配：

```
ssn:
  type: string
  pattern: '^\d{3}-\d{2}-\d{4}$'
```

请注意，正则表达式包含在`^…$`令牌中，其中`^`表示该字符串的开头，并且`$`表示该字符串的结尾。没有`^…$`，`pattern`作为部分匹配，即匹配任何*包含*指定正则表达式的字符串。例如，`pattern: pet`相匹配*的宠物*，*的PetStore*和*地毯*。该`^…$`令牌迫使完全匹配。

### 布尔

`type: boolean`代表两个值：`true`和`false`。

请注意，诸如“true”，“”，0之类的真值和谬误值`null`不被视为布尔值。

### 空值

OpenAPI 3.0没有`null`JSON Schema中的显式类型，但可以`nullable: true`用来指定该值`null`。请注意，`null`它与空字符串“”不同。

```yaml
# Correct
type: integer
nullable: true

# Incorrect
type: null

# Incorrect as well
type:
  - integer
  - null
```

上面的例子可以映射到`int?`C＃和`java.lang.Integer`Java中的可空类型。

在对象中，可为空的属性与可选属性不同，但有些工具可能会选择将可选属性映射到该`null`值。

### 数组

数组被定义为：

```yaml
type: array
items:
  type: string
```

与JSON模式不同，`items`关键字在数组中是必需的。值`items`是描述数组项的类型和格式的模式。

数组可以嵌套：

```yaml
# [ [1, 2], [3, 4] ]
type: array
items:
  type: array
  items:
    type: integer
```

并包含对象：

```yaml
# [ {"id": 5}, {"id": 8} ]
type: array
items:
  type: object
  properties:
    id:
      type: integer
```

可以内联指定项目模式（如前面的示例中所示），或者通过`$ref`以下方式进行引用：

```yaml
# Array of Pets
type: array
items:
  $ref: '#/components/schemas/Pet'
```

#### 混合型阵列

混合类型的数组可以使用下面的定义`oneOf`：

```yaml
# ["foo", 5, -2, "bar"]
type: array
items:
  oneOf:
    - type: string
    - type: integer
```

`oneOf` 允许内联子模板（如上例所示）和引用：

```yaml
# Array of Cats and Dogs
type: array
items:
  oneOf:
    - $ref: '#/components/schemas/Cat'
    - $ref: '#/components/schemas/Dog'
```

任意类型的数组可以定义为：

```yaml
type: array
items: {}

# [ "hello", -2, true, [5.7], {"id": 5} ]
```

这里`{}`是“任何类型”模式（见下文）。

请注意，以下语法`items`无效：

```yaml
# Incorrect
items:
  - type: string
  - type: integer

# Incorrect as well
items:
  type: 
    - string
    - integer
```

#### 数组长度

您可以像这样定义数组的最小和最大长度：

```yaml
type: array
items:
  type: integer
minItems: 1
maxItems: 10
```

没有`minItems`，空数组被认为是有效的。

#### uniqueItems

您可以使用`uniqueItems: true`来指定数组中的所有项目必须是唯一的：

```yaml
type: array
items:
  type: integer
uniqueItems: true

# [1, 2, 3] – valid
# [1, 1, 3] – not valid
# [ ] – valid
```

### 对象

一个对象是一组属性/值对。该`properties`关键字用于定义对象属性 - 您需要列出属性名称并为每个属性指定一个模式。

```yaml
type: object
properties:
  id:
    type: integer
  name:
    type: string
```

**提示：** **在OpenAPI中，对象通常在全局`components/schemas`部分中定义，而不是内联在请求和响应定义中。**

#### 必需的属性

默认情况下，所有对象属性都是可选的。您可以在`required`列表中指定所需的属性：

```
type: object
properties:
  id:
    type: integer
  username:
    type: string
  name:
    type: string
required:
  - id
  - username
```

请注意，**这`required`是一个对象级属性，而不是属性属性：**

```yaml
type: object
properties:
  id:
    type: integer
    required: true  # Wyamlyamlrong!

required:           # Correct
  - id
```

一个空的列表`required: []`无效。如果所有属性都是可选的，则不要指定`required`关键字。

#### 只读和只写属性

您可以使用`readOnly`和`writeOnly`关键字将特定属性标记为只读或只写。例如，当GET返回比POST中更多的属性时，这很有用 - 您可以在GET和POST中使用相同的模式，并将额外的属性标记为`readOnly`。`readOnly`属性包含在响应中，但不包含在请求中，`writeOnly`属性可能在请求中发送，但不在响应中发送。

```yaml
type: object
properties:
  id:
    # Returned by GET, not used in POST/PUT/PATCH
    type: integer
    readOnly: true
  username:
    type: string
  password:
    # Used in POST/PUT/PATCH, not returned by GET
    type: string
    writeOnly: true
```

如果列表中包含某个属性`readOnly`或`writeOnly`属性，则仅影响相关范围 - 仅响应或仅请求。也就是说，只读必需属性仅适用于仅响应，并且只写必需属性 - 仅适用于请求。`required``required`

#### 嵌套对象

一个对象可以包含嵌套的对象：

```yaml
components:
  schemas:
    User:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        contact_info:
          # The value of this property is an object
          type: object
          properties:
            email:
              type: string
              format: email
            phone:
              type: string
```

您可能希望将嵌套对象拆分为多个模式并用于[`$ref`](https://swagger.io/docs/specification/using-ref/)引用嵌套模式：

```
components:
  schemas:
    User:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        contact_info:
          $ref: '#/components/schemas/ContactInfo'

    ContactInfo:
      type: object
      properties:
        email:
          type: string
          format: email
        phone:
          type: string
```

#### 自由形式的对象

一个自由形式的对象（任意属性/值对）被定义为：

```yaml
type: object
```

这相当于

```
type: object
additionalProperties: true
```

和

```
type: object
additionalProperties: {}
```

#### 数量的属性

使用`minProperties`和`maxProperties`关键字可以限制对象中允许的属性数量。这在使用`additionalProperties`或自由形式的对象时很有用。

```
type: object
minProperties: 2
maxProperties: 10
```

在这个例子中，`{"id": 5, "username": "trillian"}`匹配模式，但`{"id": 5}`没有。

### 文档

与OpenAPI 2.0不同，Open API 3.0没有这种`file`类型。**文件被定义为字符串**：

```
type: string
format: binary  # binary file contents
```

要么

```
type: string
format: byte    # base64-encoded file contents
```

取决于所需的文件传输方法。有关更多信息，请参阅文件上载，多部分请求和返回文件的响应。

### 任何类型

**没有类型的模式匹配任何数据类型 - 数字，字符串，对象等等。`{}`是任意类型模式的简写语法：**

```yaml
components:
  schemas:
    AnyValue: {}
```

如果你想提供一个描述：

```yaml
components:
  schemas:
    AnyValue:
      description: Can be any value - string, number, boolean, array or object.
```

以上相当于：

```yaml
components:
  schemas:
    AnyValue:
      anyOf:
        - type: string
        - type: number
        - type: integer
        - type: boolean
        - type: array
          items: {}
        - type: object
```

如果`null`需要允许该值，请添加`nullable: true`：

```yaml
components:
  schemas:
    AnyValue:
      nullable: true
      description: Can be any value, including null.
```

## 枚举

您可以使用`enum`关键字来指定请求参数或模型属性的可能值。

例如，sort中的sort参数`GET /items?sort=[asc|desc]`可以描述为：

```yaml
paths:
  /items:
    get:
      parameters:
        - in: query
          name: sort
          description: Sort order
          schema:
            type: string
            enum: [asc, desc]
```

在YAML中，您还可以为每行指定一个枚举值：

```yaml
          enum:
            - asc
            - desc
```

枚举中的所有值必须符合指定的值`type`。

如果您需要指定枚举项目的说明，则可以`description`在参数或属性中执行此操作：

```yaml
      parameters:
        - in: query
          name: sort
          schema:
            type: string
            enum: [asc, desc]
          description: >
            Sort order:
             * `asc` - Ascending, from A to Z
             * `desc` - Descending, from Z to A
```

### 可重用的枚举

在OpenAPI 3.0中，操作参数和数据模型都使用a `schema`，这使得重用数据类型变得很容易。您可以在全局`components` 部分中定义可重用枚举并通过`$ref`别处引用它们。

```yaml
paths:
  /products:
    get:
      parameters:
      - in: query
        name: color
        required: true
        schema:
          $ref: '#/components/schemas/Color'
      responses:
        '200':
          description: OK
components:
  schemas:
    Color:
      type: string
      enum:
        - black
        - white
        - red
        - green
        - blue
```

## 字典，哈希映射和关联数组

### 字典，哈希映射和关联数组

字典（也称为映射，散列图或关联数组）是一组键/值对。

OpenAPI允许您定义**键是字符串的**字典。要定义词典，使用`type: object`，并使用`additionalProperties`关键字来指定值的键/值对的类型。例如，像这样的字符串到字符串的字典：

```
{
  "en": "English",
  "fr": "French"
}
```

是使用以下模式定义的：

```
type: object
additionalProperties:
  type: string
```

### 值类型

所述`additionalProperty`关键字指定值的字典中的类型。值可以是基元（字符串，数字或布尔值），数组或对象。例如，一个字符串到对象的字典可以定义如下：

```
type: object
additionalProperties:
  type: object
  properties:
    code:
      type: integer
    text:
      type: string
```

而不是使用内联模式，`additionalProperties`可以使用`$ref`另一个模式：

```
components:
  schemas:
    Messages:        # <---- dictionary
      type: object
      additionalProperties:
        $ref: '#/components/schemas/Message'

    Message:
      type: object
      properties:
        code:
          type: integer
        text:
          type: string
```

### 自由形式对象

如果字典值可以是任何类型（又名自由格式对象），请使用`additionalProperties: true`：

```
type: object
additionalProperties: true
```

这相当于：

```
type: object
additionalProperties: {}
```

### 固定键

如果字典中有一些固定键，则可以将它们明确定义为对象属性并根据需要标记它们：

```
type: object
properties:
  default:
    type: string
required:
  - default
additionalProperties:
  type: string
```

### 字典内容的例子

您可以使用`example`关键字来指定示例字典内容：

```
type: object
additionalProperties:
  type: string
example:
  en: Hello!
  fr: Bonjour!
```

##  oneOf，anyOf，allOf，not

OpenAPI 3.0提供了几个可用于组合模式的关键字。您可以使用这些关键字来创建复杂的模式，或根据多个条件验证值。

- [`oneOf`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/#oneof)- 确切地*对照*一个子模板验证值
- [`allOf`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/#allof)- 验证**所有**子模板的值
- [`anyOf`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/#anyof)- 针对**任何（一个或多个）**子模板验证该值

除了这些，还有一个[`not`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/#not)，你可以用它来确保该值是关键字*没有*对指定模式是有效的。

### oneOf

使用`oneOf`关键字确保给定数据对指定模式之一有效。

```yaml
paths:
  /pets:
    patch:
      requestBody:
        content:
          application/json:
            schema:
              oneOf:
                - $ref: '#/components/schemas/Cat'
                - $ref: '#/components/schemas/Dog'
      responses:
        '200':
          description: Updated

components:
  schemas:
    Dog:
      type: object
      properties:
        bark:
          type: boolean
        breed:
          type: string
          enum: [Dingo, Husky, Retriever, Shepherd]
    Cat:
      type: object
      properties:
        hunts:
          type: boolean
        age:
          type: integer
```

上面的例子展示了如何在“更新”操作（PATCH）中验证请求主体。您可以使用它来验证请求主体是否包含有关要更新的对象的所有必要信息，具体取决于对象类型。

请注意内联或引用的模式必须是*模式对象*，而不是标准的JSON模式。

现在，进行验证。

以下JSON对象对其中一个模式**有效**，因此响应正文是*正确的*：

```json
{
  "bark": true,
  "breed": "Dingo" 
}
```

以下JSON对象对两个模式**无效**，因此响应正文*不正确*：

```json
{
  "bark": true,
  "hunts": true
}
```

以下JSON对象对**两种**模式均**有效**，因此响应正文*不正确* - 因为我们使用的是关键字，所以它应该仅针对其中一个模式有效。`oneOf`

```json
{
  "bark": true,
  "hunts": true,
  "breed": "Husky",
  "age": 3 		
}
```

### allOf

OpenAPI允许您使用`allOf`关键字组合和扩展模型定义。`allOf`需要一组用于独立验证的对象定义，但共同组成一个对象。尽管如此，它并不意味着模型之间的层次结构。为此目的，你应该包括[`discriminator`](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/3.0.0.md#discriminatorObject)。

为了有效`allOf`，客户提供的数据必须对所有给定的子模式有效。

在下面的例子中，**`allOf`作为一个工具将特定情况下使用的模式与通用模式结合起来**。为了更清晰，`oneOf`也使用了a `discriminator`。

```yaml
paths:
  /pets:
    patch:
      requestBody:
        content:
          application/json:
            schema:
              oneOf:
                - $ref: '#/components/schemas/Cat'
                - $ref: '#/components/schemas/Dog'
              discriminator:
                propertyName: pet_type
      responses:
        '200':
          description: Updated

components:
  schemas:
    Pet:
      type: object
      required:
        - pet_type
      properties:
        pet_type:
          type: string
      discriminator:
        propertyName: pet_type

    Dog:     # "Dog" is a value for the pet_type property (the discriminator value)
      allOf: # Combines the main `Pet` schema with `Dog`-specific properties 
        - $ref: '#/components/schemas/Pet'
        - type: object
          # all other properties specific to a `Dog`
          properties:
            bark:
              type: boolean
            breed:
              type: string
              enum: [Dingo, Husky, Retriever, Shepherd]

    Cat:     # "Cat" is a value for the pet_type property (the discriminator value)
      allOf: # Combines the main `Pet` schema with `Cat`-specific properties 
        - $ref: '#/components/schemas/Pet'
        - type: object
          # all other properties specific to a `Cat`
          properties:
            hunts:
              type: boolean
            age:
              type: integer
```

正如你所看到的，这个例子验证了请求主体内容，以确保它包含用PUT操作更新宠物项目所需的所有信息。它要求用户指定哪个类型的项目应该更新，并根据他们的选择针对指定的模式进行验证。

请注意内联或引用的模式必须是*模式对象*，而不是标准的JSON模式。

对于这个例子，以下所有的请求体都是**有效的**：

```
{
  "pet_type": "Cat",
  "age": 3
}
```

```
{
  "pet_type": "Dog",
  "bark": true
}
```

```
{
  "pet_type": "Dog",
  "bark": false,
  "breed": "Dingo"
}
```

以下申请机构**无效**：

```
{
  "age": 3        # Does not include the pet_type property
}
```

 

```
{
  "pet_type": "Cat", 
  "bark": true    # The `Cat` schema does not have the `bark` property 
}
```

 

### anyof

使用`anyOf`关键字对照任何数量的给定subschemas验证数据。也就是说，这些数据可能同时对一个或多个子模型有效。

```yaml
paths:
  /pets:
    patch:
      requestBody:
        content:
          application/json:
            schema:
              anyOf:
                - $ref: '#/components/schemas/PetByAge'
                - $ref: '#/components/schemas/PetByType'
      responses:
        '200':
          description: Updated

components:
  schemas:
    PetByAge:
      type: object
      properties: 
        age: 
          type: integer
        nickname: 
          type: string
      required:
        - age
          
    PetByType:
      type: object
      properties:
        pet_type:
          type: string
          enum: [Cat, Dog]
        hunts:
          type: boolean
      required: 
        - pet_type
```

请注意内联或引用的模式必须是*模式对象*，而不是标准的JSON模式。

在此示例中，以下JSON请求正文是**有效的**：

```yaml
{
  "age": 1
}
```

```yaml
{
  "pet_type": "Cat",
  "hunts": true
}
```

```yaml
{
  "nickname": "Fido",
  "pet_type": "Dog",
  "age": 4
}
```

以下示例**无效**，因为它不包含任何两个模式的必需属性：

```yaml
{
  "nickname": "Mr. Paws",
  "hunts": false
}
```

### anyOf和oneOf之间的区别

`oneOf`匹配一个子模式，并且`anyOf`可以匹配一个或多个子模板。

为了更好地理解它们之间的区别，请使用[上面](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/#difference)的例子[，](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/#difference)但是`anyOf`用`oneOf`。使用时`oneOf`，以下请求正文**无效，**因为它与两个模式匹配，而不仅仅是一个：

```
{
  "nickname": "Fido",
  "pet_type": "Dog",
  "age": 4
}
```

### NOT

该`not`关键字并不完全相结合的模式，但它所有上面提到的关键字，可以帮助您修改架构，并使其更具针对性。

```yaml
paths:
  /pets:
    patch:
      requestBody:
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/PetByType'
      responses:
        '200':
          description: Updated

components:
  schemas:          
    PetByType:
      type: object
      properties:
        pet_type:
          not:
            type: integer
      required:
        - pet_type
```

在这个例子中，用户应该指定`pet_type`除整数之外的任何类型的值（也就是说，它应该是一个数组，布尔值，数字，对象或字符串）。

以下请求正文**有效**：

```yaml
{
  "pet_type": "Cat"
}
```

以下是**无效的**：

```yaml
{
  "pet_type": 11
}
```

## 遗传和多态性

### 模型构成

在你的API中，你可能有共享公共属性的模型模式。不必重复描述每个模式的这些属性，您可以将模式描述为公共属性集合和模式特定属性的组合。在OpenAPI版本3中，您可以使用`allOf`关键字：

```
components:
  schemas:
    BasicErrorModel:
      type: object
      required:
        - message
        - code
      properties:
        message:
          type: string
        code:
          type: integer
          minimum: 100
          maximum: 600
    ExtendedErrorModel:
      allOf:     # Combines the BasicErrorModel and the inline model
        - $ref: '#/components/schemas/BasicErrorModel'
        - type: object
          required:
            - rootCause
          properties:
            rootCause:
              type: string
```

在上面的例子中，`ExtendedErrorModel`模式包括它自己的属性和属性`BasicErrorModel`。

**注意：**在验证数据时，服务器和客户端将根据其组成的每个模型验证组合模型。建议避免使用冲突的属性（如具有相同名称但数据类型不同的属性）。

### 多态性

在您的API中，您可以获得可以通过几种备选模式进行描述的请求和响应。在OpenAPI 3.0中，为了描述这样的模型，你可以使用`oneOf`or `anyOf`关键字：

```
components:
  responses:
    sampleObjectResponse:
      content:
        application/json:
          schema:
            oneOf:
              - $ref: '#/components/schemas/simpleObject'
              - $ref: '#/components/schemas/complexObject'
  …
components:
  schemas:
    simpleObject:
      …
    complexObject:
      …
```

在这个例子中，响应有效载荷可以包含`simpleObject`或者`complextObject`。

### 鉴别

为了帮助API使用者检测对象类型，可以将`discriminator/propertyName`关键字添加到模型定义中。该关键字指向指定数据类型名称的属性：

```yaml
components:
  responses:
    sampleObjectResponse:
      content:
        application/json:
          schema:
            oneOf:
              - $ref: '#/components/schemas/simpleObject'
              - $ref: '#/components/schemas/complexObject'
            discriminator:
              propertyName: objectType
  …
  schemas:
    simpleObject:
      type: object
      required:
        - objectType
      properties:
        objectType:
          type: string
      …
    complexObject:
      type: object
      required:
        - objectType
      properties:
        objectType:
          type: string
      …
```

在我们的例子中，鉴别符指向`objectType`包含数据类型名称的属性。

鉴别器仅与关键字`anyOf`或`oneOf`关键字一起使用。所有下面提到的模型`anyOf`或`oneOf`包含鉴别器指定的属性都很重要。这意味着，例如，在我们上面代码中，无论是`simpleObject`和`complexObject`必须具备的`objectType`属性。这些属性在这些模式中是必需的：

```yaml
schemas:
    simpleObject:
      type: object
      required:
        - objectType
      properties:
        objectType:
          type: string
      …
    complexObject:
      type: object
      required:
        - objectType
      properties:
        objectType:
          type: string
      …
```

该`discriminator`关键字可以被各种API消费者使用。一个可能的例子是代码生成工具：它们可以使用鉴别器来生成程序语句，该程序语句根据鉴别器属性值将类型请求数据转换为适当的对象类型。

### 映射类型名称

这意味着，鉴别器引用的属性包含目标模式的名称。在上面的例子中，`objectType`属性应该包含`*simpleObject*`或者`*complexObject*`字符串。

如果属性值与模式名称不匹配，则可以将值映射到名称。为此，请使用`discriminator/mapping`关键字：

```yaml
components:
  responses:
    sampleObjectResponse:
      content:
        application/json:
          schema:
            oneOf:
              - $ref: '#/components/schemas/Object1'
              - $ref: '#/components/schemas/Object2'
              - $ref: 'sysObject.json#/sysObject'
            discriminator:
              propertyName: objectType
              mapping:
                obj1: '#/components/schemas/Object1'
		obj2: '#/components/schemas/Object2'
                system: 'sysObject.json#/sysObject'
  …
  schemas:
    Object1:
      type: object
      required:
        - objectType
      properties:
        objectType:
          type: string
      …
    Object2:
      type: object
      required:
        - objectType
      properties:
        objectType:
          type: string
      …
```

在这个例子中，`*obj1*`值被映射到`Object1`了在同一规范中定义，模型`*obj2*`-到`Object2`，并且该值`*system*`的匹配`sysObject`，其位于在外部文件中的模型。所有这些对象玉米粥包含`objectType`返回财产`*obj1*`，`*obj2*`或`*system*`相应。

## 支持的JSON模式关键字

 OpenAPI 3.0使用JSON Schema Specification Wright Draft 00（又名草案5）的扩展子集来描述数据格式。“扩展子集”意味着某些关键字受到支持，有些关键字不受支持，某些关键字的用法与JSON模式略有不同，并引入了其他关键字。

### 支持的关键字

这些关键字**与** JSON模式中的**含义相同**：

- `title`
- [`pattern`](https://swagger.io/docs/specification/data-models/data-types/#pattern)
- [`required`](https://swagger.io/docs/specification/data-models/data-types/#required)
- [`enum`](https://swagger.io/docs/specification/data-models/enums/)
- [`minimum`](https://swagger.io/docs/specification/data-models/data-types/#range)
- [`maximum`](https://swagger.io/docs/specification/data-models/data-types/#range)
- [`exclusiveMinimum`](https://swagger.io/docs/specification/data-models/data-types/#range)
- [`exclusiveMaximum`](https://swagger.io/docs/specification/data-models/data-types/#range)
- [`multipleOf`](https://swagger.io/docs/specification/data-models/data-types/#multipleOf)
- [`minLength`](https://swagger.io/docs/specification/data-models/data-types/#string)
- [`maxLength`](https://swagger.io/docs/specification/data-models/data-types/#string)
- [`minItems`](https://swagger.io/docs/specification/data-models/data-types/#array-length)
- [`maxItems`](https://swagger.io/docs/specification/data-models/data-types/#array-length)
- [`uniqueItems`](https://swagger.io/docs/specification/data-models/data-types/#uniqueItems)
- [`minProperties`](https://swagger.io/docs/specification/data-models/data-types/#property-count)
- [`maxProperties`](https://swagger.io/docs/specification/data-models/data-types/#property-count)

这些关键字**仅有微小的差异**：

- [`type`](https://swagger.io/docs/specification/data-models/data-types/#type) - 该值必须是单一类型而不是类型数组。
- `format` - OpenAPI有它自己的预定义格式，并且还允许自定义格式。
- `description`- 支持用于富文本表示的CommonMark语法。
- [`items`](https://swagger.io/docs/specification/data-models/data-types/#array)- 如果`type`是，必须在场`array`。项目模式必须是OpenAPI模式，而不是标准的JSON模式。
- [`properties`](https://swagger.io/docs/specification/data-models/data-types/#object) - 单独的属性定义必须遵循OpenAPI模式规则，而不是标准的JSON模式。
- [`additionalProperties`](https://swagger.io/docs/specification/data-models/data-types/#additionalProperties)- 该值可以是布尔（`true`或`false`）或OpenAPI模式。
- [`default`](https://swagger.io/docs/specification/data-models/data-types/#default) - 默认值必须符合指定的模式。
- [`allOf`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/) - 子模板必须是OpenAPI模式，而不是标准的JSON模式。
- [`oneOf`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/) - 子模板必须是OpenAPI模式，而不是标准的JSON模式。
- [`anyOf`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/) - 子模板必须是OpenAPI模式，而不是标准的JSON模式。
- [`not`](https://swagger.io/docs/specification/data-models/oneof-anyof-allof-not/) - subschema必须是OpenAPI模式，而不是标准的JSON模式。

### 不支持的关键字

- `$schema`
- `additionalItems`
- `const`
- `contains`
- `dependencies`
- `id`， `$id`
- `patternProperties`
- `propertyNames`

### 其他关键字

OpenAPI模式也可以使用以下不属于JSON模式的关键字：

- `deprecated`
- [`discriminator`](https://swagger.io/docs/specification/data-models/inheritance-and-polymorphism/)
- [`example`](https://swagger.io/docs/specification/adding-examples/)
- `externalDocs`
- [`nullable`](https://swagger.io/docs/specification/data-models/data-types/#null)
- [`readOnly`](https://swagger.io/docs/specification/data-models/data-types/#readonly-writeonly)， [`writeOnly`](https://swagger.io/docs/specification/data-models/data-types/#readonly-writeonly)
- [`xml`](https://swagger.io/docs/specification/data-models/representing-xml/)

 