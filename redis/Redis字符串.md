title: redis字符串
categories: redis
tags: [redis]
description: redis字符串
---

## Redis 教程

> redis是一个key-value存储系统。和Memcached类似，它支持存储的value类型相对更多，包括string(字符串)、list(链表)、set(集合)、zset(sorted set --有序集合)和hash（哈希类型）。这些数据类型都支持push/pop、add/remove及取交集并集和差集及更丰富的操作，而且这些操作都是原子性的。在此基础上，redis支持各种不同方式的排序。与memcached一样，为了保证效率，数据都是缓存在内存中。区别的是redis会周期性的把更新的数据写入磁盘或者把修改操作写入追加的记录文件，并且在此基础上实现了master-slave(主从)同步。


redis提供五种数据类型：string，hash，list，set及zset(sorted set)

### string（字符串）

> string是最简单的类型，你可以理解成与Memcached一模一样的类型，一个key对应一个value，其上支持的操作与Memcached的操作类似。但它的功能更丰富。

- set 

将键key设定为指定的“字符串”值。会覆盖之前的值
	
	set key value // 例 set a 12
- mset

对应给定的keys到他们相应的values上

	mset key1 value1 key2 value2

- append

将一个value值追加到对应的key上。

	append key1 appendvalue //例 append a 13 

- setex / psetex 

设置key对应字符串value，并且设置key在给定的seconds时间之后超时过期.
psetex 设置到期时间毫秒

	setex key 12

- setnx  /msettx

将key设置值为value，如果key不存在，这种情况下等同SET命令。当key存在时，什么也不做。

	setnx key 13

- setrange

这个命令的作用是覆盖key对应的string的一部分，从指定的offset处开始，覆盖value的长度

	set key haha 
	setrange key 1 tt // get key htt

- get

获取key的值

	set a 11 
	get a //11

- mget

获取多个key的值

	mget key key1

- incr

对存储在指定key的数值执行原子的加1操作

	set key 10 
	incr key
	get key //11

Redis的原子递增操作最常用的使用场景是计数器、限速器。


- decr（减1） /decr（可以减去对应数值）

对key对应的数字做减1操作。如果key不存在，那么在操作之前，这个key对应的值会被置为0。如果key有一个错误类型的value或者是一个不能表示成数字的字符串，就返回错误。这个操作最大支持在64位有符号的整型数字

	decr key 1
	get key //1
	decrby key 3
	get key //-3

- setbit

设置或者清空key的value(字符串)在offset处的bit值。
	
	SETBIT mykey 7 1
- bitcount

统计字符串被设置为1的bit数
使用 bitmap 实现用户上线次数统计
Bitmap 对于一些特定类型的计算非常有效