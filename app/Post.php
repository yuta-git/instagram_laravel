<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User; // 追加

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
}
