## JSON 对象

JSON格式（JavaScript Object Notation的缩写）是一种用于数据交换的文本格式。

**JSON对值的类型和格式有严格的规定**


- 复合类型的值只能是数组或对象，不能是函数、正则表达式对象、日期对象。
- 
- 简单类型的值只有四种：字符串、数值（必须以十进制表示）、布尔值和null（不能使用NaN, Infinity, -Infinity和undefined）。
- 
- 字符串必须使用双引号表示，不能使用单引号。
- 
- 对象的键名必须放在双引号里面。
- 
- 数组或对象最后一个成员的后面，不能加逗号


```
["one", "two", "three"]

{ "one": 1, "two": 2, "three": 3 }

{"names": ["张三", "李四"] }

```

### JSON.stringify()

将一个值转成字符串

    JSON.stringify([1, "false", false])
    
### JSON.parse()

JSON.parse方法用于将JSON字符串转化成对象。

```
var o = JSON.parse('{"name": "张三"}');
o.name // 张三
```