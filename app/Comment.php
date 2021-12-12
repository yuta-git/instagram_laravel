<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User; // 追加
use App\Post; // 追加

class Comment extends Model
{
  
  protected $fillable = ['user_id', 'post_id', 'content'];
  
    /**
   * このコメントを所有する投稿。（Userモデルとの多対1の関係を定義）
   */
   public function post() {
     return $this->belongsTo(Post::class);
   }
   
   /**
   * この投稿を所有するユーザ。（Userモデルとの多対1の関係を定義）
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
   
  
}
