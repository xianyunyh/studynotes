## centos 7 安装python3

因为centos内置了python，是古老的python2.7，这个python不能删掉，也不能替换，很多东西依赖这个python。我们安装python3 只能通过别名的方式

###1. 安装依赖包  

```bash
yum -y install zlib-devel bzip2-devel openssl-devel ncurses-devel sqlite-devel readline-devel tk-devel gdbm-devel db4-devel libpcap-devel xz-devel

```



### 2.源码编译安装

```bash
wget https://www.python.org/ftp/python/3.6.2/Python-3.6.2.tar.xz
tar -xvJf  Python-3.6.2.tar.xz
cd Python-3.6.2
./configure --prefix=/usr/local/python3
make && make install

```

###3. 创建软链接

```bash
ln -s /usr/local/python3/bin/python3 /usr/bin/python3
ln -s /usr/local/python3/bin/pip3 /usr/bin/pip3
```

