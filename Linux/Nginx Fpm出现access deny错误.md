NGINX Fpm出现access deny错误

在stackoverflow.com找到的答案


1. In your php-fpm www.conf set security.limit_extensions to .php or .php5 or whatever suits your environment. For some users, completely removing all values or setting it to FALSE was the only way to get it working.
In your nginx config file set fastcgi_pass to your socket address (e.g. unix:/var/run/php-fpm/php-fpm.sock;) instead of your server address and port.
Check your SCRIPT_FILENAME fastcgi param and set it according to the location of your files.
In your nginx config file include fastcgi_split_path_info ^(.+\.php)(/.+)$; in the location block where all the other fastcgi params are defined.
In your php.ini set cgi.fix_pathinfo to 1

大概的检查步骤

1. 检查phpfpm的配置，security.limit_extensions是否允许php文件、
2. 配置nginx 的fastcgi_pass 为unix:/xxx/xxx/php.socket
3. 如果配置中打开了fastcgi_split_path_info ^(.+\.php)(/.+)$; 那么 需要再php.ini中设置一下==cgi.fix_pathinfo=1==