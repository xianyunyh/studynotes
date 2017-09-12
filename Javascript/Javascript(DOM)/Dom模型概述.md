## DOM

DOM (document object model) 文档对象模型。

DOM的最小组成单位叫做节点（node）。文档的树形结构（DOM树），就是由各种不同类型的节点组成。每个节点可以看作是文档树的一片叶子

节点的类型有七种

- Document：整个文档树的顶层节点
- DocumentType：doctype标签（比如<!DOCTYPE html>）
- Element：网页的各种HTML标签（比如<body>、<a>等）
- Attribute：网页元素的属性（比如class="right"）
- Text：标签之间或标签包含的文本
- Comment：注释
- DocumentFragment：文档的片段


### 节点树

一个文档的所有节点，按照所在的层级，可以抽象成一种树状结构。这种树状结构就是DOM。
一个节点和周围的节点有三种关系。

子节点接口包括firstChild（第一个子节点）和lastChild（最后一个子节点）等属性，同级节点接口包括nextSibling（紧邻在后的那个同级节点）和previousSibling（紧邻在前的那个同级节点）属性

1. 子节点
2. 兄弟节点
3. 父节点

### 节点对象Node


#### 1. Node.nodeName，Node.nodeType

nodeName属性返回节点的名称，nodeType属性返回节点类型的常数值


    ELEMENT_NODE	大写的HTML元素名	1
    ATTRIBUTE_NODE	等同于Attr.name	2
    TEXT_NODE	#text	3
    COMMENT_NODE	#comment	8
    DOCUMENT_NODE	#document	9
    DOCUMENT_FRAGMENT_NODE	#document-fragment	11
    DOCUMENT_TYPE_NODE	等同于DocumentType.name	10

#### 2. Node.nodeValue

Node.nodeValue属性返回一个字符串，表示当前节点本身的文本值，该属性可读写

由于只有Text节点、Comment节点、XML文档的CDATA节点有文本值，因此只有这三类节点的nodeValue可以返回结果，其他类型的节点一律返回null

```

```
#### 3. Node.textContent

获取当前节点和它的所有后代节点的文本内容。

```
document.getElementById('test').textValue
```

> document节点和doctype节点的textContent属性为null。如果要读取整个文档的内容，可以使用document.documentElement.textContent

#### 4. Node.baseURI

表示当前网页的绝对路径。如果无法取到这个值，则返回null.只读

```
document.baseURI
```

### 相关节点的属性

以下属性返回当前节点的相关节点。

- Node.ownerDocument

Node.ownerDocument属性返回当前节点所在的顶层文档对象，即document对象

```
<div id="test"> </div>
document.getElementById('test').ownerDocument
```

- nextSibling、previousSibling、parentNode、parentElement、childNodes、Node.firstChild，Node.lastChild

获取下一个兄弟节点、上一个兄弟节点、父节点、子节点集合

```

<ul id="parent">
<li>1111</li>
<li id="test">222</li>
<li>333</li>
<li>444</li>
</ul>

document.getElementById('test').nextSibling.textContent //3333

document.getElementById('test').parentNode //<ul></ul>

document.getElementById('parent').childNodes

```

### 节点对象的方法

- appendChild()