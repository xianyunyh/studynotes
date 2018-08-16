## git rm与git rm --cached

有些时候，我们在开发过程中。不需要加到代码库中。比如写了一些test等等。但是又不是gitignore的内容。我们需要使用git rm --cached

当我们需要删除暂存区或分支上的文件, 同时工作区也不需要这个文件了, 可以使用
```bash
git rm filename
```
当我们需要删除暂存区或分支上的文件, 但本地又需要使用, 只是不希望这个文件被版本控制, 可以使用

```bash
git rm --cached filename
```
