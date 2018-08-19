<?php
 $server = new swoole_server("0.0.0.0",9501,SWOOLE_BASE);
 $server->on("receive",function( $server,  $fd,  $reactor_id,  $data)  {
     $this->table->set(rand(2,10), ['id' => rand(2,10), 'name' => 'test2', 'age' => rand(10,30)]);
 });
 $server->on("WorkerStart",function($server, int $worker_id){
    swoole_set_process_name("php:tcp-server");
 });
 $server->start();