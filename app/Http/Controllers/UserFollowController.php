<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    // フォロー追加
  public function store(Request $request, $id)
  {
      \Auth::user()->follow($id);
      return back()->with('flash_message', 'フォローしました');
  }

  // フォロー解除
  public function destroy($id)
  {
      \Auth::user()->unfollow($id);
      return back()->with('flash_message', 'フォローを解除しました');
  }
}
