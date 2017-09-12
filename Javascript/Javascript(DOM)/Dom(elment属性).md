## node节点属性

- **attributes**

每个节点都有一个attitude属性。这是属性的集合。

```
<div id="app"  data-user="tian">
</div>

var app = document.getElmentById('app')

var attrs = app.attributes //

attrs[0].name //id

attrsp[0].value //app

```

- **节点对象的属性**

HTML元素的属性名是大小写不敏感的，但是JavaScript对象的属性名是大小写敏感的。转换规则是，转为JavaScript属性名时，一律采用小写。如果属性名包括多个单词，则采用骆驼拼写法，即从第二个单词开始，每个单词的首字母采用大写，比如==onClick==

```

app.id //app
```

- **节点属性的方法**

```
getAttribute()
setAttribute()
hasAttribute()
removeAttribute()
```

```
app.getAttribute('id') //app

app.setAttribute('class','appClass') 

if(app.hasAttrbite('class')) {
    
}
app.removeAttribute('class')

```

- **dataset **

dataset属性解决自定义属性。使用标准提供的data-*属性。

```
app.dataset.user //tian

```