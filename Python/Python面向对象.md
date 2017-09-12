## 面向对象

定义一个类


    class New():
    	name = 'xhang'
    	"""构造函数"""
    	def __init__(self):
    
    		pass;
    
    	def test(self):
    		print(self.name)
    
    
    n = New()
    n.test()
    
### 继承

继承的实现 定义的时候在括号中传入父类的名字

    class New1(New):
    	"""docstring for New"""
    	def __init__(self):
    		super(New, self).__init__()#继承父类的构造
    		self.test()
    		
    new1 = New1()
    
### 多继承

new3 集成了New1 Test
```
class New3(New1,Test):
    def __init__(self):
        self.test()
        self.test1()
    		
```
### 私有属性和方法

双下划线定义的属性

    __user
### 魔术方法

    __init__ : 构造函数，在生成对象时调用
    __del__ : 析构函数，释放对象时使用
    __repr__ : 打印，转换
    __setitem__ : 按照索引赋值
    __getitem__: 按照索引获取值
    __len__: 获得长度
    __cmp__: 比较运算
    __call__: 函数调用
    __add__: 加运算
    __sub__: 减运算
    __mul__: 乘运算
    __div__: 除运算
    __mod__: 求余运算
    __pow__: 称方