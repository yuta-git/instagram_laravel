<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class ToppagesController extends Controller
{
    // Toppage表示
  public function index()
  {
    // Postモデルを使って全投稿データを取得
    $posts = Post::all();
    // viewの呼び出し
    return view('welcome', compact('posts'));
  }
}
