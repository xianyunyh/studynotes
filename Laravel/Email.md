## 邮件发送

### 1. 配置驱动

```php
'driver' => env('MAIL_DRIVER', 'smtp'),
```

### 2. 生成右键

在 Laravel 中，每种类型的邮件都代表一个「Mailable」对象。这些对象存储在 `app/Mail` 目录中 

```php
php artisan make:mail UserRegister
```

### 3. 编写邮件

所有的 「Mailable」类都在其 `build` 方法中完成配置。在这个方法里，你可以调用其他各种方法，如 `from` 、 `subject` 、 `view` 和 `attach` 来配置完成邮件的详情 	

#### 3.1 配置发送者

```php
public function build()
{
    return $this->from('example@example.com')
                ->view('emails.orders.shipped');
}
```



### 4. 发送邮件

要发送邮件，使用 `Mail` [facade](https://laravel-china.org/docs/laravel/5.6/facades) 的 `to` 方法。 `to` 方法接受一个邮件地址，一个 user 实现或一个 users 集合。如果传递一个对象或集合，mailer 将自动使用 `email` 和 `name` 属性来设置邮件收件人，所以确保你的对象里有这些属性。一旦指定收件人，你可以传递一个实现到 Mailable 类的 `send` 方法： 

```php
Mail::to($request->user())->send(new OrderShipped($order));
```

