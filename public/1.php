<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "Server is running: " . $redis->ping().'/n';
$redis->set('11','22');
echo $redis->get('11');