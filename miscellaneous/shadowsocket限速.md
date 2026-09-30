## shadowsocket 限速

由于自己的服务器开的ss账户越来越多了，导致自己使用也不方便，于是就想能不能限速下，保证自己正常使用的情况，想了下，流量是通过端口进来的，通过iptables应该可以控制，搜索了一下，找到方案

### 限制端口连接数量

- 首先输入命令service iptables stop关闭iptables
- 限制端口并发数很简单，IPTABLES就能搞定了，假设你要限制端口`8388`的IP最大连接数为5，两句话命令：

```bash
iptables -I INPUT -p tcp --dport 8388 -m connlimit --connlimit-above 5 -j DROP
iptables -I OUTPUT -p tcp --dport 8388 -m connlimit --connlimit-above 5 -j DROP
```

### 限制端口速度

```bash
iptables -A INPUT -p tcp --sport 5037 -m limit --limit 60/s -j ACCEPT
iptables -A INPUT -p tcp --sport 5037 -j DROP
```

也就是限制每秒接受60个包，一般来说每个包大小为`64—1518`字节(Byte)。 

### 限制指定ip的访问速度

原理：每秒对特定端口进行速度控制，比如每秒超过10个的数据包直接DROP，从而限制特定端口的速度 

```bash
iptables -A FORWARD -m limit -d 208.8.14.53 --limit 700/s --limit-burst 100 -j ACCEPT 
iptables -A FORWARD -d 208.8.14.53 -j DROP
```

**最后不要忘记重启防火墙 **

```bash
service iptables restart
```

如果启动失败可以尝试以下解决方法

```bash
iptables-save >/etc/sysconfig/iptables
echo 'iptables-restore /etc/sysconfig/iptables' >> /etc/rc.local
chmod +x /etc/rc.d/rc.local
```

