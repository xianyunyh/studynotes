## 操作系统接口

- os模块封装了操作系统的常用接口

- shutil提供了文件操作的接口


    >>> import shutil
    >>> shutil.copyfile('data.db', 'archive.db')
    'archive.db'
    >>> shutil.move('/build/executables', 'installdir')
    
    
- glob 模块提供了文件搜索的函数


    print(glob.glob('*.py'))

- sys 提供命令行参数


    import sys
    print(sys.argv)
    
- re模块提供了正则表达式相关的接口


    re.findall(r'\bf[a-z]*', 'which foot or hand fell fastest')

- math 模块提供了数学相关的接口



- 网络接口 Internet Access urllib.request


- datetime 提供了时间和日期相关的接口

    print(datetime.date.today())

