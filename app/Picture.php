<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
     protected $fillable = [
         'content','picture_url',
         ];

    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //この投稿をお気に入りしているユーザ
    public function favorite_users()
    {
        return $this->belongsToMany(Picture::class,'favorites','picture_id','user_id')->withTimestamps();
    }
}
