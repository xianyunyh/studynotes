## 关联远程分支

关联远程origin下的devtest 到本地的devtest

```
git branch --set-upstream-to origin/devtest devtest
```

## 发布远程分支

> git push 使用本地的对应分支来更新对应的远程分支

$ git push <远程主机名> <本地分支名>:<远程分支名>

```
git push origin dev:dev  //这样远程仓库也有一个dev分支了

git push origin :master 提交master 并删除

```

## merge 和rebase的区别

从下图可以看出来。merge是把两个分支合并再一起，但是不会影响原来的分支。

rebase 则是把feture分支加到了master之上。并且head指向最新的提交commit

![image](https://camo.githubusercontent.com/c45e2609be5941aaedac397b08770be35d490db7/68747470733a2f2f7777772e61746c61737369616e2e636f6d2f6769742f696d616765732f7475746f7269616c732f616476616e6365642f6d657267696e672d76732d7265626173696e672f30392e737667)


## 工作区、暂存区、仓库



![image](https://camo.githubusercontent.com/4a19fb7e615ece473d64bc8f9b33a40c56e85f6a/687474703a2f2f6d61726b6c6f6461746f2e6769746875622e696f2f76697375616c2d6769742d67756964652f62617369632d75736167652e737667)

工作区add 把文件添加到暂存区，然后执行commit提交到仓库中。

reset 是把仓库的数据恢复到暂存区，而checkout把暂存区中的数据恢复到工作区。


## git clone 指定分支

```
git clone -b <分支名>  <仓库地址>

```

##  pull 获取并合并其他的厂库

git pull <远程主机> <远程分支>:<本地分支>

```
    git pull origin master:my_test

```

## git checkout


> git checkout 这个命令有三个不同的作用：检出文件、检出提交和检出分支

    git checkout <分支名> 
    
    git checkout <commit_id> <file> 检出对应commit中的文件
    
    git checkout master //切换分支


```

git checkout master //切换分支

git checkout b7119f2 //切换到对应的commit

git checkout b7119f2 a.txt // 把commit中的文件检出

git checkout HEAD hello.py //检出最近的提交

```

## git reset git reverse 区别

![image](https://camo.githubusercontent.com/3d55df040cb530482894661b35212b83ff4e5e14/68747470733a2f2f7777772e61746c61737369616e2e636f6d2f6769742f696d616765732f7475746f7269616c732f616476616e6365642f726573657474696e672d636865636b696e672d6f75742d616e642d726576657274696e672f30322e737667)

reset 回退 会把把head 指向对应的commit

- --soft – 缓存区和工作目录都不会被改变
- --mixed – 默认选项。缓存区和你指定的提交同步，但工作目录不受影响
- --hard – 缓存区和工作目录都同步到你指定的提交

将当前分支的末端移到 <commit>，将缓存区和工作目录都重设到这个提交。它不仅清除了未提交的更改，同时还清除了 <commit> 之后的所有提交

```
git reset --hard

```

### rever

> Revert 撤销一个提交的同时会创建一个新的提交。这是一个安全的方法，因为它不会重写提交历史.会增加一个新的commit

![image](https://camo.githubusercontent.com/ca3c454935277b49e1c75e04644d979e796c50e8/68747470733a2f2f7777772e61746c61737369616e2e636f6d2f6769742f696d616765732f7475746f7269616c732f616476616e6365642f726573657474696e672d636865636b696e672d6f75742d616e642d726576657274696e672f30362e737667)



    命令	作用域	常用情景
    git reset	提交层面	在私有分支上舍弃一些没有提交的更改
    git reset	文件层面	将文件从缓存区中移除
    git checkout	提交层面	切换分支或查看旧版本
    git checkout	文件层面	舍弃工作目录中的更改
    git revert	提交层面	在公共分支上回滚更改
    git revert	文件层面	（然而并没有）
    
    
## checkout 


![image](https://camo.githubusercontent.com/5d7183ad484d57e357ae45ea400ae565a533fe9a/68747470733a2f2f7777772e61746c61737369616e2e636f6d2f6769742f696d616765732f7475746f7269616c732f616476616e6365642f726573657474696e672d636865636b696e672d6f75742d616e642d726576657274696e672f30342e737667)

## rebase merge 

```
git commit --amend 和 
git reset 一样，
你永远不应该 rebase 那些已经推送到公共仓库的提交

```

![image](https://camo.githubusercontent.com/97b158cd28a480213715bd4885738ad260c13930/68747470733a2f2f7777772e61746c61737369616e2e636f6d2f6769742f696d616765732f7475746f7269616c732f67657474696e672d737461727465642f726577726974696e672d686973746f72792f30322e737667)

## git commit --amend

git commit --amend 命令是修复最新提交的便捷方式。它允许你将缓存的修改和之前的提交合并到一起，而不是提交一个全新的快照。它还可以用来简单地编辑上一次提交的信息而不改变快照

![image](https://camo.githubusercontent.com/5fa51fd97e5973938a7e094177fa9249d9798a4c/68747470733a2f2f7777772e61746c61737369616e2e636f6d2f6769742f696d616765732f7475746f7269616c732f67657474696e672d737461727465642f726577726974696e672d686973746f72792f30312e737667)


## fetch pull

git fetch 命令将提交从远程仓库导入到你的本地仓库。拉取下来的提交储存为远程分支，而不是我们一直使用的普通的本地分支。但是head 还是指向原来的master。

图2 就是fetch的后的结果

pull 则是fetch 和merge的整合。
![image](https://camo.githubusercontent.com/004b889773ada4e8f982a7864c6ea697a6f57c1f/68747470733a2f2f7777772e61746c61737369616e2e636f6d2f6769742f696d616765732f7475746f7269616c732f636f6c6c61626f726174696e672f73796e63696e672f30332e737667)
