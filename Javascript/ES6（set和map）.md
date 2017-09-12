## set和map

set是一种类似数组的结构，但是里面的每一个元素不重复。

通过add方法向 Set 结构加入成员，结果表明 Set 结构不会添加重复的值。

    [2,3,4,5,6]
    const set = new Set()
    set.add(2)
    set.add(2)
    console.log(set)//[2]
    
    // 去除数组的重复成员
    [...new Set(array)]
    
    
Set 结构的实例有以下属性。

1. Set.prototype.constructor：构造函数，默认就是Set函数。
1. Set.prototype.size：返回Set实例的成员总数。


Set结构有以下方法

1. add(value)：添加某个值，返回Set结构本身。
1. delete(value)：删除某个值，返回一个布尔值，表示删除是否成功。
1. has(value)：返回一个布尔值，表示该值是否为Set的成员。
1. clear()：清除所有成员，没有返回值。


### Set结构遍历



Set 结构的实例有四个遍历方法，可以用于遍历成员。

    keys()：返回键名的遍历器
    values()：返回键值的遍历器
    entries()：返回键值对的遍历器
    forEach()：使用回调函数遍历每个成员
    
## WeakSet § 

WeakSet 结构与 Set 类似，也是不重复的值的集合。但是，它与 Set 有两个区别。

首先，WeakSet 的成员只能是==对象==，而不能是其他类型的值。


    let weak = new WeakSet()
    weak.add({})
    weak.add([1])
    
    
## Map

JavaScript 的对象（Object），本质上是键值对的集合（Hash 结构）

    const ma = new Map([
      ['name', '张三'],
      ['title', 'Author']
    ]);
        
    map.get('name')//张三
    
    
### Map的属性和方法


1. set

       map.set(key,value)

2. get

       map.get(key)
    
3. has

         map.has(key)//true or false
    
    
4. delete

        map.delete(key) // true or false
    
5. clear

    