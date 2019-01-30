<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $fillable = [ 
        'user_id', 'path','name',
    ]; //異動欄位
    
    public function user()
    {
        return $this->belongsTo('App\User'); // 關聯 屬於user
    }
    public function posts()
    {
        return $this->hasMany('App\Post'); // 關聯 
    }
}
