<?php


namespace App\Http\Controllers\AdminApi;

use App\Common\Error\ErrorCode;
use App\Http\Controllers\UserBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\ApiException;

class Routes extends UserBaseController
{
    public function getRoutes()
    {
        //查询菜单
        $allMenu = DB::table('t_menu')
            ->get()
            ->map(function ($value) {return (array)$value;})
            ->toArray();

        $firstMenu = [];
        $secondMenu = [];
        foreach ($allMenu as $menu) {
            $menu = $this->formatMenu($menu);
            if ($menu['pid'] == 0) {
                $menu['children'] = [];
                $id = $menu['id'];
                unset($menu['pid']);
                unset($menu['id']);
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

    public function formatMenu($menu)
    {
        if (!empty($menu['hidden'])) {
            $menu['hidden'] = $menu['hidden'] ? true : false;
        }

        if (empty($menu['alwaysShow'])) {
            unset($menu['alwaysShow']);
        } else {
            $menu['alwaysShow'] = $menu['alwaysShow'] ? true : false;
        }

        if (empty($menu['redirect'])) {
            unset($menu['redirect']);
        }

        $menu['meta'] = [];
        if (!empty($menu['roles'])) {
            $menu['meta']['roles'] = explode(',', $menu['roles']);
        }

        $menu['meta']['title'] = $menu['title'];

        if (!empty($menu['icon'])) {
            $menu['meta']['icon'] = $menu['icon'];
        }

        $menu['meta']['noCache'] = $menu['noCache'] ? true : false;
        $menu['meta']['affix'] = $menu['affix'] ? true : false;
        $menu['meta']['breadcrumb'] = $menu['breadcrumb'] ? true : false;

        if (!empty($menu['activeMenu'])) {
            $menu['meta']['activeMenu'] = $menu['activeMenu'] ? true : false;
        }


        unset($menu['roles']);
        unset($menu['title']);
        unset($menu['icon']);
        unset($menu['noCache']);
        unset($menu['affix']);
        unset($menu['breadcrumb']);
        unset($menu['activeMenu']);
        unset($menu['create_time']);
        unset($menu['update_time']);

        return $menu;
    }
}