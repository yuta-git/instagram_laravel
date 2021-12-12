<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // validation
        $this->validate($request, [
            'content' => 'required',
        ]);
        
        // 入力情報の取得
        $content = $request->input('content');
       
        // 入力情報をデータベースに保存
        \Auth::user()->add_comment($id, $content);
    
        // リダイレクト
        return redirect('/posts/' . $id)->with('flash_message', '新規コメント投稿を完了しました。');
    }
}