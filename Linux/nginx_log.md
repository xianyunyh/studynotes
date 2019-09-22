## nginx log配置
访问日志参数
    Nginx访问日志主要有两个参数控制

`log_format`  #用来定义记录日志的格式（可以定义多种日志格式，取不同名字即可）

`access_log`  #用来指定日至文件的路径及使用的何种日志格式记录日志
```
log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '

                     '$status $body_bytes_sent "$http_referer" '

                      '"$http_user_agent" "$http_x_forwarded_for"';
```
` 42.196.11.22 - - [22/Sep/2019:16:28:02 +0800] "GET /api HTTP/1.1" 200 229 "http://yehe.37he.cn/job/index.html" "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36"`
access_log的默认值：
```
#access_log  logs/access.log  main;
```
log_format语法格式及参数语法说明如下:
```
log_format    <NAME>    <Strin­­­g>;

    关键字         格式标签   日志格式
    关键字：其中关键字error_log不能改变
    格式标签：格式标签是给一套日志格式设置一个独特的名字

    日志格式：给日志设置格式


log_format格式变量：

    $remote_addr  #记录访问网站的客户端地址

    $remote_user  #远程客户端用户名

    $time_local  #记录访问时间与时区

    $request  #用户的http请求起始行信息

    $status  #http状态码，记录请求返回的状态码，例如：200、301、404等

    $body_bytes_sent  #服务器发送给客户端的响应body字节数

    $http_referer  #记录此次请求是从哪个连接访问过来的，可以根据该参数进行防盗链设置。

    $http_user_agent  #记录客户端访问信息，例如：浏览器、手机客户端等

    $http_x_forwarded_for  #当前端有代理服务器时，设置web节点记录客户端地址的配置，此参数生效的前提是代理服务器也要进行相关的x_forwarded_for设置
```
    
 ### nginx访问日志常见分析
 - 统计ip 访问量
 
 ```
 cat nginx.log | awk '{print $1}' |sort -n | uniq | wc -l 
 ```
 
 - 统计PV
 
 ```
 cat nginx.log | awk '{print $1}'| wc -l 
 ```
 - 查看访问最频繁的前100个IP
 
```
cat nginx.log | awk '{print $1}' |sort -n |uniq -c | sort -rn| head -n 100
```

- 查看访问最频的页面(TOP100)

```
awk '{print $7}' access.log | sort |uniq -c | sort -rn | head -n 100
```
