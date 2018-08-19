<?php

use \Swoole\Process;

function sonCallback(Process $worker){
    
    $worker->write("我是子进程");
    echo "heoo";
}

$process = new Process('sonCallback',true);


$process->start();

echo "读取子进程数据:".$process->read();