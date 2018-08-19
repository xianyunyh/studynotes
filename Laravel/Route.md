## Laravel 路由的使用


> Laravel的路由默认存放在routes.php  


-  简单

		Route::get('/',function(){
			return view('welcome');
		})
		Route::get('/test',ControllerName@function);

-  控制器路由

		Route::Controller('/test','TestController');
		/test/index =
	    TestController/getIndex

-  Restful资源路由
	
	   Route::resource('posts','PostsController')
       Route::resource('phote','PhotoController',['only'=>'index']);//只允许index动作

-  HTTP请求方式路由

		Route::any('aa',function(){});//允许任何
		Route::post('aa',function(){});//post

-  安全路由

		Route::get('b',['https',function(){
			echo "allow https";
		}])

-   路由约束

		Route::get('test/{bar}','DemoController@getIndex')->where('bar','[0-9]+');

- http 中间件

		Route::get('test1',['middleware'=>'Test',function(){
		    return 1;
		}]);


- 命名路由

		Route::get('fo/test',['as'=>'fotest',function(){
		    echo route('fotest');
		}]); //使用route 函数生成

	 	Route::get('user/test','DemoController@getIndex')->name('test2');

- 路由前缀

		Route::group(['prefix'=>'admin'],function(){
		    Route::get('users','DemoController@getIndex');
		}); //admin/users

- 子域名路由

		Route::group([
	    'domain'=>'{sub.aa.com}',function(){
	        
	    }
	]);