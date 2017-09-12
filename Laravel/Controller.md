## Laravel控制器

App\Http\Controllers\Controller;

	class DemoController extends Controller{}


### 控制器中间件

    Route::get('profile', [
    'middleware' => 'auth',
    'uses' => 'UserController@showProfile'
    ]);
    
### RESTful 资源控制器

资源控制器让你可以轻松地创建与资源相关的 RESTful 控制器

- 创建一个资源控制器 

      php artisan make:controller PhotoController --resource


动词介绍

> 动词	路径	行为（方法）	路由名称
GET	/photo	index	photo.index
GET	/photo/create	create	photo.create
POST	/photo	store	photo.store
GET	/photo/{photo}	show	photo.show
GET	/photo/{photo}/edit	edit	photo.edit
PUT/PATCH	/photo/{photo}	update	photo.update
DELETE	/photo/{photo}	destroy	photo.destroy


### 依赖注入与控制器

> 依赖注入就是 通过构造 将类导入到当前控制器中

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

### 路由缓存

> 路由缓存并不会作用在基于闭包的路由。要使用路由缓存，你必须将所有闭包路由转换为控制器类

    php artisan route:cache

清除路由缓存

    php artisan route:clear