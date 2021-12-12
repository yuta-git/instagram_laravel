<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User; // 追加
use App\Comment; // 追加


class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'image',];
    
    /**
     * この投稿を所有するユーザ。（ Userモデルとの多対1の関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //この投稿にコメントしたユーザー一覧（中間テーブルを介して取得）
    public function comment_users() {
        return $this->belongsToMany(User::class, 'comments', 'post_id', 'user_id')->withTimestamps();
    }
    
    /**
     * この投稿に紐づいたコメント一覧（Commentモデルとの1対多の関係を定義）
     */
    public function comments(){
      return $this->hasMany(Comment::class);
    }
    
    
}
