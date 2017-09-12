## Modules 模块


一个python文件就是一个模块。模块的名字就是文件的名字。模块的名字可以用全局的变量 __name__

    import lists

    lists.stacks()
    
    print(lists.__name__);//lists
    
模块的搜索

1. 当前目录的文件
2. PYTHONPATH配置的目录
3. 安装的默认的目录

编译python模块的时候 会生成一个__pycache__ 目录。

### dir 函数

查看模块有哪些定义的变量和函数。


## 包


    sound/                         顶级包目录
          __init__.py              初始化sound package
          formats/                  子包文件 
                  __init__.py
                  wavread.py
                  wavwrite.py
                  aiffread.py
                  aiffwrite.py
                  auread.py
                  auwrite.py
                  ...
          effects/                  Subpackage for sound 