## govendor

golang工程的依赖包经常使用go get命令来获取，例如：go get github.com/kardianos/govendor ，会将依赖包下载到`GOPATH`的路径下。

常用的依赖包管理工具有`godep`，`govendor`等，在Golang1.5之后，Go提供了 `GO15VENDOREXPERIMENT` 环境变量(Go 1.6版本默认开启该环境变量)，用于将go build时的应用路径搜索调整成为 `当前项目目录/vendor` 目录方式。通过这种形式，我们可以实现类似于 `godep` 方式的项目依赖管理。Go 1.6以上版本默认开启 GO15VENDOREXPERIMENT 环境变量

```
.
├── study
├── main.go
└── vendor
    ├── github.com
    │   └── go-clang
    │       └── bootstrap
    │           ├── AUTHORS
    │           ├── CONTRIBUTORS
    │           ├── LICENSE
    │           ├── Makefile
    │           └── README.md
    └── vendor.json
```



### 1. 安装

```bash
export GO15VENDOREXPERIMENT =1
go get -u -v github.com/kardianos/govendor
```

### 2. 使用

```bash
govendor init #初始化vendor目录
govendor fetch 【依赖】
```

### 3. 常用命令

常见的命令如下，格式为 `govendor COMMAND`。

| 命令           | 功能                                                         |
| -------------- | ------------------------------------------------------------ |
| `init`         | 初始化 vendor 目录                                           |
| `list`         | 列出所有的依赖包                                             |
| `add`          | 添加包到 vendor 目录，如 govendor add +external 添加所有外部包 |
| `add PKG_PATH` | 添加指定的依赖包到 vendor 目录                               |
| `update`       | 从 $GOPATH 更新依赖包到 vendor 目录                          |
| `remove`       | 从 vendor 管理中删除依赖                                     |
| `status`       | 列出所有缺失、过期和修改过的包                               |
| `fetch`        | 添加或更新包到本地 vendor 目录                               |
| `sync`         | 本地存在 vendor.json 时候拉去依赖包，匹配所记录的版本        |
| `get`          | 类似 `go get` 目录，拉取依赖包到 vendor 目录                 |
