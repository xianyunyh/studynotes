## os模块

```
os.sep 可以取代操作系统特定的路径分隔符。windows下为 '\\'
os.name 字符串指示你正在使用的平台。比如对于Windows，它是'nt'，而对于Linux/Unix用户，它是 'posix'
os.getcwd() 函数得到当前工作目录，即当前Python脚本工作的目录路径
os.getenv() 获取一个环境变量，如果没有返回none
os.putenv(key, value) 设置一个环境变量值
os.listdir(path) 返回指定目录下的所有文件和目录名
os.remove(path) 函数用来删除一个文件
os.system(command) 函数用来运行shell命令
os.linesep 字符串给出当前平台使用的行终止符。例如，Windows使用 '\r\n'，Linux使用 '\n' 而Mac使用 '\r'
os.path.split(path)  函数返回一个路径的目录名和文件名
os.path.isfile() 和os.path.isdir()函数分别检验给出的路径是一个文件还是目录
os.path.exists() 函数用来检验给出的路径是否真地存在
os.curdir  返回当前目录 ('.')
os.mkdir(path) 创建一个目录
os.makedirs(path) 递归的创建目录
os.chdir(dirname) 改变工作目录到dirname    
os.path.getsize(name) 获得文件大小，如果name是目录返回0L
os.path.abspath(name) 获得绝对路径
os.path.normpath(path) 规范path字符串形式
os.path.splitext()  分离文件名与扩展名
os.path.join(path,name) 连接目录与文件名或目录
os.path.basename(path) 返回文件名
os.path.dirname(path) 返回文件路径
os.walk(top,topdown=True,onerror=None)  遍历迭代目录
os.rename(src, dst)  重命名file或者directory src到dst 如果dst是一个存在的directory, 将抛出OSError. 在Unix, 如果dst在存且是一个file, 如果用户有权限的话，它将被安静的替换. 操作将会失败在某些Unix 中如果src和dst在不同的文件系统中. 如果成功, 这命名操作将会是一个原子操作 (这是POSIX 需要). 在 Windows上, 如果dst已经存在, 将抛出OSError，即使它是一个文件. 在unix，Windows中有效。
os.renames(old, new) 递归重命名文件夹或者文件。像rename()os.sep 可以取代操作系统特定的路径分隔符。windows下为 '\\'
os.name 字符串指示你正在使用的平台。比如对于Windows，它是'nt'，而对于Linux/Unix用户，它是 'posix'
os.getcwd() 函数得到当前工作目录，即当前Python脚本工作的目录路径
os.getenv() 获取一个环境变量，如果没有返回none
os.putenv(key, value) 设置一个环境变量值
os.listdir(path) 返回指定目录下的所有文件和目录名
os.remove(path) 函数用来删除一个文件
os.system(command) 函数用来运行shell命令
os.linesep 字符串给出当前平台使用的行终止符。例如，Windows使用 '\r\n'，Linux使用 '\n' 而Mac使用 '\r'
os.path.split(path)  函数返回一个路径的目录名和文件名
os.path.isfile() 和os.path.isdir()函数分别检验给出的路径是一个文件还是目录
os.path.exists() 函数用来检验给出的路径是否真地存在
os.curdir  返回当前目录 ('.')
os.mkdir(path) 创建一个目录
os.makedirs(path) 递归的创建目录
os.chdir(dirname) 改变工作目录到dirname    
os.path.getsize(name) 获得文件大小，如果name是目录返回0L
os.path.abspath(name) 获得绝对路径
os.path.normpath(path) 规范path字符串形式
os.path.splitext()  分离文件名与扩展名
os.path.join(path,name) 连接目录与文件名或目录
os.path.basename(path) 返回文件名
os.path.dirname(path) 返回文件路径
os.walk(top,topdown=True,onerror=None)  遍历迭代目录
os.rename(src, dst)  重命名file或者directory src到dst 如果dst是一个存在的directory, 将抛出OSError. 在Unix, 如果dst在存且是一个file, 如果用户有权限的话，它将被安静的替换. 操作将会失败在某些Unix 中如果src和dst在不同的文件系统中. 如果成功, 这命名操作将会是一个原子操作 (这是POSIX 需要). 在 Windows上, 如果dst已经存在, 将抛出OSError，即使它是一个文件. 在unix，Windows中有效。
os.renames(old, new) 递归重命名文件夹或者文件。像rename()
```