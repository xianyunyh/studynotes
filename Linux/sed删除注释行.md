使用sed 快速删除以 `#` 的注释行
如果直接使用`sed -i /^#/d /path/to/file`
对于 空白开头 后面跟着`#`的文件并没有作用
```
#方法1
sed -e -i  '/^[ \t]*#/d'
#方法2
sed -i -c -e '/^[[:blank:]]*#/d' api.yaml
```
