## php强大的数组
php的数组的函数非常多，能熟练运用数组，也不容易。今天偶尔使用了几个数组。解决很多的问题、

### 1. array_columns

这个函数不得不说，非常有用。就是从一个二维数组中，找到含有对应key的数据。免得我们再去遍历
```php
$array = [
    ["uid"=>10,"day"=>"16"],
    ["uid"=>11,"day"=>"17"],
    ["uid"=>12,"day"=>"18"],
    ["uid"=>13,"day"=>"19"],
    ["uid"=>14,"day"=>"20"],
];
array_columns($array,'uid');//[10,11,12,13,14]
array_columns($array,'uid','day');//["16"=>10,"17"=>10,"18"=>15,"19"=>15,"20"=>10]
```
### 2. array_keys
返回数组的所有的key
```PHP
$array = [10,10,11,12,12];
array_keys($array); // [0,1,2,3,4,5]
第二种语法
array_keys($array,'12');[4,5]
```

### 3. array_fill & array_fill_keys & array_combine

这两个函数主要的作用就是填充数组，有的时候我们需要创建一个数组，然后需要按照制定的key来填充，foreach是我们最先想到的，但是我们可以通过以上的两个函数实现

- array_fill 用给定的值填充数组
- array_fill_keys 使用指定的键和值填充数组
- array_combine 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值

```php
array_fill(0,4,'a'); // [0=>'a'，1=>'a'，2=>'a'，3=>'a']
$keys = ['a','b','c'];
$values = [1,2,3]
array_fill_keys($keys,"hello");//['a'=>"hello",'b'=>"hello",'c'=>"hello"]

array_combine($keys,$values);// ['a'=>1,'b'=>"2,'c'=>3]
```

### 4. array_walk & array_map

有时候我们需要对数组进行遍历，foreach、for 是大家常用的，但是我们也可以通过array_map和array_walk

两个的区别就是`array_walk` 传递函数的引用，array_map 则是值传递。 array_walk的第一个参数是数组，第二个参数是回调函数，回调函数接受value和key。array_map只传递value。

```php
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");

array_map(function($item){
    $item = "test";
},$fruits);

var_dump($fruits); // 不会改变fuits的值

array_walk($fruits,function(&$item,$index){
    $item = "test";
});

var_dump($fruits);//改变了fruite的值

```





