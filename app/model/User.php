<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class User extends Model
{
    public function getUserByUserid($userid,$field = true) {
        if(empty($userid)) {
            return false;
        }

        $where = [
            "id" => $userid,
        ];

        $result = $this->where($where)->field($field)->find();
        return $result;
    }
    public function getUserPassByUser($username,$password,$field = true) {
        $where = [
            "username" => $username,
            "password"=>$password
        ];

        $result = $this->where($where)->field($field)->find();
        return $result;
    }
}
