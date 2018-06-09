## 队列

当有一些比较费时的操作，我们就可以放到队列里面去处理。Laravel 队列为不同的队列后台服务提供了统一的 API 

在`config/queue.php`配置对应的drive

### 1 .创建job

一个job 是一个任务，就是队列中需要执行的任务。

```bash
php artisan make:job Process
```

### 2.编写任务类

任务类中handle就是要执行的任务。比如发送短信。导出数据等。

```php
/**
     * 运行任务。
     *
     * @param  AudioProcessor  $processor
     * @return void
     */
    public function handle(Process $processor)
    {
        // Process uploaded podcast...
    }
```

### 3.分发任务

就是把任务加入队列中

```php
 Process::dispatch($podcast);
->onQueue('queue') //指定队列名字
```

