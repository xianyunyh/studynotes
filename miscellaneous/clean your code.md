> 任何一个傻瓜都能写出计算机可以理解的代码，惟有写出人类容易理解的代码，才是优秀的程序员

今天在看团队的代码，看到了一些不好的，也学习了一些值得借鉴的地方，就记录一下，作为分享

## 减少嵌套

减少没必要的嵌套，因为嵌套太深，真的读起来，读到最里面的，然后忘记外面的逻辑了。举一个非常经典的反例。

这是一个很经典的登录验证的例子。按照正常的思维进去，先判断是不是`post` 然后判断用户名是不是空，密码是不是空的。但是这样就带来一个问题。代码嵌套的非常深。

```php
if($_SERVER['REQUEST_METHOD'] == 'POST')  {
    if(isset($_POST['username'])) {
        if(!empty($_POST['username'])){
            if(isset($_POST['password'])){
                if(!empty($_POST['password'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                }else{
                    die("密码不能为空");
                }
            }else{
                die("密码没填写");
            }
        }else{

        }
    }else{

    }
}else{

}
```

### 1. 代码尽量提前返回/结束

上面的代码我们反向进行思考。如果不是`post` 就退出，下面的只执行post的逻辑.修改后如下

```php
if($_SERVER['REQUEST_METHOD'] !== 'POST')  {
    die("403");
}
if(!isset($_POST['username']) || empty($_POST['username'])) {
    die("用户名不能为空");
}
if(!isset($_POST['password'])|| empty($_POST['password'])) {
    die("密码不能为空");
}
$username = $_POST['username'];
$password = $_POST['password'];
```

还是以上面的代码为例子

```php
function check() {
    $msg = "";
    if($_SERVER['REQUEST_METHOD'] !== 'POST')  {
        $msg = "禁止访问"
    }
    if(!isset($_POST['username']) || empty($_POST['username'])) {
        $msg = "用户名不能为空";
    }
    if(!isset($_POST['password'])|| empty($_POST['password'])) {
        $msg = "密码不能为空";
	}
    return $msg;
}
```

但是的代码可以提前返回返回错误信息。这样在debug的时候，到return的时候，就会提前结束掉。不然如果代码很长。下面的代码还需要走。

```php
function check() {
    $msg = "";
    if($_SERVER['REQUEST_METHOD'] !== 'POST')  {
        return  "禁止访问"
    }
    if(!isset($_POST['username']) || empty($_POST['username'])) {
        return "用户名不能为空";
    }
    if(!isset($_POST['password'])|| empty($_POST['password'])) {
       return "密码不能为空";
	}
    return $msg;
}
```

### 2. 减少不必要的else分支【非此即彼】

我们在学习`if else` 的时候，都知道 不是 `if` 就是`else` 但是有时候 `else` 并不是必要的、在我们需要做变量赋值的时候，非此即彼的选择的选择，可以通过设置默认值，然后来减少掉else分支。或者通过三元运算符来写更简洁的代码

```php
#bad
$a = 10;
if($a %2 == 0) {
    echo "a是偶数"
}else{
    echo "a是奇数"
}

function isOld($num) {
    if($num %2 == 0) {
        return "a是偶数"
    }else{
        return "a是奇数"
    }
}
```

我们可以减少else分支

```php
$a = 10;
$string = "a是奇数";
if($a % 2 == 0) {
    $string = "a是偶数";
}
echo $string;

$string = ($a %2 == 0) ? "a是偶数" :"a是奇数 ";
```

### 3. foreach中使用break、continue

foreach 是我们用的最多的一种遍历。当遍历数组的时候，我们经常会在foreach里面进行判断。但是我们尽量能实用continue 或者break。跳出或跳过该记录。尽量在if的逻辑中，不要太多的代码。

```php
$data = [1,2,4,5,6];
foreach($data as $item) {
    if($item === 10) {
        //业务逻辑
        
        break;
    }
}

foreach($data as $item) {
    if($item !== 10) {
       continue;
    }
    //业务逻辑
}
```

### 4. 尽量不使用switch

switch 语句有时候容易漏写 一个 `break` 导致意想不到的错误

```php
switch ($variable) {
    case 'a':
        $num = 1;
        break;
    case 'b':
        $num = 2;
        break;
    
    default:
        $num = 1;
        break;
}
```

我们通过一个数组映射的关系来简写上面的代码结构

```php
$map  = [
    'a'=>1,
    'b'=>2
];
$num = $map[$variable] ?? 1;
```

### 5. 实用常量来标记一些类型值

我们在开发中，经常的用到一些数字来表示状态，比如订单的状态，请求的状态，但是数字有时候不是特别容易一眼就看懂，有些人喜欢用**1** 表示成功， 有些人用**1** 表示失败。所以就容易混淆，我们可以通过常量来定义这些值。我们见名识义，看到这个名字，就知道代表啥状态，而不是再去看那些数字

```php
class Test
{
    const SUCCESSS = 1;
    const ERROR  = 0;
    
    public function index()
    {
        if(1) {
            return ['code'=>static::SUCCESSS,'data'=>[]];
        }
        return ['code'=>static::ERROR,'data'=>[]];
    }
    
}
```



## 总结

最后简单的总结一下

1. 如果遇到非此即彼的条件的时候，可以用默认值或提前返回，来较少没必要的`else` 分支
2. `foreach` 中 如果有if条件的时候 可以用`continue` 或`break` 跳过记录。来减少`if` 中的代码量
3. `switch` 语句可以改成 map映射的关系对。

