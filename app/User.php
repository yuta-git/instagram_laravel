<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Profile;
use App\Post; // 追加
use App\Comment; // 追加

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
    
    /**
     * このユーザーが所有するコメント一覧（Commentモデルとの1対多の関係を定義）
     */
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
    // コメント投稿
    public function add_comment($post_id, $content) {
        $comment = new Comment();
        $comment->user_id = $this->id;
        $comment->post_id = $post_id;
        $comment->content = $content;
        $comment->save();
    }
    
    /**
     * このユーザーがいいねをした投稿一覧（中間テーブルを介して取得）
     */
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }
    
    // いいね追加
    public function favorite($post_id)
    {
        // 既にいいねしているかの確認
        $exist = $this->is_favorite($post_id);
    
        if ($exist) {
            // 既にいいねしていれば何もしない
            return false;
        } else {
            // いいねしていないのであればいいねする
            $this->favorites()->attach($post_id);
            return true;
        }
    }
    
    // いいね解除
    public function unfavorite($post_id)
    {
        // 既にいいねしているかの確認
        $exist = $this->is_favorite($post_id);
    
        if ($exist) {
            // 既にいいねしていればいいねを解除
            $this->favorites()->detach($post_id);
            return true;
        } else {
            // いいねしていない場合
            return false;
        }
    }
    
    // 注目する投稿がすでにいいねされているか判定
    public function is_favorite($post_id)
    {
        return $this->favorites()->where('post_id', $post_id)->exists();
    }
    
    //////////////////////////////////
    //  フォロー関係
    /////////////////////////////////
    
     // 注目するユーザーがフォローしている人の一覧取得
     // 誰をフォローしているか
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    // 注目するユーザーをフォローしている人の一覧取得
    // フォロワー取得
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    //フォロー
    public function follow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    // フォロー解除
    public function unfollow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;
    
        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    // 該当ユーザーをフォローしているか判定
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    // タイムライン表示データ作成
    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Post::whereIn('user_id', $follow_user_ids);
    }
    
}
