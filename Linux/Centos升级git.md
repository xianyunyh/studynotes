## centos升级git

centos 默认是很老的1.7.需要更换成最新的git版本

### 1. 安装依赖

```bash
# yum install curl-devel expat-devel gettext-devel openssl-devel zlib-devel
# yum install  gcc perl-ExtUtils-MakeMaker
```

### 2. 卸载git

```bash
yum remove git
```

### 3.下载最新的git

```bash
# cd /usr/src
# wget https://github.com/git/git/archive/v2.17.1.tar.gz
# tar xzf v2.17.1.tar.gz
```

### 4. 编译安装

```bash
# cd v2.17.1
# make prefix=/usr/local/git all
# make prefix=/usr/local/git install
# echo "export PATH=$PATH:/usr/local/git/bin" >> /etc/bashrc
# source /etc/bashrc
```

