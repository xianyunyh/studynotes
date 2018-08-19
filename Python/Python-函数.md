## 函数

> python 的函数的定义实用df定义

    	df fn():
		   print('11')
	
### 函数的参数

- 位置参数

    	def fn(a):
			print(a)
		fn(1)


- 默认参数

> 当参数不传递的时候，使用默认值.必选参数要放到前面。

	def fn(a=1):
		print(a)
	fn()

- 可变参数


> 函数的参数的是变化的。不固定 接收到的是一个tuple

		def fn(*num):
			for i in num:
				print(i)

		fn(1,2,3,5)


- 命名关键字参数

		def fn(name='',age='',addree=''):	
		fn(age=15)