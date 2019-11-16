# 通过Drone 搭建CI平台

基于 `Docker` 的 `CI/CD` 工具 `Drone` 所有编译、测试的流程都在 `Docker` 容器中进行。

开发者只需在项目中包含 `.drone.yml` 文件，将代码推送到 git 仓库，`Drone` 就能够自动化的进行编译、测试、发布

Drone 分为两部分，一部分是`server` ，另一部分是`runner` ，两者通过`RPC` 进行通讯。`runner` 负责执行执行的任务。

`runner`的种类

- Docker Runner  所有的执行过程都在容器内部
- Exec Runner 在本地宿主机内执行
- SSH Runner 通过ssh 在远程机器上执行
- K8s runner 在k8s里

## 安装

`drone` 很容易和`github`、`gitlab` 等平台进行结合。接下来我们以`gitea` 为例。其他的可以参考官网文档

下面是一个`docker-compose` 编排的服务。其中的`$` 开头的都是环境变量。可以通过`.env` 进行配置

```dockerfile
version: '3'
services:
  drone-server:
    image: drone/drone:1.6.2
    ports:
      - "8080:80"
    volumes:
      - ./drone:/var/lib/drone/
    environment:
      - DRONE_OPEN=true
      - DRONE_AGENTS_ENABLED=true
      - DRONE_SERVER=${DRONE_SERVER}
      - DRONE_SERVER_HOST=${DRONE_SERVER_HOST}
      - DRONE_GITEA_SERVER=${DRONE_GITEA_SERVER}
      - DRONE_GIT_ALWAYS_AUTH=false
      - DRONE_SERVER_PROTO=${DRONE_SERVER_PROTO}
      - DRONE_RUNNER_CAPACITY=2
      - DRONE_GITEA_CLIENT_ID=${DRONE_GITEA_CLIENT_ID}
      - DRONE_GITEA_CLIENT_SECRET=${DRONE_GITEA_CLIENT_SECRET}
      - DRONE_RPC_SECRET=${DRONE_RPC_SECRET}
  drone-runner:
    image: drone/drone-runner-docker:1
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
    depends_on:
      - drone-server
    ports:
      - "3001:3000"
    environment:
      - DRONE_RPC_PROTO=${DRONE_SERVER_PROTO}
      - DRONE_RPC_HOST=${DRONE_SERVER_HOST}
      - DRONE_RPC_SECRET=${DRONE_RPC_SECRET}
      - DRONE_RUNNER_NAME=${HOSTNAME}
```

 **env文件**

```env
DRONE_SERVER=
DRONE_SERVER_PROTO=http
DRONE_SERVER_HOST=
DRONE_RPC_SECRET=
DRONE_GITEA_CLIENT_ID=
DRONE_GITEA_CLIENT_SECRET=
DRONE_GITEA_SERVER=
```

获取`gitea`的client_id 可以参考[https://docs.drone.io/installation/providers/gitea/](https://docs.drone.io/installation/providers/gitea/)

一些参数的介绍

- `DRONE_SERVER` 这是服务的server地址，线上就写绑定域名或者ip即可。如果默认不是`80` 需要加上端口号 比如 `http://drone.exaple.com:8080/`  本文中，就是暴露的**8080**端口执行容器内 `80`
- `DRONE_SERVER_HOST` 主机地址  域名或ip加端口 `drone.example.com:8080`
- `DRONE_GITEA_SERVER` gitea的服务地址 比如 `http://gitea.com/`
- `DRONE_SERVER_PROTO` server的协议 可选`http` 或 `https` 如果是`https` 需要配置证书
- `DRONE_GITEA_CLIENT_ID` `gitea` 的 `oauth2` 的授权的client_id
- `DRONE_GITEA_CLIENT_SECRET`gitea 认证的秘钥
- `DRONE_RPC_SECRET` `RPC`通信的秘钥

## 编写pipeline

pipline 就是流水线工程，一些工作会按照一定的顺序执行。需要在版本库中加入`.drone.yml` 然后runner 拉取代码的时候，就会解析这个文件，这个文件会定义一些任务。

```yaml
kind: pipeline
type: docker
name: default

steps:
- name: test
  image: golang:1.12
  environment:
    GOOS: linux
    GOARCH: amd64
  commands:
  - go build
  - go test
  trigger:
    branch:
    - master
    event:
    - push
    status:
    - success
    - failure
```

比如上面就是 一个简单的任务

- kind 的值是固定的 pipline
- type 值 就是上面所说的runner的类型，有`ssh` 、 `exec` 等。上面我们的`docker-compose.yml` 用的`docker-runner` 所以这个类型写`docker` 。如果需要在宿主机内执行，需要安装 [exec-runner](https://exec-runner.docs.drone.io/installation/)
- steps 就是定义一些步骤。
  - name 就是每一步的名字
  - image 就是docker 用到的镜像 比如我们需要编译项目的go 所以需要go的镜像
  - commands 就是执行的命令
  - environment 传递环境变量
- trigger 触发器
  - branch 在master分支上有变动就行触发任务
  - event 事件 当push事件发生，触发
  - status 任务状态变化触发 常用于消息通知，放任务构建完 发个通知

 一个`PHP`的简单的`pipline` 

```yaml
kind: pipeline
name: default
type: docker

steps:
- name: install
  image: composer
  commands:
  - composer install

- name: test
  image: php:7
  commands:
  - vendor/bin/phpunit --configuration config.xml
```

把改动的文件提交到代码库，push到远程之后，然后就打开你的server的地址，比如`http://drone.exaple.com:8080` 然后关联下仓库 就能看到构建的进度了。

## Exec-runner

`exec-runner` 不是必须的。除非你需要在你的宿主机内执行那些task，才能用到这个。

### 1. 安装

```shell
$ curl -L https://github.com/drone-runners/drone-runner-exec/releases/latest/download/drone_runner_exec_linux_amd64.tar.gz | tar zx
$ sudo install -t /usr/local/bin drone-runner-exec
```

### 2. 配置

如果是root 用户，配置文件在`/etc/drone-runner-exec/config` 

非root用户 配置文件存在`~/.drone-runner-exec/config`

```conf
DRONE_RPC_PROTO=http
DRONE_RPC_HOST=drone.example.com
DRONE_RPC_SECRET=super-duper-secret
DRONE_LOG_FILE=/var/log/drone-runner-exec/log.txt
```

上面的三个参数，分别就是RPC 通信的协议和地址以及秘钥。

### 3. 安装启动

```shell
$ drone-runner-exec service install
$ drone-runner-exec service start
```

### 4. 定义pipline

在`.drone.yaml` 中定义 `type` 为`exec` 即可。

```yaml
kind: pipeline
name: default
type: exec

steps:
- name: install
  commands:
  - composer install
```

