## Redis 发布/订阅

> Redis 发布订阅(pub/sub)是一种消息通信模式：发送者(pub)发送消息，订阅者(sub)接收消息

![](http://www.runoob.com/wp-content/uploads/2014/11/pubsub2.png)

可以作为消息队列


- PUBLISH 

Publish 命令用于将信息发送到指定的频道

	PUBLISH channel message

- SUBSCRIBE

Subscribe 命令用于订阅给定的一个或多个频道的信息。

	SUBSCRIBE channel [channel ...]


- UNSUBSCRIBE

Unsubscribe 命令用于退订给定的一个或多个频道的信息

	UNSUBSCRIBE channel