## OS模块


> os 模块主要就是获取系统的信息

- 引入os模块

		var os = require('os')

- 获取操作系统的位数

		require('os').arch()

- 获取cpu信息

		require('os').cpus()

- 获取磁盘剩余大小

		require('os').freemem()

- 获取主目录

		require('os').homedir()

- 获取hostname

	    require('os').hostname()
	

-  获取网络接口信息

		require('os').networkInterfaces()

- 获取操作系统的类型

		os.platform()

- 获取操作系统的缓存目录

		os.tmpdir()

- 获取操作系统的版本

		os.release()

- 获取操作系统的类型

		os.type()

- 获取操作系统用户的信息(Added in: v6.0.0)

		os.userInfo()