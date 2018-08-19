<?php

use \Swoole\Process;

function sonFun(Process $woker)
{
    for($i = 0;$i < 10; $i++) {
        $woker->push('我来自于子进程'."数据{$i}");
    }
    
    # code...
}
$process = new Process("sonFun",false,false);//关闭管道

$process->useQueue();

$process->start();

echo "读取son进程数据:". $process->pop();

var_dump($process->statQueue());