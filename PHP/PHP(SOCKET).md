## socket

![image](http://images.cnitblog.com/blog/404636/201303/05172846-06817d0a3a4e412f97fa0fdf08ca6808.jpg)

socket是一种在传输层和应用层之间的软件抽象层。以下图表明了socket所在的位置。就是方便我们程序再应用层 进行操作tcp和udp之间桥梁。它把复杂的TCP/IP协议族隐藏在Socket接口后面，对用户来说，一组简单的接口就是全部，让Socket去组织数据，以符合指定的协议

![image](http://images.cnitblog.com/blog/404636/201303/05172918-d2b39f21a08a4550b4e3c5bce482a220.jpg)

### 服务端

实现一个socket 服务器端链接。大概有以下的步骤

1. 创建socket套接字
2. 端口绑定。
3. 进行监听listen
4. 接受客户端消息accept
5. 有数据读取read
6. 写入数据write
7. 关闭socket

### 客户端

1. 创建socket
2. 链接到socket套接字 connect
3. 向socket 写入数据
4. 读取server的相应数据
5. 关闭socket

以下便是图解
![image](http://images.cnitblog.com/blog/404636/201303/05172951-a955fce4e5d04082828e717fe0e102f9.jpg)

php相关的socket函数


    socket_accept() 接受一个Socket连接
    socket_bind() 把socket绑定在一个IP地址和端口上
    socket_clear_error() 清除socket的错误或者最后的错误代码
    socket_close() 关闭一个socket资源
    socket_connect() 开始一个socket连接
    socket_create_listen() 在指定端口打开一个socket监听
    socket_create_pair() 产生一对没有区别的socket到一个数组里
    socket_create() 产生一个socket，相当于产生一个socket的数据结构
    socket_get_option() 获取socket选项
    socket_getpeername() 获取远程类似主机的ip地址
    socket_getsockname() 获取本地socket的ip地址
    socket_iovec_add() 添加一个新的向量到一个分散/聚合的数组
    socket_iovec_alloc() 这个函数创建一个能够发送接收读写的iovec数据结构
    socket_iovec_delete() 删除一个已经分配的iovec
    socket_iovec_fetch() 返回指定的iovec资源的数据
    socket_iovec_free() 释放一个iovec资源
    socket_iovec_set() 设置iovec的数据新值
    socket_last_error() 获取当前socket的最后错误代码
    socket_listen() 监听由指定socket的所有连接
    socket_read() 读取指定长度的数据
    socket_readv() 读取从分散/聚合数组过来的数据
    socket_recv() 从socket里结束数据到缓存
    socket_recvfrom() 接受数据从指定的socket，如果没有指定则默认当前socket
    socket_recvmsg() 从iovec里接受消息
    socket_select() 多路选择
    socket_send() 这个函数发送数据到已连接的socket
    socket_sendmsg() 发送消息到socket
    socket_sendto() 发送消息到指定地址的socket
    socket_set_block() 在socket里设置为块模式
    socket_set_nonblock() socket里设置为非块模式
    socket_set_option() 设置socket选项
    socket_shutdown() 这个函数允许你关闭读、写、或者指定的socket
    socket_strerror() 返回指定错误号的详细错误
    socket_write() 写数据到socket缓存
    socket_writev() 写数据到分散/聚合数组


例子 创建一个socket服务端

    $host   = "127.0.0.1";
    $port   = "12000";
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_bind($socket, $host, $port);
    socket_listen($socket);
    $count = 0;
    //阻塞
    
    do {
        if (($msgsock = socket_accept($socket)) < 0) {
            echo socket_strerror($msgsock) . "\n";
            break;
        } else {
            //发到客户端
            $msg = "测试成功！\n";
            socket_write($msgsock, $msg, strlen($msg));
            echo "测试成功了啊\n";
            $buf      = socket_read($msgsock, 8192);
            $talkback = "收到的信息:$buf\n";
            echo $talkback;
            if (++$count >= 5) {
                break;
            }
            ;
    
        }
        //echo $buf;
        socket_close($msgsock);
    
    } while (true);
    socket_close($sock);
    
Client 代码


    <?php
    $host   = "127.0.0.1";
    $port   = "12000";
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_connect($socket, $host, $port) or die('connect failed');
    
    $data = "hello \r\n";
    
    if (false !== socket_write($socket, $data, strlen($data))) {
        while ($out = socket_read($socket, 1024)) {
            echo "接受的内容为:", $out;
        }
    }
    
    socket_close($socket);
