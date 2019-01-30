<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [ //  因為posts資料表 新增欄位 (異動) 所以要增加 可以被批量賦值的，我們可以使用 create 方法來新增一筆新記錄到資料庫
        'user_id', 'title', 'content',
    ];

    public function user() //跟User model 做關聯 1個貼文屬於該創立的使用者
    {
        return $this->belongsTo('App\User');
    }
    public function addmessage() //跟User model 做關聯 1個貼文屬於該創立的使用者
    {
        return $this->hasMany('App\addmessage');
    }
    public function reply() //跟User model 做關聯 1個貼文屬於該創立的使用者
    {
        return $this->hasMany('App\Reply');
    }
    public function personal() //跟 Personal關聯
    {
        return $this->belongsTo('App\Personal');
    }
    public function visitors() //跟 visitors關聯(文章瀏覽)
   {
       return $this->hasMany('App\VisitorRegistry');
   }
}
