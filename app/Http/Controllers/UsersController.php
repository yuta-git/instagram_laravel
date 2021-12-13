<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Userモデルを使って、全ユーザーデータを取得
        $users = User::paginate(10);
        // viewの呼び出し
        return view('users.index', compact('users'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // 注目しているユーザのプロフィールデータ取得
        $profile = $user->profile()->get()->first();
        // 注目しているユーザの投稿一覧取得
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);

        // view の呼び出し
        return view('users.show', compact('user', 'profile', 'posts'));
    }

    // 注目しているユーザーが、いいねした投稿一覧
    public function favorites($id){
        $user = User::find($id);
        $posts = $user->favorites()->orderBy('id', 'desc')->paginate(5);
        return view('users.favorites', compact('user', 'posts'));
    }

}
