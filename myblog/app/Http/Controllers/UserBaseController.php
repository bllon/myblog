<?php


namespace App\Http\Controllers;


use App\Common\Auth\JwtAuth;
use App\Common\Response\ResponseJson;
use Illuminate\Routing\Controller as BaseController;

class UserBaseController extends BaseController
{
    use ResponseJson;

    public $uid;

    public function __construct()
    {
        $this->middleware(function($request, $next) {
           $this->uid =  JwtAuth::getInstance()->getUid();
           return $next($request);
        });
    }
}