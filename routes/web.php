<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Session 狀態 = 伺服器  Coolie = user
// web.php 檔案包含 RouteServiceProvider 在 web 中介層群組中放置的路由，它會提供 Session 狀態、CSRF 保護和 Cookie 加密。
// 如果你的應用程式沒有提供無狀態的 RESTful API，那麼你的所有路由可能會在 web.php 中定義。
use App\User; // 使用的資料庫
use App\Http\Resources\User as UserResource; //單筆資源
use App\Http\Resources\UserCollection; // 集合資源
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::get('post/loading', 'PostController@load')->name('post.loading');  // 請加在 resoure 前  post/test 最好要重新命名   重新命名 路由命名
    Route::post('post/browse', 'PostController@browse')->name('post.browse');  // 請加在 resoure 前  post/browse 最好要重新命名   重新命名 路由命名 
    Route::get('post/partial_update', 'PostController@partial_update')->name('post.partial_update');  // 導引路由到ajax測試
    Route::get('post/ajax_test', 'PostController@ajax_test')->name('post.ajax_test');  // 導引路由到ajax測試
    Route::resource('post', 'PostController'); //uri, Controller
    Route::post('message/reply','MessageController@reply')->name('message.reply');  //回復路由
    Route::resource('message', 'MessageController'); //uri, Controller
    Route::get('personal/card', 'PersonalController@card')->name('personal.card');  // 請加在 resoure 前  post/card 最好要重新命名   重新命名 路由命名
    Route::post('personal/card_img', 'PersonalController@cardimg')->name('personal.card_img');  //route,處理方式
    Route::resource('personal', 'PersonalController'); //uri, Controller
    Route::get('/user_frist', function () { //找到單筆文章 (JSON)
        return new UserResource(User::find(1));
    });
    Route::get('/user_all', function () { //找到整筆文章(JSON)
        return new UserCollection(User::all());
    });
    
    //Route::get('post')->name('post.test'); // uri, Controller 還要給路由名字 沒用到get方式 所以沒有資料 畫面是空的或錯的
    // Route::get('/showInfo',['middleware' => 'auth','uses' =>'PersonalController@showInfo']); //新增showInfo 方式
    // Route::post('/postInfo',['middleware' => 'auth','uses' =>'PersonalController@postInfo']);
    //  Route::post('message/{id}', 'PostController@addmessage')->name('post.addmessage'); //每個文章代流水號 新增方法 ->name新增路由
    //  Route::delete('message/{id}', 'PostController@deletemessage')->name('post.deletemessage'); //新增路由 刪除功能
 
});
// Route::get('post/','DoctorController@edit')->name('doctor.edit');
