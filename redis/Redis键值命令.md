## Redis keys 相关的命令

- del 

删除一个key

	del key1

- EXISTS

查看一个键是否存在

	EXISTS key1

- EXPIRE

设置key的过期时间

	EXPIRE key1

- EXPIREAT

设置key的过期时间，有效数值是是一个 unix时间戳

	EXPIREAT 1495358097

- KEYS 

查找所有符合给定模式pattern（正则表达式）的 key

	KEYS * 查看所有的key

- TYPE 

查看key的类型

	TYPE key1 // hash|list|string

- TTL

查看key的剩余过期时间

	TTL KEY // -1yon

如果key不存在或者已过期，返回 -2
如果key没有设置过期时间（永久有效），返回 -1 。

- RANDOMKEY 

随机返回一个key

	RANDOMKEY 

-  RENAME 

给一个key重新命名

	RENAME key newkey

- PERSIST

移除给定key的生存时间，将这个 key 从『易失的』(带生存时间 key )转换成『持久的』(一个不带生存时间、永不过期的 key )。