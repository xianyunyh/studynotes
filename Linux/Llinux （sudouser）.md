破解Ubuntu root密码


1. 重启系统
2. 启动时按shift,选择recovery mode,此时会有一个选项：Advanced Options for Ubuntu, 选中直接回车

3. 删除recovery \nomodeset

4. 在这行的最后添加 quiet splash rw init=/bin/bash

5. 按F10, 启动。
6. /etc/sudoers默认是只读文件，所以先改变他的属性，输入chmod 440 /etc/sudoers
4，如果提示没有权限，或者不允许修改，就先输入 
mount -o remount rw /
然后更改权限即可。
如果内容有错误，可以vi /etc/sudoers 进入修改。或者将以前添加的错误部分删除再保存


## 让用户sudo的时候不加密码
3.编辑sudoers文件
vi /etc/sudoers
找到这行 root ALL=(ALL) ALL,在他下面添加xxx ALL=(ALL) ALL (这里的xxx是你的用户名)

ps:这里说下你可以sudoers添加下面四行中任意一条
youuser            ALL=(ALL)                ALL
%youuser           ALL=(ALL)                ALL
youuser            ALL=(ALL)                NOPASSWD: ALL
%youuser           ALL=(ALL)                NOPASSWD: ALL

第一行:允许用户youuser执行sudo命令(需要输入密码).
第二行:允许用户组youuser里面的用户执行sudo命令(需要输入密码).
第三行:允许用户youuser执行sudo命令,并且在执行的时候不输入密码.
第四行:允许用户组youuser里面的用户执行sudo命令,并且在执行的时候不输入密码.