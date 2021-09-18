<?php


namespace App\Http\Middleware;

use App\Common\Auth\JwtAuth;
use App\Common\Error\ErrorCode;
use App\Common\Response\ResponseJson;
use Closure;

class JwtMiddleware
{
    use ResponseJson;
    /**
     * @param $request
     * @param Closure $next
     * @return array
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('X-Token');

        if ($token) {
            $jwtAuth = JwtAuth::getInstance();
            $jwtAuth->setToken($token);

            if ($jwtAuth->validate() && $jwtAuth->verify()) {
                return $next($request);
            } else {
                return $this->responseError(ErrorCode::ERR_TOKEN_INVALID);
            }
        } else {
            return $this->responseError(ErrorCode::ERR_PARAMS);
        }
    }
}