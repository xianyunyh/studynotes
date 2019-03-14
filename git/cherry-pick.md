## Git cherry-pick

**git cherry-pick**可以理解为”挑拣”提交，它会获取某一个分支的单笔提交，并作为一个新的提交引入到你当前分支上。 当我们需要在本地合入其他分支的提交时，如果我们不想对整个分支进行合并，而是只想将某一次提交合入到本地当前分支上，那么就要使用git cherry-pick了。

常见用法

### 1. git cherry-pick commit-id

```bash
 切换到branch2分支
$ git checkout branch2
Switched to branch 'branch2'
$ 
# 查看最近三次提交
$ git log --oneline -3
23d9422 [Description]:branch2 commit 3
2555c6e [Description]:branch2 commit 2
b82ba0f [Description]:branch2 commit 1
# 切换到branch1分支
$ git checkout branch1
Switched to branch 'branch1'
# 查看最近三次提交
$ git log --oneline -3
20fe2f9 commit second
c51adbe commit first
ae2bd14 commit 3th
--------------------- 
```

我们需要将 **branch2** 的分支记录 commit 1 挑出来，然后合并到 **branch1** 上

```bash
git co branch2
git cherry-pick b82ba0f
```

如果没遇到冲突，就会自动提交。解决冲突后 `git add .` 然后执行 `git cherry-pick --continue`

### 2. git cherry-pick -n commit-id

加上 **-n** 参数后，使检过来的提交不自动提交。

### 3. git cherry-pick -e

重新编辑提交信息

### 4. *git cherry-pick* --continue -、git cherry-pick --abort 、git cherry-pick --quit 

当冲突出现出现的时候的操作

### 5. git cherry-pick start-commit-id..end-commit-id 

- git cherry-pick` <commit id>`:单独合并一个提交
- git cherry-pick -x `<commit id>`：同上，不同点：保留原提交者信息。
- git cherry-pick `<start-commit-id>..<end-commit-id>`
- git cherry-pick` <start-commit-id>^..<end-commit-id>`

前者表示把`<start-commit-id>`到`<end-commit-id>`之间(左开右闭，不包含start-commit-id)的提交cherry-pick到当前分支；
后者有"^"标志的表示把`<start-commit-id>`到`<end-commit-id>`之间(闭区间，包含start-commit-id)的提交cherry-pick到当前分支。
其中，`<start-commit-id>`到`<end-commit-id>`只需要commit-id的前6位即可，并且`<start-commit-id>`在时间上必须早于`<end-commit-id>`
