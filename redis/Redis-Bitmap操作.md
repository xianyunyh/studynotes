## Redis Bitmap

BitMap是什么
bitmap就是通过一个bit位来表示某个元素对应的值或者状态,其中的key就是对应元素本身。我们知道8个bit可以组成一个Byte，所以bitmap本身会极大的节省储存空间.

![](https://imgsa.baidu.com/baike/c0%3Dbaike92%2C5%2C5%2C92%2C30/sign=8172ae52d31373f0e13267cdc566209e/d52a2834349b033b0b84caf317ce36d3d539bd8e.jpg)

- SETBIT
 
设置或者清空key的value(字符串)在offset处的bit值(只能只0或者1)。
大概的空间占用计算公式是： ($offset/8/1024/1024)MB

	SETBIT key offset value 

- GETBIT 

返回key对应的string在offset处的bit值

	GETBIT key offset

- BITCOUNT 

统计字符串被设置为1的bit数

	BITCOUNT key [start end]  

- BITPOS key bit [start] [end]

返回字符串里面第一个被设置为1或者0的bit位。

	BITPOS key bit [start] [end]

- BITOP

> 对一个或多个保存二进制位的字符串 key 进行位元操作，并将结果保存到 destkey 上。
BITOP 命令支持 AND 、 OR 、 NOT 、 XOR 这四种操作中的任意一种参数：
BITOP AND destkey srckey1 srckey2 srckey3 ... srckeyN ，对一个或多个 key 求逻辑并，并将结果保存到 destkey 。
BITOP OR destkey srckey1 srckey2 srckey3 ... srckeyN，对一个或多个 key 求逻辑或，并将结果保存到 destkey 。
BITOP XOR destkey srckey1 srckey2 srckey3 ... srckeyN，对一个或多个 key 求逻辑异或，并将结果保存到 destkey 。
BITOP NOT destkey srckey，对给定 key 求逻辑非，并将结果保存到 destkey 。
除了 NOT 操作之外，其他操作都可以接受一个或多个 key 作为输入。
执行结果将始终保持到destkey里面。

	BITOP operation destkey key

## 使用场景

1. 使用 bitmap 实现用户上线次数统计

假设现在我们希望记录自己网站上的用户的上线频率，比如说，计算用户 A 上线了多少天，用户 B 上线了多少天，用户今天登陆了网站就在用户的key中加1.

	setbit user1 10 1
	setbit user1 11 1 
	bitget user1;//11

2. 统计活跃用户

使用时间作为cacheKey，然后用户ID为offset，如果当日活跃过就设置为1

	setbit 2017-05-21 11 1
	setbit 2017-05-21 12 1
	bitcount 2017-05-21 //2