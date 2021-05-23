<?php
namespace app\controller;

use app\model\Friends;
use app\model\Group;
use app\model\Qun;
use app\model\User;

class Index extends AuthBase
{
    public function index()
    {
        $result=[];
        $user=new User();
        $mine=$user->getUserByUserid($this->userId,'id,username,sign,touxiang as avatar')->toArray();
        $result['mine']=$mine;
        $group=(new Group())->getAllGroupByUserid($this->userId,'id,group_name as groupname')->toArray();
        foreach ($group as $k =>$v){
            $group[$k]['list']=(new Friends())->getFriendByGroupid($v['id'],'friend_id')->toArray();
        }
        $qun=(new Qun())->getAllQunName('id,qun_name as groupname')->toArray();
        $result['friend']=$group;
        $result['group']=$qun;
        if($result) {
            return show(config("status.success"), "加载成功",$result);
        } else {
            return show(config("status.error"), "加载失败");
        }
    }
    public function qun(){
        $result=[];
        $qunid=input('id');
        $qun = (new Qun())->getUseridbyQunid($qunid)->toArray();
        $ids = explode(',',$qun['user_ids']);
        foreach ($ids as $k=>$v){
            $result['list'][]=(new User())->getUserByUserid($v,'id,username,sign,touxiang as avatar')->toArray();
        }
        if($result) {
            return show(config("status.success"), "加载成功",$result);
        } else {
            return show(config("status.error"), "加载失败");
        }
    }
    public function getUserName(){
        return show(config("status.success"), "success",$this->username);
    }
}
