## Redis Zset 有序集合

> Zset就是有序集合，除了集合的特性外还对每一个集合元素添加了一个顺序的属性.
例如 myzset = {1=>c,3=>d,2=>e}

| row（索引）| value（值）| score（序号）  |
| ------------- |:-------------:| -----:|
| 1    | c | 1 |
| 2      | d      |  3 |
| 3 | e      |   2 |

- ZADD 

添加一个有序集合

语法：ZADD 集合名  序号  集合元素

	zadd myzset  1 "one"

- ZRAGE

返回对应区间的有序集合

语法：ZRANGE 集合名 开始位置 结束位置

	ZRANGE myset 1 2

- ZCARD

返回有序集合中的数量

	ZCARD myset

- ZCOUNT

返回有序集合制定序列之间的元素个数

	ZRANGE myzset 0 1

- ZINCRBY

为元素的序号进行自增

	ZINCRBY myzset 2 'one'

- ZREVRANGE

倒序显示有序集合

	
- zrank

显示某个元素在有序集合中的序号

myzset = {c,d,e,w,a,p,m}
	zrank myzset a //4

- ZREM

 删除元素

	zrem myzset a

- ZREMRANGEBYRANK 

删除指定范围内的元素 通过索引

	ZREMRANGEBYRANK myzset 0 2

- ZREMRANGEBYSCORE

删除指定序号内的元素 通过序号

	ZREMRANGEBYSCORE myzset 0 2

- ZSCORE

显示元素的序号

	ZSCORE myzset a
	