<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use app\model\User;
use app\validate\User as UserValidate;
class Login extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $username=input('username');
        $password=input('password');
        $data = [
            'username' => $username,
            'password' => $password,
        ];
        $validate = new UserValidate();
        if(!$validate->check($data)) {
            return show(config('status.error'), $validate->getError());
        }
        $user = (new User())->getUserPassByUser($username,$password,'id,username,touxiang as avatar')->toArray();
        $token = getLoginToken($user['username']);
        $redisData = [
            "id" => $user['id'],
            "username" => $user['username'],
            "avatar" => $user['avatar'],
        ];
        if($user){
            $res = cache(config("redis.token_pre").$token, $redisData);
            if($res){
                return show(config("status.success"), "登录成功",$token);
            }
        }

    }

}
