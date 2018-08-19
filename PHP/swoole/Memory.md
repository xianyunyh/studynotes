## 内存操作

Swoole提供了`7`个内存操作的模块。

- lock 锁
- buffer 缓冲
- table 表
- automic 原子计数器
- mmap 磁盘映射
- channel 队列
- serialize 序列化



### table

swoole_table 其实很简单，我们理解成一个hashtable 就行了。通过索引到对应的数据。我们需要定义这个表的大小。然后往里面进行增删改查

#### 1. 初始化表

`$size` 默认是1024，如果设置的值大于1024，而不是2的N次方，系统会调整成2的N的次方

`$conflict_proportion` 表示hash冲突率。我们知道，hashtable 肯定会产生冲突，产生冲突空间就会增加。所以多预留了20%的空间作为冲突使用。

```php
use Swoole\Table;
$table = new Table($size = 1024,$conflict_proportion = 0.2);
```

### 2. 设置表结构 column($key,$type)

定义表结构，就相当于我们创建数据库表的时候，需要指定哪些字段，这样我们插入数据，字段才能对应。

```php
use Swoole\Table;
$table->column('id',Table::TYPE_INT, 1);
$table->column('name',Table::TYPE_STRING, 10);
```

### 3. 创建表 create()

初始化和设置完表结构之后，我们就可以创建表了。

```php
$table->create();
```

### 4. 添加数据set($key,array $data)

第一个参数是key，就是hash的key。我们通过这个key，找到底下的数组数据。相同的key，会覆盖数据、

```php
$table->set('zhang',['id'=>1,'name'=>'zhangsan']);
```

### 5. 读取数据 get($key)

```
array swoole_table->get(string $key, string $field = null);
```

```php
$data = $table->get("zhang");
echo $data['id'];
```

### 6. 修改数据

修改数据是通过覆盖数据来实现的。

```php
$table->set("zhang",["id"=>2]);
```

### 7. 删除数据 del($key)

```
swoole_table->exist(string $key);
```

```php
$res = $table->del("zhang");
```

### 8. 获取表元素个数 count()

```php
$number = $table->count();
```

