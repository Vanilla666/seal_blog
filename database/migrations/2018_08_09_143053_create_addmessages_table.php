<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddmessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addmessages', function (Blueprint $table) { //建好
            $table->increments('id');
            $table->unsignedInteger('post_id'); //  新增欄位 異動欄位
            $table->unsignedInteger('user_id'); //  新增欄位 異動欄位
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
        Schema::dropIfExists('addmessages');
    }
}
