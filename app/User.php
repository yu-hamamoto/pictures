<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    //このユーザが所有する投稿(Picturesモデルとの関係を定義)
    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }
    
    //このユーザがフォロー中のユーザ（Userモデルとの関係を定義)
    public function followings()
    {
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
    }
    
    //このユーザをフォロー中のユーザ(Userモデルとの関係を定義)
    public function followers()
    {
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }
    
    //$userIdで指定されたユーザをフォローする
    public function follow($userId)
    {
        //すでにフォローしているかの確認
        $exist=$this->is_following($userId);
        //相手が自分自身かどうかの確認
        $its_me=$this->id == $userId;
        
        if($exist || $its_me){
            //すでにフォローしていたら何もしない
            return false;
        } else{
            //未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    //$userIdで指定されたユーザをアンフォローする
    public function unfollow($userId)
    {
        //すでにフォローしているかの確認
        $exist=$this->is_following($userId);
        //相手が自分自身かどうかの確認
        $its_me=$this->id == $userId;
        
        if($exist && !$its_me){
            //すでにフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else{
            //未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId)
    {
        //フォロー中のユーザの中に$userIdのものが存在するか
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    
    public function feed_pictures()
    {
        //このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds=$this->followings()->pluck('users.id')->toArray();
        //このユーザのidもその配列に追加
        $userIds[]=$this->id;
        //それらのユーザが所有する投稿に絞り込む
        return Picture::whereIn('user_id',$userIds);
    }
    
    //このユーザがお気に入りの投稿
    public function favorites()
    {
        return $this->belongsToMany(Picture::class,'favorites','user_id','picture_id')->withTimestamps();
    }
    
    public function favorite($pictureId)
    {
        //すでにお気に入りしているかの確認
        $exist=$this->is_favorites($pictureId);
        
        if($exist){
            //すでにお気に入りしていれば何もしない
            return false;
        } else {
            //お気に入りされていなければお気に入りする
            $this->favorites()->attach($pictureId);
            return true;
        }
    }
    
    public function unfavorite($pictureId)
    {
        //すでにお気に入りしているかの確認
        $exist=$this->is_favorites($pictureId);
        
        if($exist){
            //すでにお気に入りしていればお気に入り解除
            $this->favorites()->detach($pictureId);
            return true;
        } else {
            //お気に入りしていなければ何もしない
            return false;
        }
    }
    
    public function is_favorites($pictureId)
    {
        //お気に入り中の投稿の中に$pictureIdのものが存在するか
        return $this->favorites()->where('picture_id',$pictureId)->exists();
    }
    
    public function loadRelationshipCounts()
    {
        $this->loadCount(['pictures','followings','followers','favorites']);
    }
    
}
