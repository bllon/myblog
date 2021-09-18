<?php
namespace App\Http\Controllers\AdminApi;

use App\Common\Error\ErrorCode;
use App\Http\Controllers\UserBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\ApiException;

class User extends UserBaseController
{
    public function info()
    {
        return $this->infoCache();
    }

    /**
     * 返回用户角色信息
     * @return mixed
     */
    public function infoCache()
    {
        $cacheUserInfo = Redis::get('uid:' . $this->uid);
        if (!$cacheUserInfo) {
            $user = DB::table('t_user')
                ->where('id', $this->uid)
                ->first();

            if (empty($user)) {
                throw new ApiException(ErrorCode::ERR_USER_NOT_EXIST);
            }

            //获取用户角色，后期通过redis缓存拿
            $roles = DB::table('t_user_role as a')
                ->leftJoin('t_role as b', 'a.role_id', '=', 'b.id')
                ->where('a.user_id', $user->id)
                ->pluck('b.tag');

            $userInfo = [
                'roles' => $roles,
                'name' => $user->username,
                'avatar' => $user->avatar,
                'introduction' => $user->introduction,
            ];

            Redis::setex('uid:' .$this->uid, 3600,  json_encode($userInfo));
        } else {
            $userInfo = json_decode($cacheUserInfo);
        }

        return $this->responseSuccess($userInfo);
    }
}