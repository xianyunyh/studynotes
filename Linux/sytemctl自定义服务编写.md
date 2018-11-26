## sytemctl 自定义服务开机启动

CentOS 7继承了RHEL 7的新的特性，例如强大的systemctl，而systemctl的使用也使得系统服务的/etc/init.d的启动脚本的方式发生重大改变，也大幅提高了系统服务的运行效率 

systemd 目标是：尽可能启动更少进程；尽可能将更多进程并行启动，systemd尽可能减少对shell脚本的依赖。

systemd单位类型

systemctl –type=单位类型，用来过滤`systemctl –type=service `

- 服务（service）：管理着后台服务；
- 挂载（mount）自动挂载（automount）：用来挂载文件系统； 
- 目票（target）：运行级别； 
- 套接字（socket）：用来创建套接字，并在访问套接字后，立即利用依赖关系间接地启动另一单位； 



### 开机服务管理

CentOS 7的服务systemctl脚本存放在：/usr/lib/systemd/，有系统（system）和用户（user）之分，

`/usr/lib/systemd/system/`
`/usr/lib/systemd/user/`

像需要开机不登陆就能运行的程序，存在系统服务，即：/usr/lib/systemd/system/ 目录下
每一个服务以.service结尾，一般会分为3部分：[Unit]、[Service]、[Install]

- [Unit] 主要是对这个服务的说明，内容包括
  - Description和After，Description用于描述服务，
  - After用于描述服务类别
- [Service] 是服务的关键，是服务的一些具体运行参数的设置，
  - Type=forking是后台运行的形式，
  - PIDFile为存放PID的文件路径，
  - ExecStart为服务的具体运行命令，
  - ExecReload为重启命令，
  - ExecStop为停止命令，
- PrivateTmp=True表示给服务分配独立的临时空间

注意：[Service]部分的启动、重启、停止命令全部要求使用绝对路径，使用相对路径则会报错！

- [Install] 是服务安装的相关设置，可设置为多用户的

  - WantedBy：何种情况下，服务被启用。

    eg：WantedBy=multi-user.target（多用户环境下启用）

  - Alias：别名 

服务脚本按照上面编写完成后，以754的权限保存在/usr/lib/systemd/system/目录下，这时就可以利用systemctl进行配置

```shell
[Unit]
Description=Redis In-Memory Data Store
After=network.target
 
[Service]
User=redis
Group=redis
Type=forking
ExecStart=/usr/bin/redis-server /etc/redis/redis.conf
ExecStop=/usr/bin/redis-cli shutdown
Restart=always
 
[Install]
WantedBy=multi-user.target
```

### systemctl 配置命令

``` bash
systemctl status redis.service            // 查看redis启动状态
systemctl start redis             // 启动redis
systemctl stop redis            // 关闭 redis
systemctl enable redis         // 开机启动 redis 服务
systemctl disable redis       // 开机关闭 redis 服务
```

### Unit xxxx.service is masked.

```
systemctl unmask nginx.service
```



- [参考链接](http://www.ruanyifeng.com/blog/2016/03/systemd-tutorial-part-two.html)

