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
// api.php 檔案包含 RouteServiceProvider 在 api 中介層群組中放置的路由。它會提供速率限制
// 這些路由是無狀態的，所以經由這些路由進入應用程式需要 token 進行認證，並且不能存取 Session 狀態。
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    // JsonApi::register('default', ['namespace' => 'Api'], function ($api, $router) {
    //     $api->resource('post.ajax_user', [
    //         'only' => ['ajax_user', 'read']
    //     ]);
        
    // }); //api 測試
});
