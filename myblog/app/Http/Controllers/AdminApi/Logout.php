<?php
namespace App\Http\Controllers\AdminApi;

use App\Common\Response\ResponseJson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Logout extends Controller
{

    use ResponseJson;
    public function logout(Request $request)
    {
//        $username = $request->header('X-USERNAME');
//        $sign = $request->header('X-SIGN');
//        $time = $request->header('X-TIME');
//
//        $value = $request->session()->pull($username . 'token', '');
        return $this->responseSuccess();
    }
}

