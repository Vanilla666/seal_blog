<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','img_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts() //跟post model 做關聯 1個使用者可以有很多貼文
    {
        return $this->hasMany('App\Post');
    }
    public function addmessage() //跟User model 做關聯 1個貼文屬於該創立的使用者
    {
        return $this->hasMany('App\addmessage');
    }
    public function personal() //跟User model 做關聯 個人資料
    {
        return $this->hasMany('App\Personal');
    }
    public function reply() //跟User model 做關聯 1個貼文屬於該創立的使用者
    {
        return $this->hasMany('App\Reply');
    }
}
