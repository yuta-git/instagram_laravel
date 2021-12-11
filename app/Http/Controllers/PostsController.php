<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

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
        $posts = Post::orderBy('id', 'desc')->get();
        
        //ビューの呼び出し
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
      // view　の呼び出し
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
      $file =  $request->image;
    
      // 画像のアップロード
      // https://qiita.com/ryo-program/items/35bbe8fc3c5da1993366
      if($file){
          // 現在時刻ともともとのファイル名を組み合わせてランダムなファイル名作成
          $image = time() . $file->getClientOriginalName();
          // アップロードするフォルダ名取得
          $target_path = public_path('uploads/');
          // アップロード処理
          $file->move($target_path, $image);
      }else{
          // 画像が選択されていなければ空文字をセット
          $image = '';
      }
      
      //入力情報を基に新しいインスタンスを作成
      \Auth::user()->posts()->create(['title' => $title, 'content' => $content, 'image' => $image]);
      
      // トップページへリダイレクト
      return redirect('/top')->with('flash_message', '新規画像投稿を完了しました');
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
      // view の呼び出し
      return view('posts.show', compact('post'));
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
      if($post->user->id === \Auth::id()) {
        return view('posts.edit', compact('post'));
      } else {
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
      if($post->user->id === \Auth::id()) {
        
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
        // https://qiita.com/ryo-program/items/35bbe8fc3c5da1993366
        if($file){
            // 現在時刻ともともとのファイル名を組み合わせてランダムなファイル名作成
            $image = time() . $file->getClientOriginalName();
            // アップロードするフォルダ名取得
            $target_path = public_path('uploads/');
            // アップロード処理
            $file->move($target_path, $image);
        }else{
            // 画像が選択されていなければ、もとの画像名のまま
            $image = $post->image;
        }
        
        // 入力情報をもとにインスタンス情報の更新
        $post->title = $title;
        $post->content = $content;
        $post->image = $image;
        
        //データベース更新
        $post->save();
        
        // view の呼び出し
        return redirect('/top')->with('flash_message', '投稿ID: ' . $post->id . 'の画像投稿を更新しました。');
    
    //注目している投稿がログインしているユーザーのものじゃなければ、何も処理せずにトップへリダイレクト
     } else {
       
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
}
