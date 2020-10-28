> **protocolbuffer**(以下简称PB)是google 的一种数据交换的格式，它独立于语言，独立于平台。google 提供了多种语言的实现：java、c#、c++、go 和 python，每一种实现都包含了相应语言的编译器以及库文件。由于它是一种二进制的格式，比使用 xml 进行数据交换快许多。可以把它用于分布式应用之间的数据通信或者异构环境下的数据交换。作为一种效率和兼容性都很优秀的二进制数据传输格式，可以用于诸如网络传输、配置文件、数据存储等诸多领域



![img](https://images2015.cnblogs.com/blog/449477/201603/449477-20160328175557894-195159813.png)

PB以“1-5个字节”的编号和类型开头，**格式：**编号左移3位和类型取或得到。

**编号**

定义proto文件字段的编号

类型

类型就是 定义的proto文件中各个字段类型，使用3位表示类型，可以表示0到7，共8种类型，PB类型只用了0，1，2，3，4，5这6种类型。

详细描述参考如下表格：

| 类型 | 描述             | 使用于哪些类型                                           |
| ---- | ---------------- | -------------------------------------------------------- |
| 0    | varint           | int32, int64, uint32, uint64, sint32, sint64, bool, enum |
| 1    | 64-bit           | fixed64, sfixed64, double                                |
| 2    | Length-delimited | string, bytes, embedded messages, packed repeated fields |
| 3    | Start group      | groups (deprecated)                                      |
| 4    | End group        | groups (deprecated)                                      |
| 5    | 32-bit           | fixed32, sfixed32, float                                 |

```protobuf
enum Recode {
    SUCCESS = 0;
    ERROR = 1;
};
```

## proto3 格式

### 1. 协议版本：syntax

```
syntax = "proto3";
```

### 2. package 包名

定义proto的包名，包名可以避免对message 类型之间的名字冲突，同名的Message可以通过package进行区分。

在没有为特定语言定义`option xxx_package`的时候，它还可以用来生成特定语言的包名，比如Java package, go package。

```protobuf
package hello
```



### 3. 消息定义

```protobuf
message SearchRequest {
  string query = 1;
  int32 page_number = 2;
  int32 result_per_page = 3;
}
```

​	一个消息包含各个字段，字段需要定义对应的类型、名称、编号

- **字段类型**

  | .proto Type | Notes                                                        | C++ Type | Java Type  | Python Type[2] | Go Type | Ruby Type                      | C# Type    | PHP Type       |
  | ----------- | ------------------------------------------------------------ | -------- | ---------- | -------------- | ------- | ------------------------------ | ---------- | -------------- |
  | double      |                                                              | double   | double     | float          | float64 | Float                          | double     | float          |
  | float       |                                                              | float    | float      | float          | float32 | Float                          | float      | float          |
  | int32       | 使用变长编码，对于负值的效率很低，如果你的域有可能有负值，请使用sint64替代 | int32    | int        | int            | int32   | Fixnum 或者 Bignum（根据需要） | int        | integer        |
  | uint32      | 使用变长编码                                                 | uint32   | int        | int/long       | uint32  | Fixnum 或者 Bignum（根据需要） | uint       | integer        |
  | uint64      | 使用变长编码                                                 | uint64   | long       | int/long       | uint64  | Bignum                         | ulong      | integer/string |
  | sint32      | 使用变长编码，这些编码在负值时比int32高效的多                | int32    | int        | int            | int32   | Fixnum 或者 Bignum（根据需要） | int        | integer        |
  | sint64      | 使用变长编码，有符号的整型值。编码时比通常的int64高效。      | int64    | long       | int/long       | int64   | Bignum                         | long       | integer/string |
  | fixed32     | 总是4个字节，如果数值总是比总是比228大的话，这个类型会比uint32高效。 | uint32   | int        | int            | uint32  | Fixnum 或者 Bignum（根据需要） | uint       | integer        |
  | fixed64     | 总是8个字节，如果数值总是比总是比256大的话，这个类型会比uint64高效。 | uint64   | long       | int/long       | uint64  | Bignum                         | ulong      | integer/string |
  | sfixed32    | 总是4个字节                                                  | int32    | int        | int            | int32   | Fixnum 或者 Bignum（根据需要） | int        | integer        |
  | sfixed64    | 总是8个字节                                                  | int64    | long       | int/long       | int64   | Bignum                         | long       | integer/string |
  | bool        |                                                              | bool     | boolean    | bool           | bool    | TrueClass/FalseClass           | bool       | boolean        |
  | string      | 一个字符串必须是UTF-8编码或者7-bit ASCII编码的文本。         | string   | String     | str/unicode    | string  | String (UTF-8)                 | string     | string         |
  | bytes       | 可能包含任意顺序的字节数据。                                 | string   | ByteString | str            | []byte  | String (ASCII-8BIT)            | ByteString | string         |

- **编号**

  在消息定义中，每个字段都有唯一的一个数字标识符。这些标识符是用来在消息的二进制格式中识别各个字段的，一旦开始使用就不能够再改变。注：[1,15]之内的标识号在编码的时候会占用一个字节。[16,2047]之内的标识号则占用2个字节。所以应该为那些频繁出现的消息元素保留 [1,15]之内的标识号。切记：要为将来有可能添加的、频繁出现的标识号预留一些标识号

### 4. 普通字段

其中类型可以是以下几种类型：

- 数字类型： double、float、int32、int64、uint32、uint64、sint32、sint64: 存储长度可变的浮点数、整数、无符号整数和有符号整数
- 存储固定大小的数字类型：fixed32、fixed64、sfixed32、sfixed64: 存储空间固定
- 布尔类型: bool
- 字符串: string
- bytes: 字节数组
- messageType: 消息类型
- enumType:枚举类型

字段名、消息名、枚举类型名、map名、服务名等名称首字母必须是字母类型，然后可以是字母、数字或者下划线_

`repeated`允许字段重复，对于Go语言来说，它会编译成数组(`slice of type`)类型的格式。

### 保留标识符（Reserved）

如果你通过删除或者注释所有域，以后的用户可以重用标识号当你重新更新类型的时候。如果你使用旧版本加载相同的.proto文件这会导致严重的问题，包括数据损坏、隐私错误等等。现在有一种确保不会发生这种情况的方法就是指定保留标识符（and/or names, which can also cause issues for JSON serialization不明白什么意思），protocol buffer的编译器会警告未来尝试使用这些域标识符的用户。

```protobuf
message Foo {
 reserved 2, 15;
 reserved "foo", "bar";
}
```

### Oneof

如果你有一组字段，同时最多允许这一组中的一个字段出现，就可以使用`Oneof`定义这一组字段，这有点Union的意思，但是Oneof允许你设置零各值。

因为proto3没有办法区分正常的值是否是设置了还是取得缺省值(比如int64类型字段，如果它的值是0，你无法判断数据是否包含这个字段，因为0几可能是数据中设置的值，也可能是这个字段的零值)，所以你可以通过Oneof取得这个功能，因为Oneof有判断字段是否设置的功能。

```protobuf
syntax = "proto3";

package abc;

message OneofMessage {
    oneof test_oneof {
      string name = 4;
      int64 value = 9;
    }
  }
```

`oneof`字段不能同时使用`repeated`。

### Map类型

map类型需要设置键和值的类型，格式是`"map" "<" keyType "," type ">" mapName "=" fieldNumber [ "[" fieldOptions "]"`。

比如:

```protobuf
map<int64,string> values = 1;
```

`map`字段不能同时使用`repeated`。

### 枚举类型

枚举类型也是常用的一种类型，它限定字段的值只能取某个特定的值，比如星期类型只能取周一到周日七个值。

注意枚举类型的定义采用C++ scoping规则，也就是枚举值是枚举类型的兄弟类型，而不是子类型，所以避免在同一个package定义重名的枚举字段。

**proto3在你定义value时, 强制要求第一个值必须为0**

```protobuf
     enum Corpus {
         UNIVERSAL = 0;//第一个枚举值，这里的数字必须是0，不然编译不通过
         WEB = 1;
         //WEB1 = 1;//这里编译不通过，数字1只能对应一个枚举值。
         IMAGES = 2;
         LOCAL = 3;
         NEWS = 4;
         PRODUCTS = 5;
         VIDEO = 6;
     }
     Corpus corpus = 4;
     
       // 你可以为枚举常量定义别名。 需要设置allow_alias option 为 true, 否则 protocol编译器会产生错误信息。
   
     enum EnumAllowingAlias {
         option allow_alias = true;
         UNKNOWN = 0;
         STARTED = 1;
         RUNNING = 1;
     }
```



### 嵌套类型

嵌套类型就是消息类型里面定义了消息类型：

```protobuf
message SearchResponse {
  message Result {
    string url = 1;
    string title = 2;
    repeated string snippets = 3;
  }
  repeated Result results = 1;
}
```

如果`Result`不需要共用，只被`SearchResponse`使用，可以采用这种定义方式， 如果你需要在外部使用这个类型，其实你也可以使用，但是不如把这个内部的消息类型定义抽取出来，除非你有很特别的含义：

### Any

`Any`字段允许你处理嵌套数据，并不需要它的proto定义。一个`Any`以bytes呈现序列化的消息，并且包含一个URL作为这个类型的唯一标识和元数据。

为了使用`Any`类型，你需要引入`google/protobuf/any.proto`编码

首先，我们先了解`varint`方法。`varint`方法是一种使用变长方式表示整数的方法，可以使用一个或者多个字节来表示小整数和大整数，数越小，使用的字节数越少。

在`varint`表示的字节中，除了最后一个字节，前面的字节都有一个bit来表示还有字节需要处理，这个标记叫做most significant bit (msb) set。低位放在前面。

比如`1`表示为`0000 0001`。最高位0表示这是最后一个字节了，只用一个字节就可以表示。

数字`300`表示为`1010 1100 0000 0010`, 两个字节来表示。每个字节高位去掉即可: `010 1100 000 0010`,反转`000 0010 010 1100`,去掉前面的0，也就是`100101100`, 2^8 + 2^5 + 2^3 + 2^2= 256+32+8+4=300。

Go标准库`encoding/binary`有对`varint`处理[方法](https://golang.org/src/encoding/binary/varint.go)。

事实上。Protobuf是编码的键值对，其中键用varint来表示，其中后三位代表wire type。

Protobuf只定义了6种wire类型。
[![img](https://colobu.com/2019/10/03/protobuf-ultimate-tutorial-in-go/wire-type.png)](https://colobu.com/2019/10/03/protobuf-ultimate-tutorial-in-go/wire-type.png)

对于字段比较少(2^4=16)情况，使用一个字节就可以表示key

### 默认值

当一个消息被解析的时候，如果被编码的信息不包含一个特定的singular元素，被解析的对象锁对应的域被设置位一个默认值，对于不同类型指定如下：

- 对于strings，默认是一个空string

- 对于bytes，默认是一个空的bytes

- 对于bools，默认是false

- 对于数值类型，默认是0

- 对于枚举，默认是第一个定义的枚举值，必须为0;

- 对于消息类型（message），域没有被设置，确切的消息是根据语言确定的，详见[generated code guide](https://developers.google.com/protocol-buffers/docs/reference/overview?hl=zh-cn)

  对于可重复域的默认值是空（通常情况下是对应语言中空列表）。

  注：对于标量消息域，一旦消息被解析，就无法判断域释放被设置为默认值（例如，例如boolean值是否被设置为false）还是根本没有被设置。你应该在定义你的消息类型时非常注意。例如，比如你不应该定义boolean的默认值false作为任何行为的触发方式。也应该注意如果一个标量消息域被设置为标志位，这个值不应该被序列化传输。



### 更新消息

- 不要更改任何已有的字段的数值标识。
- 如果你增加新的字段，使用旧格式的字段仍然可以被你新产生的代码所解析。你应该记住这些元素的默认值这样你的新代码就可以以适当的方式和旧代码产生的数据交互。相似的，通过新代码产生的消息也可以被旧代码解析：只不过新的字段会被忽视掉。注意，未被识别的字段会在反序列化的过程中丢弃掉，所以如果消息再被传递给新的代码，新的字段依然是不可用的（这和proto2中的行为是不同的，在proto2中未定义的域依然会随着消息被序列化）
- 非required的字段可以移除——只要它们的标识号在新的消息类型中不再使用（更好的做法可能是重命名那个字段，例如在字段前添加“OBSOLETE_”前缀，那样的话，使用的.proto文件的用户将来就不会无意中重新使用了那些不该使用的标识号）。
- int32, uint32, int64, uint64,和bool是全部兼容的，这意味着可以将这些类型中的一个转换为另外一个，而不会破坏向前、 向后的兼容性。如果解析出来的数字与对应的类型不相符，那么结果就像在C++中对它进行了强制类型转换一样（例如，如果把一个64位数字当作int32来 读取，那么它就会被截断为32位的数字）。
- sint32和sint64是互相兼容的，但是它们与其他整数类型不兼容。
- string和bytes是兼容的——只要bytes是有效的UTF-8编码。
- 嵌套消息与bytes是兼容的——只要bytes包含该消息的一个编码过的版本。
- fixed32与sfixed32是兼容的，fixed64与sfixed64是兼容的。
- 枚举类型与int32，uint32，int64和uint64相兼容（注意如果值不相兼容则会被截断），然而在客户端反序列化之后他们可能会有不同的处理方式，例如，未识别的proto3枚举类型会被保留在消息中，但是他的表示方式会依照语言而定。int类型的字段总会保留他们的
