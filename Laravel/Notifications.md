## Notifications

laravel的notifications。用途主要用于发送消息通知。比如短信，邮件等。这个和任务类似。

### 1. 创建一个通知

```bash
php artisan make:notification InvoicePaid
```

一个通知，就是一个类，这个类就是处理通知的业务。

### 2. 发送通知

发送通知可以使用`Notifiable` trait的`notify`

```php
use Notifiable;

public function test()
{
    $this->notify(new InvoicePaid($invoice));
}
```

 使用facade `Notification`

```php
Notification::send($users, new InvoicePaid($invoice));
```

### 3. 邮件通知

一个通知支持邮件通知，应该定义一个`toMail`方法。这个方法接受$Notifiable。

```php
public function toMail($notifiable)
{
    $url = url('/invoice/'.$this->invoice->id);

    return (new MailMessage)
                ->greeting('Hello!')
                ->line('One of your invoices has been paid!')
                ->action('View Invoice', $url)
                ->line('Thank you for using our application!');
}
```





​	