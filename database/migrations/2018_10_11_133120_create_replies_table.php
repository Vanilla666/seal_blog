<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() //建立回復資料表 
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('message_id'); //  新增欄位 異動欄位
            $table->unsignedInteger('user_id'); //  新增欄位 異動欄位
            $table->unsignedInteger('post_id'); //  新增欄位 異動欄位
            $table->string('content'); //  新增欄位 異動欄位
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
