<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment; // 追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Postモデルを使って全投稿を取得
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        // ビューの呼び出し
        return view('top', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 空のPostモデル作成
        $post = new Post();
        // view の呼び出し
        return view('posts.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation
        //for image ref) https://qiita.com/maejima_f/items/7691aa9385970ba7e3ed
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'image' => [
                'required',
                'file',
                'mimes:jpeg,jpg,png'
            ]
        ]);
        
        // 入力情報の取得
        $title = $request->input('title');
        $content = $request->input('content');
        $file = $request->file('image');
 
        // S3用
        $path = Storage::disk('s3')->putFile('/uploads', $file, 'public');
        // パスから、最後の「ファイル名.拡張子」の部分だけ取得
        $image = basename($path);

        // 入力情報をもとに新しいインスタンス作成
        \Auth::user()->posts()->create(['title' => $title, 'content' => $content, 'image' => $image]);
        
        // トップページへリダイレクト
        return redirect('/top')->with('flash_message', '新規画像投稿を完了しました。');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // 空のCommentモデル作成
        $comment = new Comment();
        // 注目する投稿に紐づいたコメント一覧を取得
        $comments = $post->comments()->get();
        // 注目する投稿にいいねをした人の一覧を取得
        $favorite_users = $post->favorite_users()->get();
        
        // view の呼び出し
        return view('posts.show', compact('post', 'comment', 'comments', 'favorite_users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // 注目している投稿がログインしている人のものならば
        if($post->user->id === \Auth::id()){
            return view('posts.edit', compact('post'));
        }else{
            return redirect('/top');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // 注目している投稿がログインしているユーザーのものならば
        if($post->user->id === \Auth::id()){
            // validation
            //for image ref) https://qiita.com/maejima_f/items/7691aa9385970ba7e3ed
            $this->validate($request, [
                'title' => 'required',
                'content' => 'required',
                'image' => [
                    'file',
                    'mimes:jpeg,jpg,png'
                ]
            ]);
            
            // 入力情報の取得
            $title = $request->input('title');
            $content = $request->input('content');
            $file =  $request->image;
            
            // 画像アップロード
            if($file){
                // S3用
                $path = Storage::disk('s3')->putFile('/uploads', $file, 'public');
         
                // パスから、最後の「ファイル名.拡張子」の部分だけ取得
                $image = basename($path);

            }else{
                // 画像が選択されていなければ、もとの画像名のまま
                $image = $post->image;
            }
            
            
            // 入力情報をもとにインスタンス情報の更新
            $post->title = $title;
            $post->content = $content;
            $post->image = $image;
    
            // データベース更新
            $post->save();
            
            // view の呼び出し
            return redirect('/top')->with('flash_message', '投稿ID: ' . $post->id . 'の画像投稿を更新しました。');
        
        }else{
            return redirect('/top');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // 注目している投稿がログインしているユーザーのものならば
        if($post->user->id === \Auth::id()){
            // データベースから削除
            $post->delete();
            // リダイレクト
            return redirect('/top')->with('flash_message', '投稿id: ' . $post->id . 'の画像投稿を削除しました。');
        }else{
            return redirect('/top');
        }
    }
    
    // いいねランキング表示
    public function rankings(){
        //いいね数が多い順に投稿のデータを取得(今回は上位3件)
        // Postモデルにある　favorite_users というリレーション名を使う
        $posts = Post::withCount('favorite_users')->orderBy('favorite_users_count','desc')->paginate();

        // view の呼び出し
        return view('posts.rankings', compact('posts')); 
    }
    
    // キーワード検索
    public function search(Request $request){
        
        // validation
        $this->validate($request, ['keyword' => 'required']);
        
        // 入力された検索キーワードを取得
        $keyword = $request->input('keyword');

        // 検索
        $posts = Post::where('title','like', '%' . $keyword . '%')->orWhere('content', 'like', '%' . $keyword . '%')->paginate(10);
        // フラッシュメッセージのセット
        $flash_message = '検索キーワード: 『' . $keyword . '』に' . $posts->count() . '件ヒットしました';
        
        // view の呼び出し
        return view('top', compact('posts', 'flash_message'));

    }
}