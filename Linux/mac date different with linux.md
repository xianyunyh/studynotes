## [2018.09.07]Mac 下的 date 和Linux的差别



### mac下

```
usage: date [-jnRu] [-d dst] [-r seconds] [-t west] [-v[+|-]val[ymwdHMS]] ...
            [-f fmt date | [[[mm]dd]HH]MM[[cc]yy][.ss]] [+format]
```

参数解析：

-j：使用-j才能使用-f

-n：默认情况下，如果定时进程正在运行，date命令会在本地组的所有机器设置时间。 -n选项可以禁止这种行为，表示只设置当前计算机。

-u：显示或设置日期为UTC时间。

-d：设置内核的时区，一般不用

-r：秒转换时间

-t：（time zone）设置一GMT为基准的时区

-v：根据参数调整时间

-f：根据格式调整时间

+：+号引导的一些格式,和正常的Linux的格式一致

```shell
date # 获取当前时间 
date -u # UTC时间
date -r 1489420972 #转换UINX TImestamp 到时间字符
date -r 1489420972 "+%Y-%m-%d %H:%M:%S" # 格式化
date "+%Y-%m-%d %H:%M:%S" #格式化时间
date -j -f %Y-%m-%d 2015-09-28 +%s # 查看特定时间到时间戳
## 加减
date -v+2m # j加两秒
date -v+2H # 加两个小时
```

### Linux下的 date

**Linux**使用**GNU**版本**date**命令。

- 设置系统时间

  ```shell
  date -s '2018-09-08 00:00:00'
  ```

- 格式化时间

  ```shell
  date +%Y-%m-%d%t%H:%M:%S%n%p 
  ```

- 加减时间

  ```shell
  date +%Y-%m-%d --date="+1 day" # 1天后
  date +%Y-%m-%d --date="1 day ago" # 1天前
  # 缩写
  date +%Y-%m-%d -d "1 day ago" # 1天前
  ```

- UTC时间

  ```shell
  date -u "+%Y-%m-%d %H:%M:%S"
  ```

- 时间戳转时间

  ```shell
  date -d "@1279592730" "+%Y-%m-%d %H:%M:%S"
  ```



### 操作系统判断

在mac下的`uname -s` 是 **Darwin** 我们可以通过这个，来判断是不是MacOS

```shell
os_name=`uname -s`
if [[ "$os_name" == "Linux" ]]; then
    today=$(date +%Y-%m-%d)
elif [[ "$os_name" == "Darwin" ]]; then
    today=$(date +%Y-%m-%d)
fi
```

