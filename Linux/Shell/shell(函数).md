## 函数

shell中的函数 定义如下


```
其中function是可以省略的
[function] functionName(){}

function test(){
    
}

test(){
    
}

```

- 函数的调用


函数的调用和其他语言的调用不太一样


```
function test()
{
    echo "hello"
}

test #调用函数

```

- 函数的参数


函数的参数定义不需要在()中定义形参 只需要在调用使用传入即可

$n n代表整数 $1是第一个参数 以此类推
```
function test()
{
    echo $1 # 第一个参数 以此类推
}

test 22 //22
```
