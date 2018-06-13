## 数据库

数据库的配置文件放置在 `config/database.php` 文件中，你可以在此定义所有的数据库连接，并指定默认使用的连接 

### 主从配置

```php
'mysql' => [
    'read' => [
        'host' => '192.168.1.1',
    ],
    'write' => [
        'host' => '196.168.1.2'
    ],
    'sticky'    => true,
    'driver'    => 'mysql',
    'database'  => 'database',
    'username'  => 'root',
    'password'  => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
],
```

```php
DB::connection('foo')->select();//指定对应的链接
```

### sql操作

```php
DB::select("select * from user");
DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
DB::update('update users set votes = 100 where name = ?', ['John']);
$deleted = DB::delete('delete from users');
```

### 监听SQL

监听sql需要在seviceProvider的boot中监听

```php
DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
        });
```

### 事务

```php
DB::transaction(function () {
    DB::table('users')->update(['votes' => 1]);

    DB::table('posts')->delete();
});
```

