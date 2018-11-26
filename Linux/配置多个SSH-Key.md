# 配置多个SSH-Key

### 1. 生成多个key

```shell
ssh-keygen -t rsa -C "your_mail@example.com" -f github_rsa
ssh-keygen -t rsa -C "your_mail@example.com" -f work_rsa

```

### 2. 为配置文件添加config

```ini
$ cd ~/.ssh/
$ touch config
```

在config配置多个host

```ini
#github
Host github.com
IdentityFile .ssh/github_rsa
PreferredAuthentications publickey
User root
#work
Host 188.1.1.1
IdentityFile .ssh/work_rsa
PreferredAuthentications publickey
User root
```

