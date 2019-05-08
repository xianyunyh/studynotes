## new & make

new 和make 都是内置函数，用来分配内存变量

### 变量的声明

```go
var i int 
var s string
```

变量的声明我们可以通过`var`关键字，然后就可以在程序中使用。当我们不指定变量的默认值时，这些变量的默认值是他们的零值，比如`int`类型的零值是0,`string`类型的零值是`""`，引用类型的零值是`nil`。 

对于引用类型需要赋值的时候，就需要用到new和make。

### new

new 返回是是类型的指针。指向分配类型的地址。

```
var i = new(int)

*i = 10;
```

### make

`make`也是用于内存分配的，但是和`new`不同，它只用于**`chan`、`map`以及切片**的内存创建，而且它**返回的类型就是这三个类型本身**，而不是他们的指针类型，因为这三种类型就是引用类型，所以就没有必要返回他们的指针了 

```
var m = make(maps[string]string)
```



### 参考资料

- [https://www.flysnow.org/2017/10/23/go-new-vs-make.html](https://www.flysnow.org/2017/10/23/go-new-vs-make.html)

