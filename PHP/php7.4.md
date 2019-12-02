## PHP7.4新特性

PHP7.4上月28号已经发布了。又带来了一些新特性。



### 1. 属性添加限定类型

```php
<?php
class User {
  public int $age;
  public string $name
}  
$user = new User();
$user->age = 10;
$user->name = "张三";
//error
$user->age = "zhang";//需要传递int
```

### 2.箭头函数

这个特性基本上参考`Js`的`ES6`的语法。可以让我们的代码写的更少。如果你的代码有`fn` 这个函数。可能会冲突

```php
<?php
$factor = 10;
$nums = array_map(fn($n)=>$n * $factor,[1,2,3]);//[10,20,30]
//之前的写法
$nums = array_map(function($num)use($factor){
  return $num * $factor;
},[1,2,3])
```

### 3. **有限返回类型协变与参数类型逆变**

仅当使用自动加载时，才提供完全协变/逆变支持。在单个文件中，只能使用非循环类型引用，因为所有类在被引用之前都必须可用。

```php
<?php
class A {}
class B extends A {}

class Producer {
    public function method(): A {}
}
class ChildProducer extends Producer {
    public function method(): B {}
}
?>

```

### 4.数组解包

使用展开运算符`...`解包数组。这个特性，应该又是从js那吸收过来的。看例子

```php
<?php
$parts = ['apple', 'pear'];
$fruits = ['banana', 'orange', ...$parts, 'watermelon'];//['banana', 'orange', 'apple', 'pear', 'watermelon'];
//老的写法
$fruits = array_merge[['banana', 'orange'],$parts,['watermelon']];
```

### 5. 空合并运算符赋值

```php
<?php
$array['key'] ??= computeDefault();
// 老的写法
if (!isset($array['key'])) {
    $array['key'] = computeDefault();
}
?>
```

### 6. 数值文字分隔符

数字文字可以在数字之间包含下划线。 

```php
<?php
6.674_083e-11; // float
299_792_458;   // decimal
0xCAFE_F00D;   // hexadecimal
0b0101_1111;   // binary
?>
```

### 7. 允许从 __toString() 抛出异常

现在允许从 `__toString()` 引发异常，以往这会导致致命错误，字符串转换中现有的可恢复致命错误已转换为 Error 异常。

### 8. Filter 

新增`FILTER_VALIDATE_FLOAT`

```php
<?php
  filter_var(1.00,FILTER_VALIDATE_FLOAT);
```

- [filter.filters.validate](https://www.php.net/manual/zh/filter.filters.validate.php)

### 9. strip_tags 支持数组

```php
<?php
  strip_tags($str,['p','a','div']);
//老的写法
strip_tags($str,"<p><a><div>");
```

## 废弃的特性

### 1. 没有显式括号的嵌套三元运算符

```php
<?php
1 ? 2 : 3 ? 4 : 5;   // deprecated
(1 ? 2 : 3) ? 4 : 5; // ok
1 ? 2 : (3 ? 4 : 5); // ok
?>
```

面试的时候，终于不用担心问你这个结果是啥了。其实生产中，大家也不会这么写。

### 2. 花括号访问数组索引

```php
<?php
$arr = ["a"=>"111"];
$index = "a";
$arr{$index}//废弃
$arr[$index];
```

说实话，还是第一次见到，废弃了，说明大家不会这么用。

### 3. real 和 is_real  实数

```php
<?php
  $num = "";
  $a = (real) $num;//废弃
$a = (float) $num;
```

### 4. parent关键词在没父类的类中使用

在没有父类的类中使用parent 会出现编译错误。

```php
<?php
  class Test{
  public function index() 
  {
    return parent::index();//编译错误
  }
}
```

### 5. money_format函数

`money_format`被废弃，使用`numberFormater`替换

### 6. 移除的拓展

- [Firebird/Interbase](https://www.php.net/manual/zh/book.ibase.php)
- [Recode](https://www.php.net/manual/zh/book.recode.php)
- [WDDX](https://www.php.net/manual/zh/book.wddx.php)
