Python的内建模块itertools提供了非常有用的用于操作迭代对象的函数。

今天我有一个朋友问我。有三个集合 a [1,3,4] b [2,5,6] c[6,1,3] 怎么得到他们的所有的集合。最初的时候，想到用for，但是需要三次，感觉不优雅。后来查到python
内置了itertools 可以很方便的计算排列组合。上面的需求就是笛卡尔积

```python
import itertools
list(itertools.product(a,b,c))
```
