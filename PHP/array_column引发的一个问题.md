## array_column引发的一个问题

今天使用php数组`array_column`处理一个数据的时候，出现了一些小问题。

先简单的介绍下array_column.

```php
array array_column ( array $input , mixed $column_key [, mixed $index_key = null ] )
```

> array_column — 返回数组中指定的一列 
>
> **array_column()** 返回`input`数组中键值为`column_key`的列， 如果指定了可选参数`index_key`，那么`input`数组中的这一列的值将作为返回数组中对应值的键。

```php
$items = array(
    [
        "uid"=>1,
        "pid"=>0,
        "views"=>100
    ],
    [
        "uid"=>2,
        "pid"=>1,
        "views"=>200
    ],
    [
        "uid"=>3,
        "pid"=>0,
        "views"=>300
    ],
    [
        "uid"=>4,
        "pid"=>0,
        "views"=>400
    ],
    [
        "uid"=>5,
        "pid"=>3,
        "views"=>500
    ]
);

array_column($items,'uid');[1,2,3,4,5];
array_column($items,'uid','view');//[100=>1,200=>2,300=>3,400=>4,500=>5];
```

上面的代码可以看到，这个数组可以帮助我们从一个多维数组中返回指定的key的数据。

有些时候，我们会配合`array_search` 查找多维数组的元素。

```php
array_search('3',array_column($items,'uid'));//uid =3所在的数据
```

现在开始说下今天遇到的问题，今天有一个需求，需要统计上面数组中的数据，就是将pid 不等于的item 中的view 加到对应uid的views中去。举个例子，uid =1 的view是100.它有一个子元素uid =2 ，需要把uid =2 的view 加到uid =1 到views上。以此类推。这个需求首先想到的是遍历数组，然后查找每个item中的pid。如果不是0，然后用这个pid 当作uid。去查找pid所在的索引，然后将当前值加上去，然后删掉该记录。

代码如下

```php
array_walk($items,function ($item,$key) use(&$items){
    $uid = $item['uid'];
    //当前item的pid
    $pid = $item['pid'];
    //父id的在items中的索引
    $pidIndex = array_search($pid,array_column($items,'uid'));
    if($pid !== 0 && false !== $pidIndex) {
        //sum到父id记录中
        $items[$pidIndex]['views'] += $item['views'];
        unset($items[$key]);
    }
});

```

初看，没有啥太大的问题。但是由于对`array_column` 不是很熟悉，所以就会出现了问题。上面的代码其实是有问题的。

因为`array_column` 返回的数组，永远都是索引数组。而非关联。如果我们不删数据的话，上面代码是没问题的。但是我们不删除数据，原来的items 就会变成关联数组了。

```php
$items = [[],[],[],[]];
unset($items[1]);
//items 变成
[0=>[],2=>[],3=>[]]
```

当我们再使用`array_column` 就拿不到对应的index了。

上面的代码可以修改成如下

```php
array_walk($items,function ($item,$key) use(&$items){
    $uid = $item['uid'];
    $pid = $item['pid'];
    $row = array_combine(array_keys($items),array_column($items,'uid'));
    $pidIndex = array_search($pid,$row );
    if($pid !== 0 && false !== $pidIndex) {
        $items[$pidIndex]['views'] += $item['views'];
        unset($items[$key]);
    }
});
```



一般情况下，我们使用`array_column` 不会有啥问题。如果改变了里面的index，就会出问题。所以如果需要保持key不变的情况下。可以使用`array_combine` 和 `array_keys`

```php
array_combine(array_keys($items),array_column($items,'uid'));
```

