## 数组解构

> 数组解析 就是把数组的值赋值给变量 类似于php的list

    let [a,b] = [1,2];
    
    console.log(a)//1
    console.log(b)//2
    
    
## 对象的解构

    let {"a","b"} = {"foo":'1',"tt":"d"}
    // 默认值写法
    let {a=1} = {}
    
## 字符串的解构

    const [a, b, c, d, e] = 'hello';
    console.log(a) //h

