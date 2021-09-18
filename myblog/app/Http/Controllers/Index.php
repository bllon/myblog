<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Index extends Controller
{
    public function __invoke()
    {
        if (View::exists('index.index')) {
            return view('index.index', []);
        }
        return json_encode(['code' => '-2100', 'msg' => 'error']);
    }

    //辅助函数
    public function help()
    {
        return 'index';
    }

    //dbtest
    public function dbtest()
    {
        dump(rand(10,100));
        dump(env('DB_HOST'));
        $user = DB::table('t_user')
            ->get();
        dump($user);
        return 'ok';
    }
}