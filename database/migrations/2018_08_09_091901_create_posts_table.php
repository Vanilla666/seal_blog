<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() //建立新資料表
    {
        Schema::create('posts', function (Blueprint $table) { //建立post資料表
            $table->increments('id'); // 主鍵
            $table->unsignedInteger('user_id'); //  新增欄位 異動欄位
            $table->string('title'); //  新增欄位 異動欄位
            $table->string('content'); //  新增欄位 異動欄位
            $table->timestamps();// 建立時間
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
