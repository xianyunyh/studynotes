##Redis 哈希类型

> Redis hash是一个string类型的field和value的映射表。它的添加、删除操作都是O(1)(平均）。hash特别适用于存储对象。相较于对象的每个字段存在单个string类型。将一个对象存储在hash类型中会占用更小的内存，并且可以更方便的存取整个对象。

myhash = {name:"zhangsan","age":12}

- hset 

添加一个hash值 。如果key不存在，创建key，存在，则覆盖原有值
语法：hset key field  value

	hset myhash  name "zhangsan"
	hset myhash  age "22"

- hget 

获取hash的值

	hget myhash name // zhangsan



- hlen

返回 key 指定的哈希集包含的字段的数量

	hlen myhash //2

- hexists 

判断hash值是否存在。存在返回1  否则返回0

	hexists  myhash name // 1

- HSETNX 

添加一个哈希值 存在啥都不做。

	HSETNX myhash name "test" //0 

- HSTRLEN

返回hash指定field的value的字符串长度，如果hash或者field不存在，返回0.

	HSTRLEN myhash name

- HVALS 

返回hash值里面所有的字段的值
	
	hvals myhash  // zhangsan 12

- HMSET 

批量设置hash值

	hmset myhash height "180" school "beijing"

- HMGET 

批量获取 hash的值下面的field的值

	hmget myhash height age // 180 12

- HKEYS 

返回所有的field。

	hkeys myhash // name age school height

- HGETALL

返回 key 指定的哈希集中所有的字段和值

- HDEL 

删除hash key 的filed

	hdel myhash name