## Laravel 缓存

> Laravel 给各种不同的缓存系统提供了统一的 API，缓存的配置文件都放在 config/cache.php 中，在这个文件中，你可以指定默认想用哪个缓存驱动，Laravel 支持当前流行的缓存后端

- 数据库缓存

> 使用数据库作为缓存 需要设置一个缓存的表


		Schema::create('cache', function($table) {
	    $table->string('key')->unique();
	    $table->text('value');
	    $table->integer('expiration');
	});

	php artisan cache:table

- Memcached缓存

> 使用 Memcached 做缓存需要先安装 Memcached PECL 扩展包。

	'memcached' => [
	    [
	        'host' => '127.0.0.1',
	        'port' => 11211,
	        'weight' => 100
	    ],
	],

	'memcached' => [
	    [
	        'host' => '/var/run/memcached/memcached.sock',
	        'port' => 0,
	        'weight' => 100
	    ],
	],


- redis 

> 使用 Redis 之前，你必须通过 Composer 安装 predis/predis 扩展包（~1.0）。

	composer require "predis/predis:~1.0"

配置

	'redis' => [
	    'cluster' => false,
	    'default' => [
	        'host'     => '127.0.0.1',
	        'port'     => 6379,
	        'database' => 0,
	    ],

	],


### 缓存的使用 


使用cache的facade

- 读取缓存

	Cache::get(key);
	Cache::get(key,default)

- 判断值是否存在

	Cache::has(key)

-  写入缓存

	Cache::put(key,val,expires)
	Cache::forever('key', 'value');//永久的cache

- 删除缓存

	Cache::flush();//清空缓存

	Cache::forget(key) //移除一个缓存值

- 