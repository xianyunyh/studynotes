## Redis lists

> Redis lists基于Linked Lists实现。这意味着即使在一个list中有数百万个元素，在头部或尾部添加一个元素的操作，其时间复杂度也是常数级别的。用LPUSH 命令在十个元素的list头部添加新元素，和在千万元素list头部添加新元素的速度相同

  队头<-1 2 3 4 5 6 7 ->队尾

- **LPUSH / LPUSHX**

LPUSH 将所有指定的值插入到存于 key 的列表的头部。如果 key 不存在，那么在进行 push 操作前会创建一个空列表。 如果 key 对应的值不是一个 list 的话，那么会返回一个错误。

LPUSHX 只有当 key 已经存在并且存着一个 list 的时候，在这个 key 下面的 list 的头部插入 value。 与 LPUSH 相反，当 key 不存在的时候不会进行任何操作

	lpush mylist a // lrange mylist 0 1 => a
	lpushx mylist1 a // lrange mylist1 0 1 => null

- **RPUSH / RPUSHX**

RPUSH 向存于 key 的列表的尾部插入所有指定的值。如果 key 不存在，那么会创建一个空的列表然后再进行 push 操作。 当 key 保存的不是一个列表，那么会返回一个错误

RPUSHX 将值 value 插入到列表 key 的表尾, 当且仅当 key 存在并且是一个列表。 和 RPUSH 命令相反, 当 key 不存在时，RPUSHX 命令什么也不做

	RPUSH mylist b 
	RPUSH mylist c
	rrange mylist 0 1 // b c

- **LPOP / RPOP**

LPOP 移除并且返回 key 对应的 list 的第一个元素(队头元素)

RPOP 移除并返回存于 key 的 list 的最后一个元素（队尾元素）

	mylist  =  a b c d e 
	rpop mylist // e
	lop mylist // a 

- **BLPOP / BRPOP**

BLPOP 是阻塞式列表的弹出原语。 它是命令 LPOP 的阻塞版本，这是因为当给定列表内没有任何元素可供弹出的时候， 连接将被 BLPOP 命令阻塞。 当给定多个 key 参数时，按参数 key 的先后顺序依次检查各个列表，弹出第一个非空列表的头元素。

阻塞行为
> 如果所有给定 key 都不存在或包含空列表，那么 BLPOP 命令将阻塞连接， 直到有另一个客户端对给定的这些 key 的任意一个执行 LPUSH 或 RPUSH 命令为止。
一旦有新的数据出现在其中一个列表里，那么这个命令会解除阻塞状态，并且返回 key 和弹出的元素值。

- **LINSERT **

把 value 插入存于 key 的列表中在基准值 pivot 的前面或后面。

mylist [a,b,c,d]

	linsert mylist before c g
	lrange mylist 0 4 // a b c g d
	

- **LRANGE** 

返回存储在 key 的列表里指定范围内的元素。 start 和 end 偏移量都是基于0的下标，即list的第一个元素下标是0（list的表头），第二个元素下标是1，以此类推。


mylist [a,b,c,d]

	LRANGEG mylist 0 1 // a b

- **LINDEX**

返回列表里的元素的索引 index 存储在 key 里面

	LINDEX mylist 0 // a

- **LLEN** 

返回存储在 key 里的list的长度。 如果 key 不存在，那么就被看作是空list，并且返回长度为 0。 当存储在 key 里的值不是一个list的话，会返回error

	LLEN mylist // 4

- LREM 

从存于 key 的列表里移除前 count 次出现的值为 value 的元素。 这个 count 参数通过下面几种方式影响这个操作：

1. count > 0: 从头往尾移除值为 value 的元素。
2. count < 0: 从尾往头移除值为 value 的元素。
3. count = 0: 移除所有值为 value 的元素。

### LISTS 常用案例

1. list可被用来实现聊天系统。还可以作为不同进程间传递消息的队列
2. ist上的阻塞操作可以使用Redis来实现生产者和消费者模型