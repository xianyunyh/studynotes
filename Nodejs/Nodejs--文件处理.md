## 文件处理操作

> nodejs 文件相关处理的操作 fs模块


- **读取文件目录 	readdir readdirSync(同步)**

	fs.readdir('./public',function (err,files) {
        if(err) return false
        console.log(files)
	})

- **读取文件 readFile readFileSync**

		fs.readFile('/etc/passwd', (err, data) => {
		  if (err) throw err;
		  console.log(data);
		});

- **读取文件目录readdir readdirSync**

		fs.readdir('./public',function (err,files) {
	        if(err) return false
	        console.log(files)
		})
- **重命名 rename renameSync**

		fs.rename('app.js','app.js.bak',function(err){
	        console.log(err)
		})

- **删除目录 rmdir rmdirSync**

		fs.rmdir('./test',function (err) {
        	console.log(err)
		})

- **获取文件的信息 stat statSync**

		fs.stat('./file.js',function(err,stats){
        	console.log(stats)
		})
- **创建符号链接  symlink symlinkSync**

		fs.symlink('./foo', './new-port');

- **删除文件 unlink unlinkSync**
	
		fs.unlink('a',function (err) {
	   	 console.log(err)
		})
- **删除目录rmdir rmdirSync**

		fs.rmdir('d:/www',function(err){})

- **监听文件的改变 watchFile watch**

		fs.watchFile('message.text', (curr, prev) => {
		  console.log(`the current mtime is: ${curr.mtime}`);
		  console.log(`the previous mtime was: ${prev.mtime}`);
		});

- **写入文件 writeFile writeFileSync writeSync  write appendFile appendFileSync**
		
		fs.writeFile('a.txt','hello world',{'flag':'w+'},function(err){
			console.log(err)
		})

- **文件权限操作 chmod chmodSync chown chownSync**

	 	fs.chmod('a.txt','777',function(err){})

- **检测文件是否存在 exists existsSync**


- **截取文件内容 truncate truncateSync**

		


	

	
