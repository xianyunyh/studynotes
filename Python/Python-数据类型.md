## 数据类型

> python提供了数据类型有整型、浮点型、字符串、布尔、空值、字典、列表


- **整型**

> 整型就是整数，包括正整数和负整数。十六进制的整数用前面加上ox

- **浮点数**

> 浮点型也就是小数 如0.1 1.25

- **字符串**

> python 字符串以单引号或双引号括起来的字字符。如'abc' "abc"

- **布尔**

> python中的布尔类型 **True** 表示真 **False** 表示假 **首字母大写。**

- **列表list**

> list是一个有序的数据的集合，可以进行增删改查、

		list1 =['a','b']
		print(list1[1])
		list1.append('c')//追加一个元素
		list1.insert(1,'d')//添加到指定的位置
		list1.pop()//删除末尾的元素

- **元祖tuple** 

> 也是一种有序列表。一旦定义了之后就不能修改。所以没有append和insert的方法

		tup = (1,2,3)

- **字典dict**  

> 键值存储的key=>value的格式

		dict1 = ['a','b']
		dict2 = {"name":"jack","age":18}
		dist2.pop(name) //删除key为name的元素
		dist2['name']//取值
		dist2.get('name')

- **set**

> set 和dist类似。是一个key的集合。但是不存储value，key不重复、

		s = set([2,5,7])
		s.add(3)
		s.remove(2)

### list相关操作

- 切片（取出list中部分元素）

		list1 = ['1','a',3]
		list1[0] //取出第一个元素
		list1[0:2]//取出前两个元素 0索引开始到2为止
		list1[-1]//取出最后一个元素
		list1[::2]//间隔取值

