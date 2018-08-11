## 深拷贝和浅拷贝
在js中，我们经常会听到深拷贝和浅拷贝，自己也是一头雾水，查阅资料发现，原来就是一个指针的意思

### 浅拷贝

浅拷贝的意思就是放一个变量进行赋值给另外一个值的时候，两个值的地址是一样，改变一个值的时候，两外一个也会随着改变。 类似php的&

```php
$a = 1;
$b = &a;

$b =3; //$a=3

```

```javascript
let object1 = {
    user: "xian",
    age: 12
}

let object2 = object1;//浅拷贝。

object2.age = 25;

console.log("object1.age",object1.age);//25
//object2 我们只是复制了一个变量， 但是这个变量却跟之前的指向同一个地址空间，产生了非预期效果。
```

### 深拷贝

深拷贝就是我们其他编程语言中的，值拷贝，地址空间会发生变量

```javascript
let object1 = {
    user:"xian",
    age:12
}

let object2 = Object.assign({},object1);

object2.age = 24;

console.log('object1.age',object1.age);//12

```
### es6 对象展开符
es6中增加了一个很方便的操作运算符，方便我们进行深拷贝

```javascript
let object1 = {
    user:"xian",
    age:12
}

let object2 = {...object1}

object2.age = 24

console.log(object1.age)

```
 对象合并
 
 ```javascript
 let a = {
     'u':1,
     'b':2
 }
 let b = {
     'd':3
 }
 
 let c = {...a,...b}
 
 console.log(c)
 ```
 ### 注意事项
 
 使用展开符可能使用会出现我们预想不到的结果，对象属性的值的值还是引用.这就是一个副作用的例子
 
 ```javascript
 
const k = {a:[1,2,3,4]}

const t = {...k}

t.a[0] = 9

console.log(k)

```

### 参考链接
- [http://lucybain.com/blog/2018/js-es6-spread-operator/](http://lucybain.com/blog/2018/js-es6-spread-operator/)