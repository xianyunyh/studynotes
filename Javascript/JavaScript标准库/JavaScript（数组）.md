## 数组

Array 是JavaScript的内置对象，同时也是一个构造函数。可以用来生成数组

但是传入的参数的不同。会导致行为的不一致

```
var arr = new Array(2) //创建一个含有长度为2的空数组

var arr = new Array(3.2) //RangError

var arr = new Array('a') // ['a']

var arr = new Array(1,2,3) //[1,2,3]

//推荐使用字面量方式

var arr = [1,2,3]

```

### Array.isArray()

用户判断一个变量是不是数组

```

var arr = []

typeof arr // object 

Array.isArray(arr) //true

```

### Array实例的方法

1. valueOf toString

valueOf 返回数组本身

toString 返回数组的字符串

```
var arr = [1,2,3]

arr.valueOf() //[1,2,3]

arr.toString() // 1,2,3

```

2. push() 方法

向一个数组中末端添加一个数据

```
var arr = [1,2]

arr.push(2) // [1,2,3]

//合并两个数组 可以调用Array原型的apply

var a = [1]
varb = [2]
Array.prototype.push.apply(a,b)

```

3. pop()

删除数组末端的元素

```
var arr = [1,3]

arr.pop()// [1]

```

4. join()

join方法以参数作为分隔符，将所有数组成员组成一个字符串返回

```
var arr = [1,2,3]

arr.join("-") //1-2-3

//对于字符串

Array.prototype.join.call('hello', '-')

```

5. concat()

concat方法用于多个数组的合并。它将新数组的成员，添加到原数组的尾部

    [1, 2, 3].concat(4, 5, 6)
    

concat方法也可以用于将对象合并为数组，但是必须借助call方法

```
[].concat.call({a: 1}, {b: 2})
// [{ a: 1 }, { b: 2 }]

```

6. shift() 删除第一个元素

```
var arr = [1,2,3]

arr.shift() //1
arr //[2,3]

```

7. unshift 在第一个元素的位置插入元素

unshift方法用于在数组的第一个位置添加元素，并返回添加新元素后的数组长度
```
var arr = [1,23,5]
arr.unshift(10) //4

```

8. reverse 

反转数组，将数组的顺序倒置.返回倒置的数组

```
var arr = [1,2,3]

arr.reverse() //[3,2,1]
```

9. slice 

arr.slice(start_index, upto_index)

slice方法用于提取原数组的一部分，返回一个新数组，原数组不变

不包括结束位置的元素

```
var arr = [1,2,3,4]

arr.slice(1,3) //[2,3]
```
如果slice方法的参数是负数，则表示倒数计算的位置

```
arr.slice(-2,-1)// 从倒数第2个 截取到倒数第一个


```

10. splice()

splice方法用于删除原数组的一部分成员，并可以在被删除的位置添加入新的数组成员，返回值是被删除的元素。注意，该方法会改变原数组    

`arr.splice(index, count_to_remove, addElement1, addElement2, ...);
`

```
var a = ['a', 'b', 'c', 'd', 'e', 'f'];
a.splice(4, 2) // ["e", "f"]
a // ["a", "b", "c", "d"]
```

11. sort() 
sort方法对数组进行排序，不改变原数组。默认是按照字典顺序排序

```
[1,3,2].sort() //[1,2,3]
```

12. map()

map方法对数组的所有成员依次调用一个函数，根据函数结果返回一个新数组

```
//三个参数 当前元素，索引，数组本身
[1,2,3].map(function(elem, index, arr){
    return elem*10
}) //[10,20,30]
```

13. forEach()

forEach方法与map方法很相似，也是遍历数组的所有成员，执行某种操作，但是forEach方法一般不返回值，只用来操作数据

forEach 无法中断。
```
[1,2,3].forEach(function(item){
    
})
```

14. filter() 过滤

filter方法的参数是一个函数，所有数组成员依次执行该函数，返回结果为true的成员组成一个新数组返回。该方法不会改变原数组

```
[1,2,3,4].filter(function(item){
    return (item>3)
})
```

15. some()，every()

some和every用于断言数据中的元素是否符合某种条件

some方法是只要有一个数组成员的返回值是true

every方法则是所有数组成员的返回值都是true

```

[1,2,3,5].some(function(item){
    return (item>3)
})// true

[1,2,3,4,5].every(function(item){
    return (item>3)
})// false
```

16. indexOf()，lastIndexOf()

indexof() 返回元素首次的位置

lastIndexOf() 返回元素最后一次的位置


```
[1,2,3,4,1].indexOf(1) // 0

[1,2,3,4,1].lastIndexOf(1) // 4
```