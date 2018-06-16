## ORM

### 创建模型

```bash
php artisan make:model User
```

### 定义模型

```php
class Operationlog extends Model
{
    //
    protected $table = 'operationlog';
     public $timestamps = false;
}

```

### 模型操作

#### 1. 查询

```php
Operationlog::all();//获取全部
Operationlog::find(1);//获取单条
Operationlog::where()->first();//返回限制条件的第一个
$data = $model->all();
foreach ($data as $v) {
    echo $v->id."<br>";
}
```

#### 2. 插入数据

插入和更新都使用`save` 

```php
$model->name = 'hello';
$model->save();
```

#### 3. 更新

```php
$model->where()->update(['id'=>1]);更新
```

#### 4. 删除

`delete` `destroy`

```php
$model->where()->delete();
//根据主键删除
$model->destroy(1);

```

#### 5. 批量赋值

```php
$model->create([]);
//// 通过 name 查找航班，不存在则使用 name 和 delayed 属性创建一个实例.
$model->firstOrNew( ['name' => 'Flight 10'], ['delayed' => 1]);
```



$fillable` 可以作为批量赋值的『白名单』设置模型属性

```php
 protected $fillable = ['name'];
```

**保护属性**

`$fillable` 可以作为批量赋值的『白名单』，你也可以使用 `$guarded` 属性来实现。不同的是， `$guarded`属性包含的是不允许被批量赋值的数组 

```php
protected $guarded = ['get'];
```

```php
$model->create(['get'=>"hello"]); //get 将不会写入数据
```

####  查询作用域

本地范围允许定义通用的约束集合以便在应用中复用 

```php
public function scopeStatus($query)
{
    return $query->where('status', '>', 1);
}
$model->status();
```

**动态作用域**

```php
public function scopeOfType($query, $type)
{
    return $query->where('type', $type);
}
```



### 事件

Eloquent 模型会触发许多事件，让你在模型的生命周期的多个时间点进行监控： `retrieved`, `creating`, `created`, `updating`, `updated`, `saving`, `saved`, `deleting`, `deleted`, `restoring`, `restored` 先在你的 Eloquent 模型上定义一个 `$dispatchesEvents` 属性，将 Eloquent 模型的生命周期的多个点映射 

```php
protected $dispatchesEvents = [
    'saved' => UserSaved::class,
    'deleted' => UserDeleted::class,
];
```



#### 观察者

如果你在一个给定模型中监听许多事件，你可以使用观察者将所有的监听添加到一个类。观察者类里的方法名应该反映 Eloquent 想监听的事件。 每个方法接受 model 作为唯一参数 

```php
class UserObserver
{
    /**
     * 监听创建用户事件.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * 监听删除用户事件.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }
}
```

