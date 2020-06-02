## To Many Open files

今天查看服务日志的时候，突然发现服务器上出现了大量的错误日志`socket: too many open files` ,

> too many open files(打开的文件过多)是Linux系统中常见的错误，从字面意思上看就是说程序打开的文件数过多，不过这里的files不单是文件的意思，也包括打开的通讯链接(比如socket)，正在监听的端口等等，所以有时候也可以叫做句柄(handle)，这个错误通常也可以叫做句柄数超出系统限制。 引起的原因就是进程在某个时刻打开了超过系统限制的文件数量以及通讯链接数

用以往的经验分析，肯定是文件`fd`过少，到服务器通过`ulimit -n` 查到了`65535`， 理论上找个值已经够大了。排除系统的`fd`过少问题。

百度一圈基本上都是让改`ulimit `的参数，或者改内核的参数。查找问题的原因，要先从自身查起，又重新阅读了几遍相关代码，发现无明显的问题。于是可以排除掉代码的问题，问题基本上确定服务器上。

**查看TCP链接**

```shell
 netstat -n | awk '/^tcp/ {++S[$NF]} END {for(a in S) print a, S[a]}'
```

大量的`CLOSE_WAIT`,

<img src="https://image.fishedee.com/b833483e2dd182f52c37b413d4a0f6d9dfe00aa1" alt="img" style="zoom:90%;" />

**查看进程的最大fd**

```shell
lsof -p pid | wc -l
cat /proc/[pid]/limits
1024
```

查看进程的最大`fd` 发现居然是1024，而不是设置的`65535`,那么由此可知应该是某些地方设置了这个值，通过询问运维，知道他使用`supervisor` 去守护进程。然后就知道了`supervisor` 管理子进程，子进程继承父进程的`fd`. 肯定是`supervisor` 某些地方的设置过低，查阅supervisor文档，`[supervisord]` 段中配置 `minfds` 参数默认为1024，将`1024`改为65535，然后重启服务，问题解决。

## 备忘

| 可以导致的原因         | 处理方法                       | 补充说明                            |
| :--------------------- | :----------------------------- | :---------------------------------- |
| 单个进程打开 fb 过多   | `/etc/security/limits.conf`    | 修改文件或使用`prlimit`命令         |
| 操作系统打开的 fb 过多 | `/proc/sys/fs/file-max`        | 直接`echo`写入即可                  |
| Systemd 对进程限制     | `LimitNOFILE=20480000`         | 通常在/etc/systemd/system/目录下    |
| Supervisor 对进程限制  | `minfds`                       | 通常在/etc/supervisor/conf.d/目录下 |
| Inotify 达到上限       | `sysctl -p`/`/etc/sysctl.conf` | 该机制受到`2`个内核参数的影响       |

### 1. shell级别限制

```shell

# 当前shell的当前用户所有进程能打开的最大文件数量
# 这就意味着root用户和escape用户能够打开的最大文件数量有可能不同
# 非root用户只能越设置越小，而root用户不受限制
# 在ulimit命令里的最大文件打开数量的默认值是1024个
# 如果limits.con有设置，则默认值以limits.conf为准
# 修改后立即生效，重新登录进来后失效，因为被重置为limits.conf里的设定值
ulimit -n #查看允许打开的最大fd
#临时设置
ulimit -n 10240
#永久生效
vim /etc/security/limits.conf
```

### 2. 用户级限制

```bash
# 2.用户级限制
###############

# 一个用户可能同时连接多个shell到系统，所以还有针对用户的限制
# 这里是通过修改/etc/security/limits.conf文件实现限制控制的
# 表示escape用户不管开启多少个shell终端所能打开的最大文件数量为65535个
escape  soft  nofile  65535  # 软限制
escape  hard  nofile  10240  # 硬限制
```

### 3. 系统级限制

```bash
# 当前内核可以打开的最大的文件句柄数
# 系统会计算内存资源给出的建议值，一般为内存大小(KB)的10%来计算
$ cat /proc/sys/fs/file-max
3283446
$ grep -r MemTotal /proc/meminfo | awk '{printf("%d",$2/10)}'
3294685

# 单个进程可分配的最大文件数
$ cat /proc/sys/fs/nr_open
1048576

# 查看整个系统目前使用的文件句柄数
# 已分配文件句柄的数目  已使用文件句柄的数目  文件句柄的最大数目
$ cat /proc/sys/fs/file-nr
8056    0    3283446
```



## 参考文章

- [golang 进程出现too many open files的排查过程](https://studygolang.com/articles/8671)
- [golang 踩坑之 - 服务的文件句柄超出系统限制(too many open files)](https://kebingzao.com/2018/06/26/golang-too-many-file/)
- [解决Supervisor默认并发限制](https://www.escapelife.site/posts/5457f758.html)


