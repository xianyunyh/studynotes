<?php


function initTable()
{
    $table = new swoole_table(1024);
    $table->column('id', swoole_table::TYPE_INT, 4);       //1,2,4,8
    $table->column('name', swoole_table::TYPE_STRING, 64);
    $table->column('num', swoole_table::TYPE_FLOAT);
    
    $table->create();
    $table->set('1', ['id' => 1, 'name' => 'test1', 'age' => 20]);
    return $table;
    # code...
}

$table = initTable();
$process = new swoole_process(function($worker) use($table){
    $server = new swoole_server("0.0.0.0",9501,SWOOLE_BASE);
    $server->on("connect",function() {

    });
    $server->on("receive",function( $server,  $fd,  $reactor_id,  $data) use($table) {
        $table->set(rand(2,10), ['id' => rand(2,10), 'name' => 'test2', 'age' => 30]);
    });
    $server->on("close",function(){

    });
    $server->on("WorkerStart",function($server, int $worker_id){
        swoole_set_process_name("php worker:{$worker_id}");
    });
    $server->start();
},false,false);
swoole_set_process_name("php:process:master");
$process->start();


function createProcess(){
    $process = new swoole_process(function($worker){
        $data = $worker->exec("/usr/bin/php",["-v"]);
        $worker->write($data);
        $worker->exit(0);
    },true);
    $process->start();
    return $process;
}


swoole_timer_tick(5000,function() use($table){
    $count = $table->count();
    echo "count={$count}\n";
    for($i = 0;$i<$count; $i++) {
        $p = createProcess();
        echo $p->read();
    }
    
});


swoole_process::signal(SIGCHLD, function ($sig) {
    while ($ret = Swoole\Process::wait(false)) {
            // create a new child process
        echo $ret['pid'] . '退出了';
    }
});
