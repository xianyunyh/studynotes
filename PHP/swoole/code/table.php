<?php

use Swoole\Table;
$table = new Table(1024);

//设置表字段
$table->column('id',Table::TYPE_INT, 1);
$table->column('name',Table::TYPE_STRING, 10);

//创建表
$table->create();

//添加数据

$key = "zhang";
$data = ['id'=>1,"name"=>'tian'];
$table->set($key ,$data);

//读取表数据

$name = $table->get($key ,'name');
echo $name."\n";

//修改表数据

$table->set($key ,['name'=>'wang']);

$new_name = $table->get($key ,'name');
echo $new_name."\n";

//删除字段

$table->del($key);