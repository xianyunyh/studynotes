50x 错误

### 1. 500 服务器内部错误

服务器500错误是服务器的内部错误.
可能原因
1. 程序语言错误，例如：PHP语法错误；
2. 高并发导致，系统资源限制不能打开过多的文件所致；


### 2. 502 Bad Gateway

502错误是WEB服务器故障，可能是由于程序进程不够，请求的php-fpm已经执行，但是由于某种原因而没有执行完毕，最终导致php-fpm进程终止。

可能原因：
1. php-cgi进程数不够用；
2. PHP执行时间过长；
3. php-cgi进程死掉；

### 3. 504 Gateway timeout

服务器504错误表示超时，是指客户端所发出的请求没有到达网关，例如请求没有到可以执行的php-fpm。一般是Nginx配置问题

### 4. 499 Client Closed Request

```
ngx_string(ngx_http_error_495_page), /* 495, https certificate error */
ngx_string(ngx_http_error_496_page), /* 496, https no certificate */
ngx_string(ngx_http_error_497_page), /* 497, http to https */
ngx_string(ngx_http_error_404_page), /* 498, canceled */
ngx_null_string,                     /* 499, client has closed connection */
```

Nginx定义的一个状态码，用于表示这样的错误：服务器返回http头之前，客户端就提前关闭了http连接

可能问题：

1. 后台PHP程序处理请求时间过长
2. mysql慢查询


