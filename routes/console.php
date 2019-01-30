<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
// console.php 檔案是你可以定義所有基於閉包的終端指令的地方
// 每個閉包綁定一個指令實例，並可以使用簡單的方法來對每個指令的 IO 方法交換資料
// 就算這個檔案沒有定義 HTTP 路由，它也會根據指令端口（路由）來定義到你的應用程式
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');
