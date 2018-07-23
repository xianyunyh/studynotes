## git删除提交历史

在我们开发的过程中，有时候偶尔不小心把敏感信息也提交到远程仓库了，这个时候如果再修改，再提交敏感信息还是存在历史记录中。我们可以通过回退和强制刷新远程版本库来解决

```bash
git log #查看记录
git reset --hard HEAD
git add . 
git commit -m '注释'
git push origin --force --all# 强制刷新远程库
git push origin  --force --tags
```

