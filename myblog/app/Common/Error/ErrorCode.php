<?php


namespace App\Common\Error;


class ErrorCode
{
    /** error code */

    const SUCCESS = [0, 'ok'];
    const UNKNOWN = [1, '未知错误'];
    const ERR_URL = [3, '访问的接口不存在'];
    const ERR_TOKEN = [4, '令牌错误'];
    const ERR_PARAMS = [5, '参数错误'];
    const DB_ERROR = [6, '数据库执行错误'];

    /**
     * 用户登录错误码 1000-2000
     */
    const ERR_USER_NOT_EXIST = [1000, '用户不存在'];
    const ERR_PASSWORD = [1001, '密码错误'];
    const ERR_TOKEN_INVALID = [1002, '令牌失效'];
}