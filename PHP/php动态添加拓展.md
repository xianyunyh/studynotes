## Linux PHP 动态添加拓展

> 使用php的常见问题是编译php时忘记添加某扩展，后来想添加扩展，但是因为安装php后又装了一些东西如PEAR等，不想删除目录重装，这里就需要用到phpize了。

> php 安装在/usr/local/php 目录下

以php7的源码包为例 php的源码目录里有一个**ext** 目录 就是拓展的目录

	cd ext #切换到ext目录

ext目录里面有很多的拓展，比如curl openssl opcache 等。下面以opcache为例。

	cd opcache #进入到opcache目录

一般的拓展的目录里面都会有一个config.m4的文件  有些时候这个文件是config0.m4  你需要改成config.m4

	
### 编译opcache 拓展 使用phpize

	/usr/local/php/bin/phpize 

	./configure --with-php-config=/usr/local/php/bin/php-config
	
	make && make install 

 安装完毕之后会看到 Installing shared extensions:     /usr/local/php/lib/php/extensions/no-debug-non-zts-20151012/

 /usr/local/php/lib/php/extensions/no-debug-non-zts-20151012/就是编译好的拓展库的目录 会存在opcache.so 将该拓展加到php.ini即可

	vim php.ini

把 extension_dir 前面的;去掉 然后把=后面的值改成 **/usr/local/php/lib/php/extensions/no-debug-non-zts-20151012/**

在下一行中加入 **extension = opcache.so**  重启php 就能看到opcache拓展了


php 有些拓展没有在源码包里 如memcache redis 等 可以去[http://pecl.php.net/](http://pecl.php.net/ "http://pecl.php.net/")下载 安装方法一样。