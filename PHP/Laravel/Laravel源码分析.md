## lavale源码分析。

先从入口的index.php中


    require __DIR__.'/../bootstrap/autoload.php'; 加载composer 中的自动加载的依赖
    
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    
    
app.php

    $app = new Illuminate\Foundation\Application(
        realpath(__DIR__.'/../')
    ); // 创建一个container 并设置程序的路径
    
    
    