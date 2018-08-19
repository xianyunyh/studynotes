<?php
use \Swoole\Process;
$process = new Process(function(Process $worker){
    $worker->exec("/usr/bin/php",["-v"]);
    $worker->exit(0);
},false,false);
$process->start();