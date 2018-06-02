## Laravel 表单验证

### 1. 创建表单验证

```shell
php artisan make:request PostRequest
```

### 2. 添加验证规则

```php
class PostRequest extends FormRequest
{
	public function rules()
    {
        return [
            'username' => 'required|max:255',
            'password' => 'required',
        ];
    }

    /**
     * 获取已定义的验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'password.required'  => '密码不能为空',
        ];
    }
}

# 在控制器中使用
class Post extends Controller {
    
    public function store(PostRequest $request) 
    {
        
    }
}
```

### 3. 获取错误信息

在 Validator 实例上调用 `errors` 方法后 .`$errors` 变量是自动提供给所有视图的 `MessageBag` 类的一个实例。

```php
$errors->first("username");//获取username的错误信息
$errors->all();//所有的错误
```



## 手动验证

### 1. 创建验证器

通过validator  Facade创建验证.**make**方法

```php
$validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
if($validator->fails) {
    //验证失败
    return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
}
```

