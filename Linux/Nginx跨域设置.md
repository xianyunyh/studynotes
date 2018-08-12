## Nginx 跨域设置

在我们的开发中，经常遇到跨域，这个时候，可以通过cors来解决。

解决的方法可以在服务端的代码层或者在web服务器进行设置

### 1. 代码层

在代码的层次上，我们加入

```php
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Expose-Headers:*')
```

上面的头信息之中，有三个与CORS请求相关的字段，都以`Access-Control-`开头。

**（1）Access-Control-Allow-Origin**

该字段是必须的。它的值要么是请求时`Origin`字段的值，要么是一个`*`，表示接受任意域名的请求。

**（2）Access-Control-Allow-Credentials**

该字段可选。它的值是一个布尔值，表示是否允许发送Cookie。默认情况下，Cookie不包括在CORS请求之中。设为`true`，即表示服务器明确许可，Cookie可以包含在请求中，一起发给服务器。这个值也只能设为`true`，如果服务器不要浏览器发送Cookie，删除该字段即可。

**（3）Access-Control-Expose-Headers**

该字段可选。CORS请求时，`XMLHttpRequest`对象的`getResponseHeader()`方法只能拿到6个基本字段：`Cache-Control`、`Content-Language`、`Content-Type`、`Expires`、`Last-Modified`、`Pragma`。如果想拿到其他字段，就必须在`Access-Control-Expose-Headers`里面指定。比如token等，就需要设置额外的header字段

### 2. 在web服务器

我们可以在web服务器上进行设置cors 跨域，这样就不必改动代码。以nginx为例子

提示：有时候我们的后端是PHP文件，则需要把跨域的代码加 `location ~ \.php(.*)$` 中。

```conf
location / {
     if ($request_method = 'OPTIONS') {
        add_header 'Access-Control-Allow-Origin' '*';
        add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
        #
        # Custom headers and headers various browsers *should* be OK with but aren't
        #
        add_header 'Access-Control-Allow-Headers' 'DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range';
        #
        # Tell client that this pre-flight info is valid for 20 days
        #
        add_header 'Access-Control-Max-Age' 1728000;
        add_header 'Content-Type' 'text/plain; charset=utf-8';
        add_header 'Content-Length' 0;
        return 204;
     }
     if ($request_method = 'POST') {
        add_header 'Access-Control-Allow-Origin' '*';
        add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
        add_header 'Access-Control-Allow-Headers' 'DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range';
        add_header 'Access-Control-Expose-Headers' 'Content-Length,Content-Range';
     }
     if ($request_method = 'GET') {
        add_header 'Access-Control-Allow-Origin' '*';
        add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
        add_header 'Access-Control-Allow-Headers' 'DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range';
        add_header 'Access-Control-Expose-Headers' 'Content-Length,Content-Range';
     }
}
```

 还有另外的一种配置，就是作反向代理

```conf
location ^~ /api/v1 {
	add_header 'Access-Control-Allow-Origin' "$http_origin"; 
	add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, DELETE, OPTIONS'; 
	add_header 'Access-Control-Allow-Headers' 'DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type    '; 
	add_header 'Access-Control-Allow-Credentials' 'true'; 
	if ($request_method = 'OPTIONS') { 
		add_header 'Access-Control-Allow-Origin' "$http_origin"; 
		add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, DELETE, OPTIONS'; 
		add_header 'Access-Control-Allow-Headers' 'DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type    '; 
		add_header 'Access-Control-Allow-Credentials' 'true'; 
		add_header 'Access-Control-Max-Age' 1728000; # 20 天 
		add_header 'Content-Type' 'text/html charset=UTF-8'; 
		add_header 'Content-Length' 0; 
		return 200; 
	} 
    # 这下面是要被代理的后端服务器，它们就不需要修改代码来支持跨域了
	proxy_pass http://127.0.0.1:8085; 
	proxy_set_header Host $host; 
	proxy_redirect off; 
	proxy_set_header X-Real-IP $remote_addr; 
	proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for; 
	proxy_connect_timeout 60; 
	proxy_read_timeout 60; 
	proxy_send_timeout 60; 

}
```

