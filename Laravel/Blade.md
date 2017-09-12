## Blade 模板 ##

> Blade 视图文件使用 .blade.php 做为扩展名，通常保存于 resources/views 文件夹内。

###  模板继承 ###

1. 定义页面布局


	<!-- 文件保存于 resources/views/layouts/master.blade.php -->

	<html>
	    <head>
	        <title>应用程序名称 - @yield('title')</title>
	    </head>
	    <body>
	        @section('sidebar')
	            这是主要的侧边栏。
	        @show
	
	        <div class="container">
	            @yield('content')
	        </div>
	    </body>
	</html>

> @section 与 @yield 命令。正如其名，@section 命令定义一个内容区块，而 @yield 命令被用来 “显示指定区块” 的内容


2. 继承页面模板

>你可以使用 Blade 的 @extends 命令指定子页面应该「继承」哪一个布局。当视图 @extends Blade 的布局之后，即可使用 @section 命令将内容注入于布局的区块中

	<!-- 保存于 resources/views/child.blade.php -->

	@extends('layouts.master')
	
	@section('title', '页面标题')
	
	@section('sidebar')
	    @parent
	
	    <p>这边会附加在主要的侧边栏。</p>
	@endsection
	
	@section('content')
	    <p>这是我的主要内容。</p>
	@endsection

> sidebar 区块利用了 @parent 命令增加（而不是覆盖）内容至布局的侧边栏。@parent 命令会在视图输出时被置换成布局的内容。


###　显示数据

		Route::get('greeting', function () {
	    return view('welcome', ['name' => 'Samantha']);
	});
		Hello, {{ $name }}//view视图文件

### Blade 与 JavaScript 框架
> 可以使用 @ 符号来告知 Blade 渲染引擎该表达式应该维持原样

### 显示未转义的数据

	Hello, {!! $name !!}.

### 控制结构


    @if($a>10)
    >10
    @elseif($a>20)
    >20
    @else
    0
    @endif

	@for ($i = 0; $i < 10; $i++)
	    目前的值为 {{ $i }}
	@endfor
	
	@foreach ($users as $user)
	    <p>此用户为 {{ $user->id }}</p>
	@endforeach
	
	@forelse ($users as $user)
	    <li>{{ $user->name }}</li>
	@empty
	    <p>没有用户</p>
	@endforelse
	
	@while (true)
	    <p>我永远都在跑循环。</p>
	@endwhile

### 引入子视图

	@include('layouts.footer')

### 注释

Blade 也允许在页面中定义注释，然而，跟 HTML 的注释不同的是，Blade 注释不会被包含在应用程序返回的 HTML 内：

	{{-- 此注释将不会出现在渲染后的 HTML --}}


### 视图堆栈 ###

Blade 允许你已命名的 视图堆栈 执行入栈操作：

	@push('scripts')
    <script src="/example.js"></script>
	@endpush

在模板的其他地方 @stack 会把 视图堆栈 里的所有视图显示出来：

	<head>
    <!-- 头部内容 -->

    @stack('scripts')
	</head>

### 服务注入

@inject 命令可以取出 Laravel 服务容器 中的服务。传递给 @inject 的第一个参数为置放该服务的变量名称，而第二个参数为你想要解析的服务的类或是接口的名称：

	@inject('metrics', 'App\Services\MetricsService')

	<div>
	    每月收入：{{ $metrics->monthlyRevenue() }}。
	</div>


### 扩充 Blade

Blade 甚至允许你自定义命令，你可以使用 directive 方法注册命令。当 Blade 编译器遇到该命令时，它将会带参数调用提供的回调函数。

	public function boot()
    {
        Blade::directive('datetime', function($expression) {
            return "<?php echo with{$expression}->format('m/d/Y H:i'); ?>";
        });
    }