## locate

locate命令其实是`find -name`的另一种写法，但是要比后者快得多，原因在于它不搜索具体目录，而是搜索一个数据库`/var/lib/locatedb`，这个数据库中含有本地所有文件信息。Linux系统自动创建这个数据库，并且每天自动更新一次，所以使用locate命令查不到最新变动过的文件。为了避免这种情况，可以在使用locate之前，先使用updatedb命令，手动更新数据库

使用方法

```

locate  [options] 参数 

locate -d /usr/local/db "hello.c" #指定db的目录 查找hello.c

```

options

- -d<目录>或--database=<目录>：指定数据库所在的目录； 
- -u：更新slocate数据库；
- --help：显示帮助；
- --version：显示版本信息。
- -i 不区分大小写


```
#查询nginx开头的文件。 \是一个全局的字符

locate -i -d /var/lib/locatedb "\nginx"
```


## updatedb

updatedb 就是更新locatedb的数据库文件。

默认的数据库文件 存在/var/lib/locatedb

```

updatedb -U /usr/lcoal/db #指定对应的目录

```

