<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Qun extends Model
{
    public function getAllQunName($field = true) {
        $result = $this->field($field)->select();
        return $result;
    }
    public function getUseridbyQunid($qunid,$field = true) {
        $where = [
            "id" => $qunid,
        ];
        $result = $this->field($field)->where($where)->find();

        return $result;
    }
}
