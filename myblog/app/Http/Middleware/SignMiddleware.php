<?php


namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class SignMiddleware
{
    public function handle($request, Closure $next)
    {
        $username = $request->header('X-USERNAME');
        $sign = $request->header('X-SIGN');
        $time = $request->header('X-TIME');

        Carbon::macro('microTimestamp', function () {
            // 返回13位时间戳
            return Carbon::now()->timestamp.str_limit(Carbon::now()->micro, 3, '');
        });
        if ((Carbon::microTimestamp() - $time)/1000 > 60) {
            return response()->json(['code' => -10100, 'message' => '请求已失效']);
        }

        // 判断是否存在token
        if (!Redis::exists($username . 'token')) {
            return response()->json(['code' => -10050, 'message' => '非法请求']);
        }
        $token = Redis::get($username . 'token');

        if (hash('sha256', hash('sha256', $username . '20210314') . $token . $time) != $sign) {
            return response()->json(['code' => -10060, 'message' => '签名验证失败']);
        }
    }
}