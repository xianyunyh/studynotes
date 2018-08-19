
## for of 

> for...of语句在可迭代对象(包括 Array, Map, Set, String, TypedArray，arguments 对象等等)上创建一个**迭代循环**，对每个不同属性的属性值,调用一个自定义的有执行语句的迭代挂钩.

语法：

for(i of iterable){}

- 遍历数组


	var arr = [10,20,30]
	
	for(let i of arr){
		console.log(i);//10 20 30
	}

- 遍历 String:


	let iterable = "boo";
	
	for (let value of iterable) {
	  console.log(value);
	}
	// "b"
	// "o"
	// "o"


- 遍历Map:


	let iterable = new Map([["a", 1], ["b", 2], ["c", 3]]);
	
	for (let entry of iterable) {
	  console.log(entry);
	}
	// [a, 1]
	// [b, 2]
	// [c, 3]
	
	for (let [key, value] of iterable) {
	  console.log(value);
	}
	// 1
	// 2
	// 3


for in 和for ....of、forEach的区别

for in 是遍历每一个枚举对象的属性。

for of是遍历每个拥有[Symbol.iterator] 属性的collection对象的每个元素

forEarch 是遍历每个**<span style="color:red">数组</span>**的元素.


	var arr = [10,20,30]
	
	for(let i of arr){
		console.log(i);//10 20 30
	}

	for (let i in arr){
		console.log(i);// 0 1 2
	}

	arr.forEach(function(val){
		console.log(val);//10 20 30 
	})

参考文章：[https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Statements/for...of#for...of与for...in的区别](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Statements/for...of#for...of与for...in的区别 "https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Statements/for...of#for...of与for...in的区别")