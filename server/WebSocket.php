<?php
declare (strict_types = 1);

namespace app\controller;
use Swoole\Database\RedisPool;
use Redis;
class WebSocket
{
    protected $serv = null;       //Swoole\Server对象
    protected $host = '0.0.0.0'; //监听对应外网的IP 0.0.0.0监听所有ip
    protected $port = 9501;      //监听端口号

    public function __construct()
    {
        //创建websocket服务器对象，监听0.0.0.0:9604端口
        $this->serv = new \Swoole\Websocket\Server($this->host, $this->port);

        //设置参数
        //如果业务代码是全异步 IO 的，worker_num设置为 CPU 核数的 1-4 倍最合理
        //如果业务代码为同步 IO，worker_num需要根据请求响应时间和系统负载来调整，例如：100-500
        //假设每个进程占用 40M 内存，100 个进程就需要占用 4G 内存
        $this->serv->set(array(
            'worker_num' => 2,         //设置启动的worker进程数。【默认值：CPU 核数】
            'max_request' => 1000,    //设置每个worker进程的最大任务数。【默认值：0 即不会退出进程】
            'daemonize' => 0,          //开启守护进程化【默认值：0】
            'dispatch_mode'=>5,
            'task_worker_num'=>2,
            'task_enable_coroutine' => true
        ));
        
        //监听WebSocket连接打开事件
        $this->serv->on('open', function ($serv, $req) {
            
            echo "{$req->fd}连接成功" . PHP_EOL;
            $serv->push($req->fd, 'success');
        });

        //监听WebSocket消息事件
        //客户端向服务器端发送信息时，服务器端触发 onMessage 事件回调
        //服务器端可以调用 $server->push() 向某个客户端（使用 $fd 标识符）发送消息，长度最大不得超过 2M
        $this->serv->on('message', function ($serv, $frame) {
            $data=json_decode($frame->data);
            //  print_r($data);
            if($data->action=='bind'){
                $uid=$data->content->uid;
                if($uid>0){
                    $serv->bind($frame->fd, $uid);
                    $data = array(
                        'task' => 'redis',
                        'fd' => $frame->fd,
                        'uid' => $data->content->uid
                    );
                    //执行任务
                    $serv->task($data);
                }
            }else{
                //获取发送的内容
                $content=$data->content->mine->content;
                // print_r($data->content->to);
                // 判断是群聊还是好友聊天
                // print_r($data->content->to->friend_id);
                if( $data->content->to->type=='friend'){
                    // 获取发给谁 的id
                    $toid=$data->content->to->id;
                    $info=$data->content->mine;
                    $info->type = 'friend';
                    // $info->friend_id = $toid;
                    
                    // 获取(他)连接的所有客户端fd
                    $redis = new Redis();
                    $redis->connect('127.0.0.1', 6379);
                    $arList = $redis->lrange('uid_'.$toid, 0,-1);
                    // print_r($arList);
                    // 循环发送给所有
                    if($arList){
                        foreach ($arList as $k=>$v){
                            $serv->push((int)$v, json_encode($info));
                        }
                    }
                }else{
                    
                }
                
                
            }
            
        });
        //处理异步任务(此回调函数在task进程中执行)
        //$task_id 任务ID
        //$reactor_id 进程ID
        //$data 传递过来的参数
        $this->serv->on('task', function ($serv, \Swoole\Server\Task $task) {
            $data=$task->data;
            
            //异步执行
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
            $arList = $redis->lrange('uid_'.$data['uid'], 0,-1);
            if(!in_array($data['fd'],$arList)){
               $redis->lpush('uid_'.$data['uid'], $data['fd']); 
            }
            foreach ($arList as $k=>$v){
                if(!$serv->exist((int)$v)){
                    $num = $redis->lrem('uid_'.$data['uid'], $v, 0);
                    echo $num. PHP_EOL;;
                };
            }


            // 告诉work进程
            $task->finish([123, 'hello']);
        });

        //处理异步任务的结果(此回调函数在worker进程中执行)
        //$task_id 任务ID
        //$data [onTask]事件返回的数据
        $this->serv->on('finish', function ($serv, $taskId, $data) {
            
            // echo "AsyncTask[$task_id] Finish".PHP_EOL;
        });
        //监听WebSocket连接关闭事件
        $this->serv->on('close', function ($serv, $fd) {
            $info=$serv->getClientInfo($fd);
            $uid = $info['uid'];
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
            // echo $redis->ping();
            $num = $redis->lrem('uid_'.$uid, $fd, 0);
            echo PHP_EOL."connection close: {$num}". PHP_EOL;
        });

        //启动服务
        $this->serv->start();
    }
}
$webSocketServer = new WebSocket();