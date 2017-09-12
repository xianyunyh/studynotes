## document节点

document节点是文档的根节点，每张网页都有自己的document节点。window.document属性就指向这个节点。只要浏览器开始载入HTML文档，这个节点对象就存在了，可以直接调用

1. 对于正常的网页，直接使用document或window.document。
2. 对于iframe载入的网页，使用iframe节点的contentDocument属性。
3. 对Ajax操作返回的文档，使用XMLHttpRequest对象的responseXML属性。
4. 对于包含某个节点的文档，使用该节点的ownerDocument属性。


### 内部节点的属性

- **document.doctype，document.documentElement，document.defaultView**

```
var doctype = document.doctype;
doctype // "<!DOCTYPE html>"
doctype.name // "html"
document.documentElement //属性返回当前文档的根节点（root）
```
- **document.body，document.head**

document.head属性返回当前文档的<head>节点，document.body属性返回当前文档的<body>

```
document.head === document.querySelector('head') // true
document.body === document.querySelector('body') // true
```
- **document.activeElement**

document.activeElement属性返回当前文档中获得焦点的那个元素

### 节点集合属性

以下属性返回文档内部特定元素的集合，**都是类似数组的对象**
- **document.links，document.forms，document.images，document.embeds
**
document.links属性返回当前文档所有设定了href属性的a及area元素。

document.forms属性返回页面中所有表单元素form。
document.images属性返回页面所有图片元素（即img标签）

document.embeds属性返回网页中所有嵌入对象，即embed标签
以上四个属性返回的都是HTMLCollection对象实例

```
<a href="">a</a>
<form></form>
<img/>
```
- **document.scripts，document.styleSheets**

document.scripts属性返回当前文档的所有脚本
document.styleSheets属性返回一个类似数组的对象，代表当前网页的所有样式表

### 文档信息属性

- **document.documentURI，document.URL**

document.documentURI属性和document.URL属性都返回一个字符串，表示当前文档的网址。不同之处是documentURI属性可用于所有文档（包括 XML 文档），URL属性只能用于 HTML 文档

- **document.domain**

获取当前的域名

- **document.lastModified**
- **document.location** 获取locaiton对象

```
document.location.href // "http://user:passwd@www.example.com:4097/path/a.html?x=111#part1"
document.location.protocol // "http:"
document.location.host // "www.example.com:4097"
document.location.hostname // "www.example.com"
document.location.port // "4097"
document.location.pathname // "/path/a.html"
document.location.search // "?x=111"
document.location.hash // "#part1"
document.location.user // "user"
document.location.password // "passed"

```

location对象有以下方法

1. location.assign()
1. location.reload()
1. location.toString()

- **document.referrer，document.title，document.characterSet**

document.referrer属性返回一个字符串，表示当前文档的访问来源，如果是无法获取来源或是用户直接键入网址，而不是从其他网页点击，则返回一个空字符串。

document.referrer的值，总是与HTTP头信息的Referer保持一致，但是它的拼写有两个r。

document.title属性返回当前文档的标题，该属性是可写的。

- **document.readyState**

document.readyState属性返回当前文档的状态，共有三种可能的值。

1. loading：加载HTML代码阶段（尚未完成解析）
1. interactive：加载外部资源阶段时
1. complete：加载完成时


### 读写相关的方法

- document.open()，document.close()打开或者关闭网页
- document.write()，document.writeln() 写入数据到页面


### 查找节点的方法

1. document.querySelector(selector)，document.querySelectorAll(selector)

根据css选择器查找节点

```
document.querySelector(“#app”)，
document.querySelectorAll(".class1")
```
2. document.getElementsByTagName(tagName) 方法返回所有指定HTML标签的元素
3. document.getElementsByClassName(class) 通过class名字获取节点
4. document.getElementsByName(id) 通过属性为name的属性获取节点
5. getElementById() 通过id获取元素
6. document.elementFromPoint(x,y)

    elementFromPoint方法的两个参数，依次是相对于当前视口左上角的横坐标和纵坐标


### 生成节点的方法

- document.createElement() 创建节点

```
document.createElement('div') //

```
- document.createTextNode()创建文本节点

```
document.createTextNode('Hello')

```
- document.createAttribute() 创建属性

```
div = document.createElement('div')
attr=document.createAttribute('class')
attr.value="test"
div.setAttribute(attr)
document.body.appendChild(div)
```

- document.createDocumentFragment()

createDocumentFragment方法生成一个DocumentFragment对象。


### 事件相关的方法

- document.createEvent()

document.createEvent方法生成一个事件对象，该对象可以被element.dispatchEvent方法使用，触发指定事件

createEvent方法的参数是事件类型，比如UIEvents、MouseEvents、MutationEvents、HTMLEvents。

### 其他方法

- document.createNodeIterator()，document.createTreeWalker()

document.createNodeIterator方法返回一个DOM的子节点遍历器。
```
var nodeIterator = document.createNodeIterator(
  document.body,
  NodeFilter.SHOW_ELEMENT
);
```

document.createTreeWalker方法返回一个DOM的子树遍历器。它与createNodeIterator方法的区别在于，后者只遍历子节点，而它遍历整个子树。

document.createTreeWalker方法的第一个参数，是所要遍历的根节点，第二个参数指定所要遍历的节点类型。

- document.importNode() 从外部文档拷贝一个节点。