> 检查远程端口是否对bash开放

	echo > /dev/tcp/8.8.8.8/53 && echo "open"

>让进程进入后台

	ctrl+z

> 让进程转入前台

	fg

> 产生随机的十六进制数，其中n是字符数

	openssl rand -hex n

> 在当前shell里执行一个文件里的命令

	source /home/user/file.name

> 截取前五个字符

	${variable:0:5}

>SSH debug 模式

	ssh -vvv user@ip

> ssh with pem key 

	ssh user@ip-add -i key.pem

> 用wget 抓取整个网站的目录、

	wget -r --no-parent --reject "index.html*" http://host -P /home/user/

> 一次创建多个目录

	mkdir -P /home/{dr1,dr2}

> 列出包括子进程的进程树

	ps axwef

>创建war文件

	jar -cvf name.war file

> 测试硬盘写入速度

	dd if=/dev/zero of=/tmp/output.img bs=8k
 count=256k; rm -rf /tmp/output.img

>测试硬盘读取速度

	hdpara -Tt /dev/sda

>获取文本的md5hash

	echo -n "test" | md5sum
> 检查xml 格式

	xmllint --noout file.xml

> 将tar.gz提取到新目录

	tar zxvf pa.tar.gz -C new_dir

> 使用curl 获取http的信息

	curl -I http://www.qq.com
>修改文件或者目录的时间戳

	touch -t timestamp file

>利用wget 进行ftp下载

	wget -m ftp://user:pass@host

>