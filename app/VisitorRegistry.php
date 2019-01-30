<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitorRegistry extends Model
{
    protected $table = 'visitor_registry';

    protected $fillable = ['clicks','post_id'];  //新增異動欄位 clicks點擊 和 張貼文章的使用者
    
    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
