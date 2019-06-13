## golang 函数

### 1. 函数的声明

```go
func functionName(param type) returntype {
    
}
```

函数的声明使用`func` 关键字，后面跟着函数名。函数名后 跟着输入的参数，最后面的返回值。参数列表可以返回值不是必须的

```go
func Sum(a int,b int) int{
    return a + b
}
```

如果函数的参数是相同的类型，可以合并

```go
func Sum(a,b int) int {
    return a+b
}
```

### 2. 多值返回

golang 支持多值返回。我们常见的是返回一个错误 来判断里面的结果

```go
func Sum(a int) (int,err) {
    return a,err
}
```

### 3. 命名返回

从函数中可以返回一个命名值。一旦命名了返回值，可以认为这些值在函数第一行就被声明为变量了。

 ```go
func Sum(a,b int) (c int) {
    c = a+b
}
 ```

默认返回c 也不用return。 c默认就已经声明成变量了。 不需要使用`c:=` 来进行赋值了

### 4. 不定参数

```go
func Sum(args ...int) (result int){
    for _,v := args {
        result = result+v
    }
}
Sum(1,3,2,3)
```

