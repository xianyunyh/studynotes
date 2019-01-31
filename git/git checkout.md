## git checkout

git checkout 的常用功能：检出分支和检出文件

- 切换分支 `git checkout -b | B pointStart`

  ```shell	
  git checkout -b dev master # 以master为基础创建并切换到一个新的分支dev
  git checkout -b dev f7742cd #以commitid为基础创建一个新的分支
  ```

- 检出文件 `git checkout --  [filename]`

  有时我们会错删了文件。这个时候，就需要使用重新检出。

  ```shell
  git checkout -- filename
  git checkout -- "*.c"
  ```

- 从别的分支检出文件 `git checkout [branch] -- [file name]`

  比如我们有两个分支A和B、A分支需要用到B的文件。这个时候，我们就可以用checkout

  比如 b分支 config.php 。我们需要把这个分支的文件加到自己的分支中。

  ```shell
  git checkout B config.php #把B分支的文件检出到当前分支
  ```

  
