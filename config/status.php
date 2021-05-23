<?php
/**
 * 该文件主要是存放业务状态码相关的配置
 * Created by PhpStorm.
 * User: singwa
 * Date: 2019-11-23
 * Time: 14:00
 */

return [
    "success" => 0,
    "error" => -2,
    "not_login" => -1,
    "user_is_register" => -2,
    "action_not_found" => -3,
    "controller_not_found" => -4,

    // mysql相关的状态配置
    "mysql" => [
        "table_normal" => 1, // 正常
        "table_pedding" => 0, // 待审核
        "table_delete" => 99, // 删除
    ],
];
