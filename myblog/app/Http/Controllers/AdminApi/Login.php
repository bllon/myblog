<?php
namespace App\Http\Controllers\AdminApi;

use App\Common\Error\ErrorCode;
use App\Common\Response\ResponseJson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Common\Auth\JwtAuth;
use App\Exceptions\ApiException;

class Login extends Controller
{
    use ResponseJson;
    public function login(Request $request)
    {
        if (!$request->has(['username','password'])) {
            throw new ApiException(ErrorCode::ERR_PARAMS, '请输入用户名和密码');
        }
        $username = $request->username;
        $password = $request->password;
        $user = DB::table('t_user')
            ->where('username', $username)
            ->first();

        if (empty($user)) {
            throw new ApiException(ErrorCode::ERR_USER_NOT_EXIST);
        }

        $useJwt = true;

        if (md5($username . $password . 'myblog') == $user->password) {

            if ($useJwt) {
                //使用jwt返回token
                $jwtAuth = JwtAuth::getInstance();
                $token = $jwtAuth->setUid($user->id)->encode()->getToken();
                return $this->responseSuccess(['token' => $token]);
            }

            $token = md5($user->id . $username . time() . 'myblog');
            // 存储token到redis中
            Redis::set($username . 'token', $token);
            return $this->responseSuccess(['token' => $token]);
        }
        throw new ApiException(ErrorCode::ERR_PASSWORD);
    }
}

