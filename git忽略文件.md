## git rm与git rm --cached

有些时候，我们在开发过程中。不需要加到代码库中。比如写了一些test等等。但是又不是gitignore的内容。我们需要使用git rm --cached git会自动把该文件加到`.gitignore`中 如果想恢复,需要把`.gitignore`中的该文件去掉即可


当我们需要删除暂存区或分支上的文件, 同时工作区也不需要这个文件了, 可以使用
```bash
git rm filename
```
当我们需要删除暂存区或分支上的文件, 但本地又需要使用, 只是不希望这个文件被版本控制, 可以使用


```bash
git rm --cached filename
```
## 全局ingore
有些时候，我们需要全局设置，不是需要对每个项目进行单独的设置，可以通过以下步骤

```bash
cd ~
touch .gitignore_global
git config --global core.excludesfile ~/.gitignore_global
```
然后在`.gitignore_global` 中 加入自己想忽略的文件即可。如

```
node_modules/
config.js
config.php
vendor/
```
