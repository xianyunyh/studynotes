## css 操作

```

<div id="app" style="width:100px;height:200px;border:1px solid #ccc"> app</div>

var app = document.getElementById('app')

```

- style属性

更改节点的样式的，最简单的方法就是更改节点属性的style属性

```
app.setAttribute('style',"font-size:20px")

```

### style对象

每个节点对象都有一个style属性。这个属性也是一个对象。

```
app.style.width //100px
app.style.width="200px"
app.style.fontSize="20px"
```

### cssText属性

可以通过cssText属性更改css

```

app.cssText="width:100px"
```

## 改写内部属性

style对象的以下三个方法，用来读写行内CSS规则
```
setProperty()，getPropertyValue()，removeProperty()

app.style.setProperty('background-color','#f00')
console.log(app.style.getPropertyValue('background-color'))//rgb(255,0,0)
```

### getComputedStyle

> CSS伪元素是通过CSS向DOM添加的元素，主要方法是通过:before和:after选择器生成伪元素，然后用content属性指定伪元素的内容。window.getComputedStyle方法，就用来返回这个规则。它接受一个DOM节点对象作为参数，返回一个包含该节点最终样式信息的对象


```

window.getComputedStyle(app, ':before')
```

## StyleSheet对象

### 获取样式表 styleSheets

```
<link rel="stylesheet" type="text/css" href="css/css.css" id="css1">

sheets = documemt.styleSheets //获取页面中所有的外部链接css

//通过id获取

sheet = document.getElementById('css1').sheet
sheets[0].rel //stylesheet

```

### sheet属性

StyleSheet对象有以下属性

- media属性
- disabled属性
- href属性
- title属性
- title属性
- parentStyleSheet属性
- ownerNode属性
- insertRule()，deleteRule()
- cssRules属性

通过cssRule属性可以读取到css文件的样式属性


```
#app{width:20px}
sheet.cssRule[0].witdh //20px
```
- 创建一个样式表

```
var linkElm = document.createElement('link');
linkElm.setAttribute('rel', 'stylesheet');
linkElm.setAttribute('type', 'text/css');
linkElm.setAttribute('href', 'reset-min.css');
document.head.appendChild(linkElm);
```

### meidia

window.matchMedia方法用来检查CSS的mediaQuery语句。各种浏览器的最新版本（包括IE 10+）都支持该方法

根据对应的media加载样式

```
var result = window.matchMedia("(max-width: 700px)");

if (result.matches){
  var linkElm = document.createElement('link');
  linkElm.setAttribute('rel', 'stylesheet');
  linkElm.setAttribute('type', 'text/css');
  linkElm.setAttribute('href', 'small.css');

  document.head.appendChild(linkElm);
}
```
#### 监听事件

window.matchMedia方法返回的MediaQueryList对象有两个方法，用来监听事件：addListener方法和removeListener方法。

```
var mql = window.matchMedia("(max-width: 700px)");

// 指定回调函数
mql.addListener(mqCallback);

// 撤销回调函数
mql.removeListener(mqCallback);

```

### css动画事件

- transitionEnd事件 过渡结束
- animationstart事件，animationend事件，animationiteration事件