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

## 查询构造器

- 获取结果`get`

```php
DB::table()->get()
```

- 获取单行

```php
DB::table('user')->where()->first();// select * from `user ` limit 1
```

- 获取单列

```php
DB::table('user')->where()->pluck('name') // select name from `user`
```

- 聚合查询`count`， `max`， `min`， `avg`， 和 `sum` 

```php
DB::table('users')->count();
DB::table('orders')->max('price');
```

- 查询select

```php
DB::table('users')->select('name')->get();//select name from  users;
$users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count, status'))
                     ->where('status', '<>', 1)
                     ->groupBy('status')
                     ->get();
```

- selectRaw 支持原生语法

```php
$orders = DB::table('orders')
                ->selectRaw('price * ? as price_with_tax', [1.0825])
                ->get();
```

- havingRow、orhavingRaw、whereRow
- 连接查询inner join left join right join

```php
$users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();
$users = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->get();
```

- where语句

```php
where('key','操作符','值');
where([]);

```

- **whereBetween** 

```php
$users = DB::table('users')
                    ->whereBetween('votes', [1, 100])->get();
```

- **whereIn / whereNotIn** 

```php
$users = DB::table('users')
                    ->whereIn('id', [1, 2, 3])
                    ->get();
```

- orderBy

```php
$users = DB::table('users')
                ->orderBy('name', 'desc')
                ->get();
```

- groupby

```php
$users = DB::table('users')
                ->groupBy('account_id')
                ->having('account_id', '>', 100)
                ->get();
```

### 更新和新增

```php
DB::table('users')
            ->where('id', 1)
            ->update(['votes' => 1]);
DB::table('users')->insert(
    ['email' => 'john@example.com', 'votes' => 0]
);
$id = DB::table('users')->insertGetId(
    ['email' => 'john@example.com', 'votes' => 0]
);
```

