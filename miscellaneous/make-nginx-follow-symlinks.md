## Nginx 支持LInux 的链接目录

今天在给网站nginx 增加一个vhost的时候，将`root` 指向了一个 目录的软链接。结果发现nginx 不支持。查阅文档，发现可以通过通配置打开. 

```ini
http {
    disable_symlinks off;
}
```



如果配置了php的话。需要在fastcig_params把`document_root` 改成` realpath_root`

```ini
fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
fastcgi_param DOCUMENT_ROOT $realpath_root;
```

更改完，然后重启nginx 就ok 了，