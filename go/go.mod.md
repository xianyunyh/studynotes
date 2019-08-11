## go mod

在go1.11之前我们管理go的依赖通常都是把依赖放到vendor下。因为我们无法保证我们的依赖的版本和其他的会有冲突。

在最新的go版本提出了使用 `mod` 的方式来管理依赖



### 设置

go mod 的功能在go1.11之后才有，所以需要升级go版本。还需要设置一个环境变量 `GO111MODULE`

`GO111MODULE` 有三个值：`off`, `on`和`auto（默认值）`。

- `GO111MODULE=off`，go命令行将不会支持module功能，寻找依赖包的方式将会沿用旧版本那种通过vendor目录或者GOPATH模式来查找。
- `GO111MODULE=on`，go命令行会使用modules，而一点也不会去GOPATH目录下查找。
- `GO111MODULE=auto`，默认值，go命令行将会根据当前目录来决定是否启用module功能。这种情况下可以分为两种情形：
  - 当前目录在GOPATH/src之外且该目录包含go.mod文件
  - 当前文件在包含go.mod文件的目录下面。

> 当modules 功能启用时，依赖包的存放位置变更为`$GOPATH/pkg`，允许同一个package多个版本并存，且多个项目可以共享缓存的 module。

GOPROXY能够在一定程度上解决在拉取诸如 golang.org/x 包的时候产生的超时问题，也可以在一定程度上解决由于项目改名、迁移、删除等原因导致的404问题

```bash
export GO111MODULE=on
export OPROXY=https://goproxy.io #设置代理
```



### go mod

golang 提供了 `go mod`命令来管理包。

go mod 有以下命令：

| 命令     | 说明                                                         |
| :------- | :----------------------------------------------------------- |
| download | download modules to local cache(下载依赖包)                  |
| edit     | edit go.mod from tools or scripts（编辑go.mod                |
| graph    | print module requirement graph (打印模块依赖图)              |
| init     | initialize new module in current directory（在当前目录初始化mod） |
| tidy     | add missing and remove unused modules(拉取缺少的模块，移除不用的模块) |
| vendor   | make vendored copy of dependencies(将依赖复制到vendor下)     |
| verify   | verify dependencies have expected content (验证依赖是否正确） |
| why      | explain why packages or modules are needed(解释为什么需要依赖) |

go.mod 提供了`module`, `require`、`replace`和`exclude` 四个命令

- `module` 语句指定包的名字（路径）
- `require` 语句指定的依赖项模块
- `replace` 语句可以替换依赖项模块
- `exclude` 语句可以忽略依赖项模块

### 使用

```bash
mkdir demo && cd demo
go mod init github.com/xianyunyh/demo #初始化一个模块 github.com/xianyunyh/demo
```

```go
import (
    "github.com/xianyunyh/demo/test"
    "github.com/labstack/echo"
     )
```

当执行go build的时候，就会自动下载依赖

## 使用replace替换无法直接获取的package

由于某些已知的原因，并不是所有的package都能成功下载，比如：`golang.org`下的包。

modules 可以通过在 go.mod 文件中使用 replace 指令替换成github上对应的库，比如：

```
replace (
    golang.org/x/crypto v0.0.0-20190313024323-a1f597ede03a => github.com/golang/crypto v0.0.0-20190313024323-a1f597ede03a
)
```

或者



```
replace golang.org/x/crypto v0.0.0-20190313024323-a1f597ede03a => github.com/golang/crypto v0.0.0-20190313024323-a1f597ede03a
```
