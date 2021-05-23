<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Group extends Model
{
    public function Friends()
    {
        return $this->hasOne(User::Friends, 'group_id','id');

    }
    public function getAllGroupByUserid($userid,$field = true) {
        if(empty($userid)) {
            return false;
        }

        $where = [
            "user_id" => $userid,
        ];

        $result = $this->where($where)->field($field)->select();
        return $result;
    }
}
