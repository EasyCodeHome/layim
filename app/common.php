<?php
// 应用公共文件

// 应用公共文件


/**
 * 通用化API数据格式输出
 * @param $status
 * @param string $message
 * @param array $data
 * @param int $httpStatus
 * @return \think\response\Json
 */
function show($code, $msg = "error", $data = [], $httpStatus = 200)
{

    $result = [
        "code" => $code,
        "msg" => $msg,
        "data" => $data
    ];

    return json($result, $httpStatus);
}

function getLoginToken($string) {
    // 生成token
    $str = md5(uniqid(md5(microtime(true)), true)); //生成一个不会重复的字符串
    $token = sha1($str.$string); //加密
    return $token;
}