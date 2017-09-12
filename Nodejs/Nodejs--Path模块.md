## path模块 

> path模块提供了很多的方法 用于解析路径

- 获取路径中的文件名

	 	var path = require('path')
		path.basename('/www/index.php')//index.php
		path.basename('/www/index.php','.php')//index

- 获取路径名

	   path.dirname('/www/qq/test')// /www/qq/

- 获取文件后缀名

		path.extname('index.php') //php

- 判断是否是绝对路径

		path.isAbsolute('/www/qq/') //true

- 拼接路径

		path.join('/www','aa') // /www/aa

- 解析路径 

		path.parse('/www/aa/t.txt')
			
		// returns
		// {
		//    root : "/",
		//    dir : "/www/aa/",
		//    base : "t.txt",
		//    ext : ".txt",
		//    name : "file"
		// }