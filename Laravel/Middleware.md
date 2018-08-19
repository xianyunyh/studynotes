## Laravel Middleware


 HTTP 中间件提供了一个方便的机制来过滤进入应用程序的 HTTP 请求 Laravel 框架已经内置了一些中间件，包括维护、身份验证、CSRF 保护，等等

### 全局中间件

若是希望每个 HTTP 请求都经过一个中间件，只要将中间件的类加入到 app/Http/Kernel.php 的 $middleware 属性清单列表中。

###路由指派中间件

- 创建一个中间件 

    	php artisan make:middleware MyMiddleware

- 注册中间件

		protected $routeMiddleware = [
		    
		    'my'=>\App\Http\Middleware\MyMiddleware::class,
		];

- 在路由上使用中间件

      Route::get('my','DemoController@getHome')->middleware('my');

- 中间件组

 通过指定键名的方式来将相关的中间件分配到一个组里面去。

		protected $middlewareGroups = [
		'web' => [
		    \App\Http\Middleware\EncryptCookies::class,
		    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
		    \Illuminate\Session\Middleware\StartSession::class,
		    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
		    \App\Http\Middleware\VerifyCsrfToken::class,
		],

		Route::group(['middleware' => ['web']], function () {
		    //
		});


### 中间件参数

	    public function handle($request, Closure $next,$role)
	    {
	    echo $role;
	    return $next($request);
	    }
	    
	    //中间件参数的路由
	    Route::get('rule/{id}','DemoController@getHome')->middleware('rule:test');


### Terminable 中间件

在http响应之后执行中间件的内容 
Laravel 内置的「session」中间件存储的 session 数据是在响应被发送到浏览器之后才进行写入的。想要做到这一点，你需要定义中间件为「terminable」