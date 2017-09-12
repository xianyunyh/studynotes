## Laravel 

>视图默认存放在 resources/views

- 判断视图文件是否 存在

		view()->	exists('posts.create')

- 传递数据到视图

		return view('post.index',['name'=>'Jack']);
		return  view('post.index')->with('name','jack');

- 把数据共享给所有视图
>可以通过使用视图 factory 的 share 方法来完成.通常情况下，你会把这些调用 share 方法的代码放在一个服务提供者的 boot 方法内。你可以选择直接写在 AppServiceProvider 里，或是自己生成一个不同的服务提供者来放置这些代码

		public function boot()
	    {
	        view()->share('key', 'value');
	    }


### 视图组件

> 视图组件就是在视图被渲染前，会被调用的闭包或类方法。如果你想在每次渲染某些视图时绑定数据，**视图组件可以帮你把这样的程序逻辑都组织到同一个地方。** 使用 View 辅助函数来获取底层 Illuminate\Contracts\View\Factory contract 实现


注册provice 

	config/app.php 配置providers数组

