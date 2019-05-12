## go 包

包就是把一些文件归类起来，方便复用。包的本质就是一个目录。比如`net`包 就是 net文件夹。这也是go语言中的一个命名习惯，包名和文件所在的目录名是一样的。 

go语言的包的命名，遵循简洁、小写、和go文件所在目录同名的原则，这样就便于我们引用，书写以及快速定位查找。 

### 包的命名

对于自己或者公司的项目。一般通过域名作为包名。防止和其他开发者重复。如果没有域名， 可以使用github的个人账号。

比如`github.com/xianyunyh`作为自己的包名

### main包

当把一个go文件的包名声明为`main`时，就等于告诉go编译程序，我这个是一个可执行的程序，那么go编译程序就会尝试把它编译为一个二进制的可执行文件。

一个`main`的包，一定会包含一个`main()`函数，这种我们也不陌生，比如C和Java都有`main()`函数,它是一个程序的入口，没这个函数，程序就无法执行。

>  在go语言里，同时要满足`main`包和包含`main()`函数，才会被编译成一个可执行文件。 

### 包的导入

包的导入使用`import` 

```go
package main

import "fmt"
```

>  对于包的查找，是有优先级的，编译器会优先在`GOROOT`里搜索，其次是`GOPATH`,一旦找到，就会马上停止搜索。如果最终都没找到，就报编译异常了。 

### 命名导入

我们在导入包的时候，可能会出现重名的情况，我们使用别名的方式解决

```go
package main

import (
	"fmt"
    myfmt "my/fmt"
)
```

Go语言规定，导入的包必须使用，否则会报编辑错误。如果不使用，可以使用 `_`屏蔽掉、

### 包含init函数

每个包都可以有任意多个`init`函数，这些`init`函数都会在`main`函数之前执行。`init`函数通常用来做初始化变量、设置包或者其他需要在程序执行前的引导工作。比如我们讲的需要使用`_`空标志符来导入一个包的目的，就是想执行这个包里的init函数 

这个函数就是类似PHP类中的构造函数`__construct` 或者python中的`__init__`

## go 命令

```
Go is a tool for managing Go source code.

Usage:

	go command [arguments]

The commands are:

	build       compile packages and dependencies
	clean       remove object files
	doc         show documentation for package or symbol
	env         print Go environment information
	bug         start a bug report
	fix         run go tool fix on packages
	fmt         run gofmt on package sources
	generate    generate Go files by processing source
	get         download and install packages and dependencies
	install     compile and install packages and dependencies
	list        list packages
	run         compile and run Go program
	test        test packages
	tool        run specified go tool
	version     print Go version
	vet         run go tool vet on packages

Use "go help [command]" for more information about a command.

Additional help topics:

	c           calling between Go and C
	buildmode   description of build modes
	filetype    file types
	gopath      GOPATH environment variable
	environment environment variables
	importpath  import path syntax
	packages    description of package lists
	testflag    description of testing flags
	testfunc    description of testing functions

Use "go help [topic]" for more information about that topic.
```

### go build

我们最常用的，就是编译成可执行文件。

`go build`本质上需要的是一个路径，让编译器可以找到哪些需要编译的go文件 `packages`其实是一个相对路径，是相对于我们定义的`GOROOT`和`GOPATH`这两个环境变量的，所以有了`packages`这个参数后，`go build`就可以知道哪些需要编译的go文件了。 

```shell
go build 
go build .
go build hello.go
gobuild tools/...
```

3个点表示匹配所有字符串，这样`go build`就会编译tools目录下的所有包。

Go提供了编译链工具，可以让我们在任何一个开发平台上，编译出其他平台的可执行文件（交叉编译）。 可以使用go env查看编译环境

注意里面两个重要的环境变量**GOOS**和**GOARCH**,其中GOOS指的是目标操作系统，它的可用值为：

1. darwin
2. freebsd
3. linux
4. windows
5. android
6. dragonfly
7. netbsd
8. openbsd
9. plan9
10. solaris

一共支持10中操作系统。**GOARCH**指的是目标处理器的架构，目前支持的有：

1. arm
2. arm64
3. 386
4. amd64
5. ppc64
6. ppc64le
7. mips64
8. mips64le
9. s390x

编译指定平台的目标文件

```
GOOS=linux GOARCH=amd64 go build tools/hello

```

### go clean

在我们使用`go build`编译的时候，会产生编译生成的文件，尤其是在我们签入代码的时候，并不想把我们生成的文件也签入到我们的Git代码库中，这时候我们可以手动删除生成的文件，但是有时候会忘记，也很麻烦，不小心还是会提交到Git中。要解决这个问题，我们可以使用`go clean`,它可以清理我们编译生成的文件 

### go run

`go build`是先编译，然后我们在执行可以执行文件来运行我们的程序，需要两步。`go run`这个命令就是可以把这两步合成一步的命令，节省了我们录入的时间，通过`go run`命令，我们可以直接看到输出的结果。 

### go env 

查看go环境的变量信息

### go install

它和`go build`类似，不过它可以在编译后，把生成的可执行文件或者库安装到对应的目录下，以供使用。 

```bash
go install tools
```

### go get

`go get`命令，可以从网上下载更新指定的包以及依赖的包，并对它们进行编译和安装 

```
go get github.com/spf13/cobra
```

`go get`支持大多数版本控制系统(VCS)，比如我们常用的git，通过它和包依赖管理结合，我们可以在代码中直接导入网络上的包以供我们使用 

### go fmt

这是go提供的一个格式化代码的命令了，它可以格式化我们的源代码的布局和Go源代码一样的风格，也就是统一代码风格，这样我们再也不用为大括号要不要放到行尾还是另起一行，缩进是使用空格还是tab而争论不休了，都给我们统一了。

### go vet

这个命令不会帮助开发人员写代码，但是它也很有用，因为它会帮助我们检查我们代码中常见的错误。

1. Printf这类的函数调用时，类型匹配了错误的参数。
2. 定义常用的方法时，方法签名错误。
3. 错误的结构标签。
4. 没有指定字段名的结构字面量。

 ### go test

该命令用于Go的单元测试，它也是接受一个包名作为参数，如果没有指定，使用当前目录。 `go test`运行的单元测试必须符合go的测试要求。 

1. 写有单元测试的文件名，必须以`_test.go`结尾。
2. 测试文件要包含若干个测试函数。
3. 这些测试函数要以Test为前缀，还要接收一个`*testing.T`类型的参数。