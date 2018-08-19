<?php
class Process
{
    protected static $numbers = 10;
    public static $workers = [];
    protected static $table;
    protected static $timeout = 10;

    /**
     * 创建内存表
     */
    public static  function initTable()
    {
        $table = new swoole_table(1024);
        $table->column('id', swoole_table::TYPE_INT, 4);       //1,2,4,8
        $table->column('name', swoole_table::TYPE_STRING, 64);
        $table->column('age', swoole_table::TYPE_FLOAT);
        
        $table->create();
        $table->set('1', ['id' => 1, 'name' => 'test1', 'age' => 20]);
        $table->set('2', ['id' => 2, 'name' => 'test2', 'age' => 21]);
        $table->set('3', ['id' => 3, 'name' => 'test3', 'age' => 19]);
        return $table;
        # code...
    }

    /**
     * 创建TCP Server
     */
    protected static function createServer()
    {
        $process = new swoole_process(function($worker){
            $server = new swoole_server("0.0.0.0",9501,SWOOLE_BASE);
            $server->on("receive",function( $server,  $fd,  $reactor_id,  $data)  {
                self::$table->set(rand(2,10), ['id' => rand(2,10), 'name' => 'test2', 'age' => rand(10,30)]);
            });
            $server->on("WorkerStart",function($server, int $worker_id){
                swoole_set_process_name("php:tcp-server");
            });
            $server->start();
        },false,false);
        $process->start();
        self::$workers['server'] = $process;
        return $process;
    }
    /**
     * 初始化
     */
    public static function init()
    {
        swoole_set_process_name("php:master");
        self::$table = self::initTable();
        self::createServer();
    }

    public static function start()
    {
        
        self::init();
        swoole_timer_tick(5000,function(){
            $numbers =  (self::$table)->count();
            foreach(self::$table as $key=>$row) {
               self::create($key,$row); 
            }
        });
        self::wait();
        
    }

    /**
     * 创建进程
     */
    public static function create($index = null,$row=[])
    {
        $process = new swoole_process(function( $worker) use($index) {
            $worker->exec("/usr/bin/php",["-v"]);
        }, false, false);

        $pid = $process->start();
        self::$workers[$pid] = $process;
        return $pid;

    }

    /**
     * 回收子进程
     */
    public static function wait()
    {
        swoole_process::signal(SIGCHLD, function($sig) {
            //必须为false，非阻塞模式
            while($ret =  swoole_process::wait(false)) {
                echo "进程PID={$ret['pid']}退出了\n";
                unset(self::$workers[$ret['pid']]);
            }
          });
          
    }
}

Process::start();
