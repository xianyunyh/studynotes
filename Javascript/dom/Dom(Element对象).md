## element对象

Element对象对应网页的HTML标签元素。每一个HTML标签元素，在DOM树上都会转化成一个Element节点对象

### 特征相关的属性

- Element.attributes

获取节点的所有属性。是一个类数组的对象。


- Element.id Element.tagName 

节点的id名字。标签名

- Element.innerHTML

节点内部的html内容。不包括节点的html标签

- Element.outHTML 

节点的html 。包括本身的标签

```
<div id="app"><span>111</span></div>

var app =document.getElementById('app')

app.innerHTML //<span>111</span>

app.outHTML //<div id="app"><span>111</span></div>

```

- Element.className，Element.classList

className属性用来读写当前元素节点的class属性。它的值是一个字符串，每个class之间用空格分割

classList属性则返回一个类似数组的对象.

1. add()：增加一个class。
1. remove()：移除一个class。
1. contains()：检查当前元素是否包含某个class。
1. toggle()：将某个class移入或移出当前元素。
1. item()：返回指定索引位置的class。
1. toString()：将class的列表转为字符串。


### 属性相关的方法

- Element.getAttribute()：读取指定属性
- Element.setAttribute()：设置指定属性
- Element.hasAttribute()：返回一个布尔值，表示当前元素节点是否有指定的属性
- Element.removeAttribute()：移除指定属性


### 查找相关的方法

- Element.querySelector()
- Element.querySelectorAll()
- Element.getElementsByTagName()
- Element.getElementsByClassName()
- Element.closest() //返回当前元素节点的最接近的父元素（或者当前节点本身）
- Element.match()
Element.match方法返回一个布尔值，表示当前元素是否匹配给定的CSS选择器

```
if (el.matches('.someClass')) {
  console.log('Match!');
}

```

### 事件相关的方法

- Element.addEventListener()：添加事件的回调函数
- Element.removeEventListener()：移除事件监听函数
- Element.dispatchEvent()：触发事件

```
element.addEventListener('click', function(){
    
}, false);
element.removeEventListener('click', function(){
    
}, false);

var event = new Event('click');
element.dispatchEvent(event);

```

### 其他方法

- Element.scrollIntoView() Element.scrollIntoView方法滚动当前元素
-  Element.getBoundingClientRect()

Element.getBoundingClientRect方法返回一个对象，该对象提供当前元素节点的大小、位置等信息，基本上就是CSS盒状模型提供的所有信息。

```
x：元素左上角相对于视口的横坐标
left：元素左上角相对于视口的横坐标，与x属性相等
right：元素右边界相对于视口的横坐标（等于x加上width）
width：元素宽度（等于right减去left）
y：元素顶部相对于视口的纵坐标
top：元素顶部相对于视口的纵坐标，与y属性相等
bottom：元素底部相对于视口的纵坐标
height：元素高度（等于y加上height）
```
