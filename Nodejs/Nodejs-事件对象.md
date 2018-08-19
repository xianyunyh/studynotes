## Nodejs Events模块

> Node.js 所有的异步 I/O 操作在完成时都会发送一个事件到事件队列。
Node.js里面的许多对象都会分发事件：一个net.Server对象会在每次有新连接时分发一个事件， 一个fs.readStream对象会在文件被打开的时候发出一个事件。 所有这些产生事件的对象都是 events.EventEmitter 的实例。

> Events模块只提供了一个对象EventEmitter


- 创建一个events对象

		// 引入 events 模块
		var events = require('events');
		// 创建 eventEmitter 对象
		var eventEmitter = new events.EventEmitter();

- 注册一个监听器

		eventEmitter.on('connection',function(){
			
		})

- 触发监听 emit

		eventEmitter.emit('connection');

- 绑定一个监听

		eventEmitter.addListener('connection', listener1);

- 移除一个监听事件
		
		eventEmitter.removeListener('connection', listener1);

- 移动所有的监听事件 removeAllListeners

			eventEmitter.removeAllListeners('connection')
		
- 获取监听器的数量

		console.log(eventEmitter.listenerCount('connection'))

- 获取监听器的数组

		eventEmitter.listeners()

- 获取最大监听器的数量

		eventEmitter.getMaxListeners()//默认是10