## 用polipo将shadowsocks转换为http代理

最近一直使用python爬取数据，但是有时总是被封ip，就想到了用代理ip的方法。但是网上的代理，都不怎么好用，经常失效，于是 就想自己搭建一个，在搜索的过程中，了解到了pilipo可以将socket转成http代理。之前自己搭建过一个sockets5作为fq用，于是就用到了这个polipo将请求转化即可。

- shadowsockets 大家都知道。假设本地客户端默认是1080端口

### 安装polipo

windows下面下载地址:[https://www.irif.fr/~jch/software/files/polipo/polipo-1.0.4-win32.zip](https://www.irif.fr/~jch/software/files/polipo/polipo-1.0.4-win32.zip)

下载完，解压即可。需要修改几个参数

默认配置文件`config.sample` 加入或修改以下配置

```ini
socksParentProxy = "127.0.0.1:1080"

socksProxyType = socks5
```

### 运行

```
polipo.exe -c config.sample
```



然后配置自己的系统代理，就可以使用HTTP代理了