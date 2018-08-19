## 搭建socket 5 服务器 ##

> SOCKS是什么：防火墙安全会话转换协议 （Socks: Protocol for sessions traversal across firewall securely） SOCKS 协议提供一个框架，为在 TCP 和 UDP 域中的客户机/服务器应用程序能更方便安全地使用网络防火墙所提供的服务
+ 安装socks5 依赖

         yum install pam-devel openldap-devel openssl-devel

+ 下载soks5 源码包 编译安装

> 最新版ss5-3.8.9-8 
下载地址 :[https://sourceforge.net/projects/ss5/files/](https://sourceforge.net/projects/ss5/files/)

        > tar zxvf ss5-3.8.9-8.tar.gz
        > cd ss5-3.8.9-8
        > ./configure && make && make install

+ 修改配置
> ss5的配置在 /etc/opt/ss5 下

    1. 增加用户名和密码 
        > vi ss5.passwd #每一行 一个用户名和密码 用空格分割  如 admin admin
    2. 修改配置
        > vi ss5.conf
        #auth    0.0.0.0/0               -               -
        #去掉注释，改为
        auth    0.0.0.0/0               -               u
        #permit -        0.0.0.0/0       -       0.0.0.0/0       -       -       -       -       -
        #去掉注释：
        permit -        0.0.0.0/0       -       0.0.0.0/0       -       -       -       -       -
> u：使用ss5.passwd帐号密码登录，-：默认任何人都可使用

+ 启动ss5 

      > chmod 777 /etc/rc.d/init.d/ss5
      > /etc/rc.d/init.d/ss5 start


