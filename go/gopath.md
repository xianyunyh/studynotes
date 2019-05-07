# gopath基础概念

## GOROOT

`GOROOT` 就是golang的安装目录。

## GOBIN

go install编译存放路径。**不允许**设置多个路径。可以为空。为空时则遵循“约定优于配置”原则，可执行文件放在各自**GOPATH目录的bin**文件夹中（前提是：package main的main函数文件不能直接放到GOPATH的src下面。

##  GOPATH

go命令依赖的一个重要环境变量：`$GOPATH  `其实可以把这个目录理解为工作目录

具体用途：go命令常常需要用到的，如go run，go install， go get等。允许设置多个路径，和各个系统环境多路径设置一样，windows用“;”，linux（mac）用“:”分隔。 

```
goWorkSpace  // (goWorkSpace为GOPATH目录)
  -- bin  // golang编译可执行文件存放路径，可自动生成。
  -- pkg  // golang编译的.a中间文件存放路径，可自动生成。
  -- src  // 源码路径。按照golang默认约定，go run，go install等命令的当前工作路径（即在此路径下执行上述命令）。
```

### Go目录结构

```
project1 // (project1添加到GOPATH目录了)
  -- bin
  -- pkg
  -- src  
     -- models       // package
     -- controllers  // package
     -- main.go      // package main［注意，本文所有main.go均指包main的入口函数main所在文件］
 project2 // (project2添加到GOPATH目录了)
      -- bin
      -- pkg
      -- src
         -- models       // package
         -- controllers  // package
         -- main.go      // package main
```

### go get  [main.go所在路径]

参数 [main.go所在路径]：可选。相对GOPATH/src路径。 缺省是.(src自己)。可指定src下面的子文件夹路径。  go get会做2件事：

1. 从远程下载需要用到的包。
2. 2.执行go install。 



### go install [main.go所在路径]

参数 [main.go所在路径]：可选。 相对**GOPATH/src**路径。缺省是.(即当前所在目录或工作目录)。可指定src下面的子文件夹。 
`go install`编译生成名称为[`main.go`父文件夹名]的可执行文件，放到GOBIN路径下。当GOBIN为空时，默认约定是：生成的可执行文件放到`GOPATH/bin`文件夹中。产生的中间文件（.a）放在project/pkg中（没有变化时，不重新生成.a）。
