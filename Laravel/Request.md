## Request

 ### 获取请求信息 ###

通过依赖注入容器来获取请求的信息。

    public function Test( Request $request)
    {
		
    }

获取数据

    $request->get('id');
	$request->post('id');
	
获取请求的地址

	$request->url();
	$request->fullUrl();

获取请求的方法  

	$request->method()

判断请求方式

	if($request->isMethod('post'))

### 旧输入数据

Laravel 可以让你将本次的输入数据保留到下一次请求发送前

闪存到session中

	$request->flash();

	$request->flashOnly('username', 'email');
	
	$request->flashExcept('password');


### 获取旧的数据

Laravel 也提供了全局辅助函数 old。如果你要在 Blade 模板 中显示旧输入数据，可以使用更加方便的 old 辅助函数：

	$username = $request->old('username');


### cookie 数据


	$request->cookie('cookie1');

### 文件上传

	$request->file('name');//获取上传的文件信息
	$request->hasFile('name') 判断是否上传
	$request->file('photo')->isValid() //判断文件是否有效
	 $request->file('photo')->move('./tests','aa.jpg');//移动到目标位置