## Laravel 维护模式


> 当你的应用程序处于维护模式时，所有传递至应用程序的请求都会显示出一个自定义视图 
> 

	php artisan down  #启用维护模式

	php artisan up 关闭维护模式

维护模式的相应的模板在 resources/views/errors/503.blade.php

> 处于维护模式中，所有的队列将不会处于工作中。

