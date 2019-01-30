<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model //回復
{
    protected $fillable = [ //  批量復值
        'message_id', 'user_id', 'content','post_id'
    ];
    public function user() //跟User model 做關聯 1個貼文屬於該創立的使用者
    {
        return $this->belongsTo('App\User');
    }
    
    public function posts() //跟post model 做關聯 1個使用者可以有很多貼文
    {
        return $this->belongsTo('App\Post');
    }
    public function addmessage() //跟addmessage model 做關聯 回復屬於一個留言
    {
        return $this->belongsTo('App\addmessage');
    }
}
