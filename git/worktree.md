## git worktree

今天用学会了一个很有用的命令。`git worktree` 

git worktree 从一个仓库中可以创建多个工作目录，方便多开编辑器并行开发。 

场景介绍：

你正在feature分支上，进行开发工作，但是突然线上有个bug，需要你立即修复下，但是你的feature工作还没有完成，一般我们的正常的做法，有两种

- `git stash` 保存暂存区

  ```bash
  git stash 
  
  git co master && git pull --rebase && git checkout -b hotfix
  ....
  
  git checkout feature
  git stash pop
  ```

- `git reset` 先保存 后恢复

  ```bash
  git add . && git commit -m 'test' 
  git co master && git pull --rebase && git checkout -b hotfix
  ....修复bug
  git checkout feature
  git reset
  ```

但是这个时候，会有一个问题。就是如果线上的代码依赖，如果和你的feature不一致，你需要更新的你的依赖，同时又会导致你的feature的依赖出问题。举个例子

比如你的线上的依赖redis:1.4版本。但是你的feature版本是在1.5版本的。这个时候你需要把你的版本来回的变动。

第二种情况。如果你的feature分支，正在进行的是编译或者其他的跑测试的功能，这个时候，你不能切换分支，一旦你切换了工作目录。就会导致脚本停止了。为了解决上面的两个问题。`git worktree` 就有用了

**`git worktree add -b <新分支名> <新路径> <从此分支创建> `**

```bash
git worktree add -b hotfix ../hotfix master
```

这个时候 当前工作目录上级就会出现一个hotfix的目录。你进到该目录。就是一个新的分支。这个工作 目录你的feature 都是一个独立的分支。你可以在该目录下继续干活。又不会影响你的feature的分支。然后干完活之后，就可以把这个记录给干掉了。

如果要删除其中一个工作目录，直接删除文件夹即可。随后使用命令清除多余的已经被删的工作目录：

```bash
git worktree prune
```

相比于克隆多个仓库，使用这种方法创建的多个目录，有诸多好处：

- 只有一个仓库会占用版本库的空间，其它只占用工作目录的空间，对大型项目而言非常节省空间。
- 因为所有工作目录共享一个仓库，所以一个更新意味着整个更新（A 目录里对分支做的改动，B 目录里切到此分支也是改动后的；避免到时候找不到某个未推送的改动改到了哪个仓库）
