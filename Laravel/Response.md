## Laravel Response响应

所有的路由及控制器必须返回某个类型的响应，并发送回用户的浏览器

-  响应对象

		Route::get('home',function(){
		    return (new \Illuminate\Http\Response("content",'code'))
					->header('content-type','text/html');
		});

-  添加响应头 

		Route::get('home1',function(){
		   return response('hello world')
				->withHeaders(['X-Powered-By'=>'ddd','content-type'=>'text/html']);
		});

- 附加cookie到响应

		Route::get('home2',function(){
		    return (new \Illuminate\Http\Response('home2'))
				->cookie('aa','test','0');
		});

- Cookie和加密。

>默认的cookie都是加密的，如果你需要生成的cookie不需要加密 可以配置中间件App\Http\Middleware\EncryptCookies

		protected $except = [
		    'cookie_name',
		];


### 其他响应


**1. 视图响应**

		 return response()->view('aa');

**2. json 响应**

	     return response()->json(['name' => 'Abigail', 'state' => 'CA']);

**3. jsonp **

	 	return response()->json(['name' => 'Abigail', 'state' => 'CA'])->setCallback('call');

**4. 文件下载**
> download 方法可以用于生成强制让用户的浏览器下载指定路径文件的响应。download 方法接受文件名称作为方法的第二个参数，此名称为用户下载文件时看见的文件名称。最后，你可以传递一个 HTTP 标头的数组作为第三个参数传入该方法

		return response()->download($pathToFile);

		return response()->download($pathToFile, $name, $headers);

**5. 文件响应** 
> file 方法可以被用来显示一个文件，例如图片或者 PDF，直接在用户的浏览器中显示，而不是下载。这个方法的第一个参数是文件的路径，第二个参数是表头数组

		return response()->file($pathToFile);

		return response()->file($pathToFile, $headers);


### 重定向 


> 重定向响应是类 Illuminate\Http\RedirectResponse 的实例，并且包含用户要重定向至另一个 URL 所需的标头。有几种方法可以生成 RedirectResponse 的实例。最简单的方式就是通过全局的 redirect 辅助函数：

		return redirect('home/dashboard');

		return back()->withInput();
		
		return redirect()->route('login');//重定向到命名路由

- 重定向并加上 Session 闪存数据

	return redirect('dashboard')->with('status', 'Profile updated!');