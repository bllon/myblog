<?php


namespace App\Http\Controllers\AdminApi;

use App\Common\Error\ErrorCode;
use App\Http\Controllers\UserBaseController;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiException;
use Illuminate\Http\Request;

class Menu extends UserBaseController
{
    public function getMenus()
    {
        $allMenu = DB::table('t_menu')
            ->get()
            ->map(function ($value) {return (array)$value;})
            ->toArray();

        $firstMenu = [];
        $secondMenu = [];
        foreach ($allMenu as $menu) {
            if ($menu['pid'] == 0) {
                $menu['children'] = [];
                $id = $menu['id'];
                unset($menu['pid']);
                $firstMenu[$id] = $menu;
            } else {
                $secondMenu[$menu['id']] = $menu;
            }
        }

        foreach ($secondMenu as $menu) {
            $pid = $menu['pid'];
            unset($menu['pid']);
            $firstMenu[$pid]['children'][] = $menu;
        }

        return $this->responseSuccess(array_values($firstMenu));
    }

    public function updateMenus(Request $request)
    {
        $data = $request->only('id','redirect','title','icon','activeMenu','newType');

        foreach ($data as $key => $value) {
            $data[$key] = !empty($data[$key]) ? $data[$key] : '';
        }

        if (!empty($data['newType'])) {
            foreach ($data['newType'] as $key => $value) {
                $data[$key] = $value;
            }
        }

        unset($data['newType']);
        $data['update_time'] = date('Y-m-d H:i:s', time());

        //更新菜单
        $ret = DB::table('t_menu')
            ->where('id', $data['id'])
            ->update($data);

        if (!$ret) {
            throw new ApiException(ErrorCode::DB_ERROR, '更新菜单失败');
        }

        return $this->responseSuccess();
    }
}