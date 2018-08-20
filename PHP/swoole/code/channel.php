<?php

$chan = new Swoole\Channel(1024 * 256);

for ($i=1; $i < 100; $i++) { 
    $res = $chan->push($i);
}
var_dump($chan->stats());
while($data = $chan->pop()) {
    echo $data."\n";
}
