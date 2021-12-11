<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Profile;
use App\Post; // 追加

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
    
    //Profileモデルと1対1のリレーションを張る
    public function profile() {
        
        //Profileモデルのデータを引っ張ってくる
        return $this->hasOne(Profile::class);
        
    }
    
    /**
     * このユーザーが所有する投稿一覧（ Postモデルとの1対多の関係を定義）
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
}
