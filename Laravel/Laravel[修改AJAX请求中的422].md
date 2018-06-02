## laravel5.4通过ajax提交表单获取到422返回，ajax无法捕获返回内容

可以自定义failedValidation来解决

```php
<?php
use Illuminate\Http\Exceptions\HttpResponseException;

class APIRequest extends FormRequest
{
  /**
 * Handle a failed validation attempt.
 *
 * @param  \Illuminate\Contracts\Validation\Validator  $validator
 * @return void
 *
 * @throws \Illuminate\Validation\ValidationException
 */
protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(response()->json(..., 422));
} 
    
}


```



参考资料

- [https://laracasts.com/discuss/channels/laravel/how-make-a-custom-formrequest-error-response-in-laravel-55?page=1](https://laracasts.com/discuss/channels/laravel/how-make-a-custom-formrequest-error-response-in-laravel-55?page=1)

