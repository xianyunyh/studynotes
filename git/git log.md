## git log

查看git log 能帮助我们很清晰的了解过去的改动，帮助我们回滚代码

```bash
git log
#查看对应文件的改动
git log -p app.js
```
## git blame

场景：查看每一行代码的最后改动时间，以及提交人。例如，追溯app.js文件中某一行是被谁改坏的。
步骤：通过 `git blame` 来查询。
```
git blame app.js
```
