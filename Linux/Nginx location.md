在nginx中配置proxy_pass时，当在后面的url加上了/，相当于是绝对根路径，
则nginx不会把location中匹配的路径部分代理走;如果没有/，则会把匹配的路径部分也给代理走。 
首先是location进行的是模糊匹配
    1）没有“/”时，location /abc/def可以匹配/abc/defghi请求，也可以匹配/abc/def/ghi等
    2）而有“/”时，location /abc/def/不能匹配/abc/defghi请求，只能匹配/abc/def/anything这样的请求
下面四种情况分别用http://192.168.1.4/proxy/test.html 进行访问。

第一种：
```
location  /proxy/ {

proxy_pass http://127.0.0.1:81/;

}
```
结论：会被代理到 `http://127.0.0.1:81/test.html`这个url

 

第二种(相对于第一种，最后少一个 /)
```
location  /proxy/ {

proxy_pass http://127.0.0.1:81;

}
```
结论：会被代理到`http://127.0.0.1:81/proxy/test.html` 这个url

 

第三种：

```
location  /proxy/ {

proxy_pass http://127.0.0.1:81/ftlynx/;

}

结论：会被代理到`http://127.0.0.1:81/ftlynx/test.html` 这个url。
```
 

第四种(相对于第三种，最后少一个 / )：
```
location  /proxy/ {

proxy_pass http://127.0.0.1:81/ftlynx;

}
```

结论：会被代理到`http://127.0.0.1:81/ftlynxtest.html` 这个url


## Nginx location 配置的优先级

- 1、表达式的几种形式
~ 表示执行一个正则匹配，区分大小写

~* 表示执行一个正则匹配，不区分大小写

^~ 表示普通字符匹配。使用前缀匹配。如果匹配成功，则不再匹配其他location。

= 进行普通字符精确匹配。也就是完全匹配。

@ 它定义一个命名的 location，使用在内部定向时，例如 error_page, try_files

- 2、表达式之间的优先级
不同的表达式之间优先级不同，相同的表达式，匹配规则更长的优先级更高。

> = 的优先级最高
> ^~ 优先级次之
> ~，~* 的优先级一致，次于^~
> 普通字符串匹配优先级最低

```
location =/ {
}
location ^~/api/ {

}
location ~/api/ {

}
location ~ \.php {

}
location /api {
  
}
```


**尽管location 的优先级与配置文件的编写顺序没什么关系，但是最好还是按照优先级顺序编写配置文件，方便理解，排查问题 **
