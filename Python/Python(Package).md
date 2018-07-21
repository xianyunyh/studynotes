## python 包

在python种一个单独的文件成为模块，模块中可以包含多个函数、类等。多个模块组成了一个包。

可以作为模块的文件类型有**.py、.pyo、.pyc、.pyd、.so、.dll**

```
package
  |- subpackage1
      |- __init__.py
      |- a.py
  |- subpackage2
      |- __init__.py
      |- b.py
```

### 导入

```python
import subpackage1.a # 将模块subpackage.a导入全局命名空间，例如访问a中属性时用subpackage1.a.attr
from subpackage1 import a #　将模块a导入全局命名空间，例如访问a中属性时用a.attr_a
from subpackage.a import attr_a # 将模块a的属性直接导入到命名空间中，例如访问a中属性时直接用attr_a
```

### ` __init__`

`__init__.py `文件的作用是将文件夹变为一个Python模块,Python 中的每个模块的包中，都有`__init__.py` 文件。

通常`__init__.py` 文件为空，但是我们还可以为它增加其他的功能。我们在导入一个包时，实际上是导入了它的`__init__.py`文件。这样我们可以在`__init__.py`文件中批量导入我们所需要的模块，而不再需要一个一个的导入。

```python
#__init__.py
# package
import re
import urllib
import sys
import os

# a.py
import package.re
```

`__init__.py`中还有一个重要的变量，`__all_`_, 它用来将模块全部导入。 

```python
# __init__.py
__all__ = ['os', 'sys', 're', 'urllib']

# a.py
from package import *
```

这时就会把注册在`__init__.py`文件中`__all__`列表中的模块和包导入到当前文件中来。 

### import语句引用机制

可以被import语句导入的对象是以下类型：

- 模块文件（.py文件）
- C或C++扩展（已编译为共享库或DLL文件）
- 包（包含多个模块）
- 内建模块（使用C编写并已链接到Python解释器中）

导入模块的时候，解释器会按照**sys.path**列表中的目录顺序来查找导入文件 