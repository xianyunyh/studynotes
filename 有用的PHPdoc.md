## 使用PhpStorm的注解

注解和注释的区别

- **注释**是给人看的，比如你描述功能。php的注释方式有两种

  注释是给人看的，避免日后需求更改的时候，自己或者别人看不懂业务逻辑。

```php
// 这是一个行注释
/*
这是一个段落注释
*/
```

- **注解**是给机器看的. 一般都是用段落注释的 双个星号开头`/**`

  这种写法，有个专业的名词叫`PHPDoc`。由于php是弱类型，很多时候一些变量无法通过推断出来，我们可以通过注解的方式，来显示告诉IDE，帮助我们实现自动提示。

```php
/**@var UserModel **/  
```

## 介绍一些常见的PHPdoc 标记

### **档头注解**

- @version

```
@version 0.1 .0
```

目前程式的版本，一开始为0.1.0。建议采用`Major.Minor.Patch`的版本命名方式，也就是`Breaks.Features.Fixes`

- @author

```
@author oomusou oomusou@gmail.com
```

程式一开始建立的`原作者`。第1个参数为姓名，第2个参数为email。

- @date

```
@date 11 / 22 / 15
```

程式一开始建立的`日期`。

- @since

```
@since 0.1.0  11 / 22 / 15 oomusou:新增getLatest3Posts()
```

程式的改版纪录。第1个参数为`版本号`，第2个参数为`修改日期`，第3个参数为`修改者名称`，后见加上`:`，再加上`简易说明`。若有很多版本，就继续加上多个`@since`

### 类注解

使用⌘ + N建立`PHP Class`时，PhpStorm自动会在class之前插入class注解

- @package

  描述class所属的namespace，PhpStorm会自动建立

- **@method**

  对于动态生成的方法，会实现自动提示

  ```php
  **
   * Class User
   * @package App\Http\Controllers
   */
  
  /**
   * @method test($id)
   */
  class User
  {
      public function __call($name, $arguments)
      {
          // TODO: Implement __call() method.
      }
  
  }
  
  $u1 = new User();
  //在我们写$u1的时候，就会自动提示User 有个test这个方法。
  $u1->test(1);
  ```

- **@property** 定义属性

  一般对于魔术`__get()` `__set` 动态生成的属性，ide会自动提示

  ```php
  /**
   * @method test($id)
   * @property $name
   */
  class User
  {
      public function __get()
      {
  
      }
  }
  
  $u1 = new User();
  $u1->name;
  ```

### 方法注解

1. 当使用`pubf`自行建立method时，在method名称后面按⌥ + ↩，PhpStorm会自动根据参数建立method的PHPDoc blocks。
2. 当使用⌃ + I实践interface的method时，只要interface有写好注解，只要在**Add PHPDoc**选择`Copy from base class`，就可以将interface所写好的注解复制过来。

- **@param** 参数注解

  `@param [类型] [形参] [表述]`

- **@return** 对方法返回值就行注解

  这样当我们调用一个方法，返回别的对象的时候，就可以调用这个对象的方法。

  ```php
      /**
       * @param int $id
       * @return LogModel[]|\Illuminate\Database\Eloquent\Collection
       */
      public function getUserInfo(int $id)
      {
         return  LogModel::all();
      }
  ```

- **@todo**

  若method尚有功能未完成，可写在`@todo`里。

- **@deprecated** 表示未来将废弃的方法。写的时候 会有删除线

  这个功能可以帮助我们减少使用过时的方法。



### 变量或属性注解

- **@var**

给一个变量定义。有些时候，我们的变量返回值是某个函数动态创建的，但是我们可以通过`@var` 告诉ide 这个返回值

```php
$task = app(TaskModel::class);
```

上面的那个`$task` 其实应该是返回的taskModel 但是ide 并不知道，对于我们自动提示就很不方便

```php
 /**@var TaskModel $host**/
 $host = app(TaskModel::class);
```



### 其他标签

- `@see` 、`@uses` 

  @see标记用于定义对其他结构元素或者URI的引用。

  @users 用于表述当前元素和任何其他结构元素之间的关系

  @uses类似于@see @uses标记与@see的不同之处在于@see是单向链接，这意味着包含@see标记的文档包含指向其他结构元素或URI的链接，但不暗示链接。
