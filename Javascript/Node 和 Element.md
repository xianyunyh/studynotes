## Node 和 Element

关于Element跟Node的区别，cilldren跟childNodes的区别很多朋友弄不清楚，本文试图让大家明白这几个概念之间的区别。

　　Node(节点)是DOM层次结构中的任何类型的对象的通用名称，Node有很多类型，如元素节点，属性节点，文本节点，注释节点等，通过NodeType区分，常见的有：

| 节点类型     | NodeType |
| ------------ | -------- |
| 元素element  | 1        |
| 属性attr     | 2        |
| 文本text     | 3        |
| 注释comments | 8        |
| 文档document | 9        |

 **Element继承了Node类，也就是说Element是Node多种类型中的一种**，即当NodeType为1时Node即为ElementNode，另外Element扩展了Node，Element拥有id、class、children等属性。 

## Node的属性和方法

### 属性

- Node.childNodes 返回子节点的NodeList列表
- Node.firstChild 第一个子节点
- Node.lastChild 最后一个子节点
- Node.nextChild下一个节点
- Node.parentNode 当前节点Node父节点
- Node.nodeName 节点的名字
- Node.nodeType  与该节点类型对应的`无符号短整型`的值 
- Node.nodeValue 返回或设置当前节点的值 
- **Node.textContent**  获取或设置一个标签内所有子结点及其后代的文本内容。 

### 方法

- Node.appendChild() 添加一个节点到当前节点
- Node.contains()是否包含
- Node.insertBefore 前面插入一个节点
- Node.removeChild() 删除节点
- Node.replaceChild 替换节点



## NodeList

`NodeList` 对象是一个节点的集合，是由 [`Node.childNodes`](https://developer.mozilla.org/zh-CN/docs/Web/API/Node/childNodes) 和[`document.querySelectorAll`](https://developer.mozilla.org/zh-CN/docs/Web/API/Document/querySelectorAll) 返回的. 

### 属性

- length

### 方法

- item()

  返回NodeList对象中指定索引的节点,如果索引越界,则`返回null`.等价的写法是`nodeList[idx], 不过这种情况下越界访问将返回undefined.` 

- entries()

- keys()

- values()

- forEach()

```js
for (var i = 0; i < myNodeList.length; ++i) {
  var item = myNodeList[i];  // 调用 myNodeList.item(i) 是没有必要的
}
```

Nodelist to Array

```js
var div_list = document.querySelectorAll('div'); // 返回 NodeList
var div_array = Array.prototype.slice.call(div_list); // 将 NodeList 转换为数组

//ES6 - Array.from();
var div_array_from = Array.from(div_list); //将 NodeList 转换为数组
```

## Element

**Element**是非常通用的基类，所有 [`Document`](https://developer.mozilla.org/zh-CN/docs/Web/API/Document)对象下的对象都继承它. 这个接口描述了所有相同种类的元素所普遍具有的方法和属性 

### 属性

- attributes 相关属性集合
- classList 包含class属性的 list
- className 元素的class
- id 元素的id
- name
- innnerHTML 元素的内容HTML文本
- outerHTML
- lastElementChild 最后一个子元素
- tagName 标签名称



### 方法

- find()
- findAll()
- getAttribute(name) 获取属性的值
- hasAttribute(name) 是否含有属性
- removeAttribute(name) 移除属性
- setAttribute(name, value)设置属性
- querySelector()
- querySelectorAll()
- getElementsByClassName() 参数中给出类的列表 
- getElementsByTagName()
