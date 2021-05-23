<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Friends extends Model
{
    public function User()
    {
        return $this->hasOne(User::class, 'id','friend_id')->bind([
            'id','username' ,'sign','avatar'=>'touxiang','status'
        ]);

    }

    public function getFriendByGroupid($groupid,$field = true) {
        if(empty($groupid)) {
            return false;
        }

        $where = [
            "group_id" => $groupid,
        ];

        $result = $this->where($where)->with(['user'])->field($field)->select();
        return $result;
    }
}
