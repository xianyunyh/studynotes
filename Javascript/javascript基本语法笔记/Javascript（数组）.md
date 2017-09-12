## 数组

数组是按次序排列的一组值。每个元素都有自己的序号。

本质上，数组属于一种特殊的对象。typeof运算符会返回数组的类型是object。



```
var arr = [1,2,3]

typeof arr === 'object' //true

Object.keys(arr) //获取所有的键名


```

### length 属性

length属性表示数组的成员数量。JavaScript使用一个32位整数，保存数组的元素个数。这意味着，数组成员最多只有4294967295个（232 - 1）个，也就是说length属性的最大值就是4294967295

length等于键名中最大数加1  因为从0 开始

```
var arr = [1,2]

arr[10] =4

arr.length // 11 而不是3

```

length属性是可写的。如果人为设置一个小于当前成员个数的值，该数组的成员会自动减少到length设置的值。


```
arr.length = 1

//那么2将不在该数组中了

arr.length = 0 //清空数组

```

将数组的键分别设为字符串和小数，结果都不影响length属性。因为，length属性的值就是等于最大的数字键加1

```
var arr =[]
arr['a'] = 10
arr.length //0

```

### 类似数组的对象

有些对象被称为“类似数组的对象”（array-like object）。意思是，它们看上去很像数组，可以使用length属性

```

var obj = {
    0:"a",
    1:"b"
    c:"c"
}

obj.length

```

### 数组的空位

数组的某个位置是空元素，即两个逗号之间没有任何值，我们称该数组存在空位
如果最后一个元素后面有逗号，并不会产生空位。也就是说，有没有这个逗号，结果都是一样的

```
var a = [1, , 1];
a.length // 3

var b= [1,2,3,]
b.length //3

```

### 数组的遍历


```

var arr = [1,2,3]

arr.forEach(function(v){
    console.log(v)
})


for (var i =0;i<arr.length;i++) {
    console.log(arr[i])
}
```
