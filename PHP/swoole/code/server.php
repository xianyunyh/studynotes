<?php
include_once './process.php';
/**
 * 
 */
class Server {

    protected $server;

    protected $host = "0.0.0.0";

    protected $port = "9090";

    protected $callBacks = ['start','connect','close','request'];

    protected $tcpCallBack = ['receive','connect'];

    protected $table;
    
    protected $process;

    protected $tcpServer;

    public function __construct($config = [])
    {
        
        $this->process = new Process();
        $this->table  = $this->process->initTable();
        $this->server = new swoole_http_server($config['http']['host'],$config['http']['port']);
        if(isset($config['http']['setting'])) {
            $this->server->set($config['http']['setting']);
        }
       if(isset($config['tcp']) && !empty($config['tcp'])) {
           $tcpHost = $config['tcp']['host'] ?? "0.0.0.0";
           $tcpPort = $config['tcp']['port'] ?? 9090;
           $this->tcpServer = $this->server->listen($tcpHost,$tcpPort,SWOOLE_SOCK_TCP);
           if(isset($config['tcp']['setting']) && !empty($config['tcp']['setting'])) {
                $this->tcpServer->set($config['tcp']['setting']);
           }
           $this->setCallback($this->tcpServer,$this->tcpCallBack);

       }
    
    }

    protected function setCallback($server,$callback = []) :void
    {
        foreach($callback as $call) {
            $callName  = "on".ucfirst($call);
            if(method_exists($this,$callName)) {
                $server->on($call,[$this,$callName]);
            }
        }
    }

    public function start()
    {
        foreach ($this->callBacks as $callback) {
            $callName = "on".ucfirst($callback);
            
            if(method_exists($this,$callName)) {
                $this->server->on($callback,[$this,$callName]);
            }
        }
        $this->server->start();
        
    }

    /**
     * 
     */
    public function onStart(swoole_server $server  )
    {
        swoole_set_process_name("php:swoole:master");
        
    }
    /**
     * 
     */
    public  function onConnect(swoole_server $server, int $fd, int $reactorId)
    {

    }
    public function onClose(swoole_server $server, int $fd, int $reactorId)
    {
        # code...
    }
    public function onReceive(swoole_server $server, int $fd, int $reactor_id, string $data)
    {
        echo "recive data:".$data;
        $server->send($fd,$data);
    }

    public function onRequest( $request,  $response)
    {
       
        $client = new swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('127.0.0.1', 9090, -1))
        {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $client->send("hello world\n");
        $data = $client->recv();
        
        $client->close();
        $response->end($data);
        
    }
}

$config = [
    "tcp" =>[
        "port"=>"9090",
        "host"=>"127.0.0.1",
        "setting"=>[
            'worker_num' => 4,    //worker process num
            'backlog' => 128,   //listen backlog
            'dispatch_mode'=>1, 
        ]
    ],
    "http"=>[
        "port"=>"8090",
        "host"=>"127.0.0.1",
        "setting" =>[
            'document_root' => '/media/tianlei/00046400000BF940/www/swoole',
            'enable_static_handler' => true,
        ]
    ],
    
];
$server  = new Server($config);
$server->start();