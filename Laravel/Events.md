## Events 事件

laravel中的事件，利用了观察者模式。当一个对象发生变化，会通知另外一个对象做出处理。在我们的应用中，我们可以通过事件实现业务的分离。比如当用户进行下单的时候，我们可以发送短信。这个时候，把应用之间的耦合解开。定义一个事件，定义一个监听者，当用户下单，触发事件，事件会通知对应的监听者。

### 1. 注册事件

在eventProvider中注册

```php
protected $listen = [
    'App\Events\OrderShipped' => [
        'App\Listeners\SendShipmentNotification',
    ],
];
```



### 2. 生成注册器

```shell
php artisan event:generate
```

### 3.定义事件

```php
class OrderShipped
{
    use SerializesModels;

    public $order;

    /**
     * 创建一个事件实例。
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
```

### 4. 定义监视器

```php
class SendShipmentNotification
{
    /**
     * 创建事件监听器。
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 处理事件。
     *
     * @param  OrderShipped  $event
     * @return void
     */
    public function handle(OrderShipped $event)
    {
        // 使用 $event->order 来访问 order ...
    }
}
```

### 5. 分发事件

如果要分发事件，你可以将事件实例传递给辅助函数 `event`。这个函数将会把事件分发到所有已经注册的监听器上 

```php
 event(new OrderShipped($order));
```

### 事件订阅者

```php
class UserEventSubscriber
{
    /**
     * 处理用户登录事件。
     */
    public function onUserLogin($event) {}

    /**
     * 处理用户注销事件。
     */
    public function onUserLogout($event) {}

    /**
     * 为订阅者注册监听器。
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }

}
```

### 注册事件订阅者

```php
class EventServiceProvider extends ServiceProvider
{
    /**
     * 应用中事件监听器的映射。
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * 需要注册的订阅者类。
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\UserEventSubscriber',
    ];
}
```

