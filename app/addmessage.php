<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addmessage extends Model
{
    protected $fillable = [ //  因為posts資料表 新增欄位 (異動) 所以要增加
        'post_id', 'user_id', 'content',
    ];

    public function user() //跟User model 做關聯 1個貼文屬於該創立的使用者
    {
        return $this->belongsTo('App\User');
    }
    
    public function posts() //跟post model 做關聯 1個使用者可以有很多貼文
    {
        return $this->belongsTo('App\Post');
    }
    public function reply() //跟Reply model 做關聯 1個留言可以有很多回復
    {
        return $this->hasMany('App\Reply');
    }
}
