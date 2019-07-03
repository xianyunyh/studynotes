## 站点综合

站点综合类的这些国内镜像站，基本上涵盖了市场上主流的软件的源。比如linux各大发行版本。

### 企业站

- 阿里云 https://opsx.alibaba.com/mirror 【推荐🌟🌟🌟🌟🌟】
- 网易http://mirrors.163.com/ 【推荐🌟🌟🌟🌟🌟】

### 教育网

1. **中国科技大学**：<https://mirrors.ustc.edu.cn/>（推荐🌟🌟🌟🌟🌟）
2. **清华大学**：<https://mirrors.tuna.tsinghua.edu.cn/>（（🌟🌟🌟🌟🌟）

## 操作系统类

### Centos

centos是现在主流的服务器使用版本。

#### 1. 下载地址

http://mirrors.163.com/centos/7.5.1804/isos/x86_64/

把中间的**7.5.1804** 换成对应的版本号，就可以下载到对应的iso文件。也可以进入到

http://mirrors.163.com/centos/ 选择对应的版本，然后再点击isos文件夹选择对应的文件。

#### 2. yum源

yum源可以综合类中 阿里云、中科大、网易云、清华的任意一个镜像。

具体的替换方法。可以参考官方的帮助文档。

- 163 http://mirrors.163.com/.help/centos.html

### Ubuntu

#### 1. 下载地址

- http://mirrors.ustc.edu.cn/ubuntu-releases/
- http://mirrors.163.com/ubuntu-releases/

#### 4. apt软件源 

     设置方式有图形和更改配置文件两种方式，新手推荐图形操作，以阿里云镜像为例。

- 图形界面配置

新手推荐使用图形界面配置： 系统设置 -> 软件和更新 选择下载服务器 -> "mirrors.aliyun.com"

- 手动更改

用你熟悉的编辑器打开：`/etc/apt/sources.list`

```
vim /etc/apt/sources.list
```

替换默认的**archive.ubuntu.com**为 **mirrors.aliyun.com**.最后执行更新

```bash
sudo apt update
```

## 软件类

### 服务器软件

#### 1. Apache

- https://mirrors.aliyun.com/apache/
- https://mirrors.cnnic.cn/apache/

#### 2.Nginx

nginx很小，就直接放个官方下载的地址了

windows用户请选`.zip`后缀的。linux用户选`.tar.gz`

- http://nginx.org/download/ 

#### 3. MySQL

进去后选择对应的版本。windows用户请选`.zip`后缀的 或者是`.msi`后缀的。linux用户选`.tar.gz` 的源码包。

- https://mirrors.tuna.tsinghua.edu.cn/mysql/downloads/
- http://mirrors.163.com/mysql/Downloads/

#### 4. PHP

windows版本。官方已经不提供5.4以下的下载了。但是你可以通过这个地址下载到

- https://windows.php.net/downloads/releases/archives/

linux源码包

将7.2.9替换成对应的版本就可以下载其他的版本了

- http://cn.php.net/distributions/php-7.2.9.tar.gz

#### 5.Nodejs

进入之后选择版本。如`v9.9.0` 然后进去之后，就可以选择对应的软件下载地址了

windows用户根据自己的系统（x86或x64）选择`.msi` 后缀的，或者`.zip`后缀的

linux用户请选择`.tar.gz` 或者`.tar.xz`结尾的

- https://npm.taobao.org/mirrors/node
- https://mirrors.ustc.edu.cn/node/

#### 6.Python

官方下载地址

- https://www.python.org/downloads/

### 软件依赖镜像仓库

#### 1.Composer 

- 下载地址

```bash
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
$ php composer-setup.php
$ php -r "unlink('composer-setup.php');"
```

composer是PHP程序的依赖管理工具。

- 国内镜像

  1. https://packagist.phpcomposer.com

  2. https://packagist.laravel-china.org
  
  3. https://mirrors.huaweicloud.com/repository/php/
  
  4. https://mirrors.aliyun.com/composer/

使用 Composer 镜像加速有两种选项：

- 选项一：全局配置，这样所有项目都能惠及（推荐）；
- 选项二：单独项目配置；

选项一、全局配置（推荐）

```shell
$ composer config -g repo.packagist composer https://packagist.laravel-china.org
```

选项二、单独使用

如果仅限当前工程使用镜像，去掉 -g 即可，如下：

```shell
$ composer config repo.packagist composer https://packagist.laravel-china.org
```

取消镜像

```shell
$ composer config -g --unset repos.packagist
```

#### 2. NPM

*npm* 是 JavaScript 世界的包管理工具。做前端开发的都离不开它,但是在国内我们需要设置下镜像，加速下包的下载

- https://registry.npm.taobao.org 

镜像使用方法（三种办法任意一种都能解决问题，不建议使用第2个）:

1.通过config命令 永久有效

```shell
npm config set registry https://registry.npm.taobao.org 
npm info underscore （如果上面配置正确这个命令会有字符串response）
npm config get registry # 验证镜像
```

2.命令行指定 临时使用，关闭终端会失效

```shell
npm --registry https://registry.npm.taobao.org info underscore 
```

3.编辑 `~/.npmrc` 加入下面内容

```shell
registry = https://registry.npm.taobao.org
```

#### 3. PIP

Pip 是python 的包管理器。python社区的包非常的多，比如科学计算，图形库等等。

镜像地址

- https://mirrors.aliyun.com/pypi/simple/
- https://mirrors.ustc.edu.cn/pypi/web/simple

使用方法

编辑 `pip` 配置文件，将 `index-url` 修改为 `https://mirrors.aliyun.com/pypi/simple/` 。

`pip` 的配置文件一般位于（如果没有，请直接创建）：

- *nix 环境: `$HOME/.config/pip/pip.conf`
- macOS: `$HOME/Library/Application Support/pip/pip.conf`
- Windows: `%APPDATA%\pip\pip.ini` （`%APPDATA%` 通常是 `C:\Users\YOUR_USERNAME\AppData\Roaming\`）

配置范例

```ini
[global]
index-url = https://mirrors.aliyun.com/pypi/simple/

[install]
trusted-host=mirrors.aliyun.com
```

