<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/auth/login', 'AdminApi\Login@login');
Route::get('/auth/logout', 'AdminApi\Logout@logout');

Route::middleware(['jwt_auth'])->group(function () {
    Route::get('/user', 'AdminApi\User@info');
    Route::get('/Routes', 'AdminApi\Routes@getRoutes');
    Route::get('/menus', 'AdminApi\Menu@getMenus');
    Route::put('/menus', 'AdminApi\Menu@updateMenus');
});