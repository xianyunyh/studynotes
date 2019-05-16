```shell
#!/bin/bash

a=`stat -c %Y /var/tomcat/logs/catalina.out`  //获取文件的修改时间（秒为单位）

b=`date +%s`       //获取当前系统的时间 (秒为单位）

if [ $[ $b - $a ] -gt 1800 ];   //判断当前时间和文件修改时间差（30分钟）

then

 /sbin/service tomcat restart   //执行的操作：重启tomcat服务

fi
