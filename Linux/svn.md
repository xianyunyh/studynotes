## Centos 搭建svn服务器
> 环境：Centos 6.4

### 安装svn

	yum -y install subversion

### 创建版本库目录 

	mkdir -p /home/repos
	svnadmin create /home/repos/Test #创建Test 版本库

### 进入版本库 配置

	cd /home/repos/Test/conf

>**conf** 下有三个文件 passwd、authz、svnserver.conf

>authz 文件权限控制文件

>passwd 账户密码文件

>svnserve.conf 服务器配置文件

1.1 配置账户密码

	vi passwd
	
	文件内容
	[users]
	admin=admin #每行一个用户名对应密码
1.2 配置svnserve.conf文件

	vi svnserve.conf

	[general]
	anon-access = no #匿名账户不允许访问
	auth-access = write#授权用户可以写入
	password-db = passwd#密码文件指向passwd文件
	authz-db = authz#授权配置指向authz
	realm = Test#版本库为Test

1.3 配置authz文件
	
	vi authz

	[/]#版本库根目录权限
	test1 = rw #用户test1 可以读写
	* = #其他用户没有权限
	
### 启动svn

	svnserve -d -r  /home/repos/

### 修改防火墙

> svnserve 默认占用的是3690端，所有需要将3690放行

	vi /etc/sysconfig/iptables
	#加上下面的这句
	-A INPUT -m state --state NEW -m tcp -p tcp --dport 3690 -j ACCEPT
	#重启防火墙
	severice iptables restart 

	