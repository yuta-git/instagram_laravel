<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //空のプロフィールインスタンス作成
      $profile = new Profile();
      // view の呼び出し
      return view('profiles.create', compact('profile'));
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
          'nickname' => 'required',
          'gender' => 'required',
          'introduction' => 'required',
          'image' => [
              'required',
              'file',
              'mimes:jpeg,jpg,png'
          ]
      ]);
      
        // 入力情報の取得
        $nickname = $request->input('nickname');
        $gender = $request->input('gender');
        $introduction = $request->input('introduction');
        $file =  $request->image;
        
        // https://qiita.com/ryo-program/items/35bbe8fc3c5da1993366
        // 画像ファイルのアップロード
        if($file) {
          // 現在時刻と元々のファイル名を組み合わせてランダムなファイル名を作成
          $image = time() . $file->getClientOriginalName();
          //アップロードするフォルダ名を取得
          $target_path = public_path('uploads/');
          //アップロード処理
          $file->move($target_path, $image);
          
        } else {
          //画像ファイルが選択されていなければ、からの文字列をセット
          $image = '';
        }
        
        //入力情報を基に新しいインスタンスを作成
        \Auth::user()->profile()->create(['nickname' => $nickname, 'gender' => $gender, 'introduction' => $introduction, 'image' => $image]);
        
        //トップページへリダイレクト
        return redirect('/top')->with('flash_message', 'プロフィールを作成しました');
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
      
      //ログインしているのが自分のプロフィールの場合
      if($profile->user_id === \Auth::id()) {
        // view の呼び出し
        return view('profiles.edit', compact('profile'));
      }else{
        return redirect('/top');
      }
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        // ログインしている自分のプロフィールの場合
        if($profile->user_id === \Auth::id()){
            // validation
            //for image ref) https://qiita.com/maejima_f/items/7691aa9385970ba7e3ed
            $this->validate($request, [
                'nickname' => 'required',
                'gender' => 'required',
                'introduction' => 'required',
                'image' => [
                    'file',
                    'mimes:jpeg,jpg,png'
                ]
            ]);
            
            // 入力情報の取得
            $nickname = $request->input('nickname');
            $gender = $request->input('gender');
            $introduction = $request->input('introduction');
            $file =  $request->image;
            
            // 画像ファイルのアップロード
            // https://qiita.com/ryo-program/items/35bbe8fc3c5da1993366
            if($file){
                // 現在時刻ともともとのファイル名を組み合わせてランダムなファイル名作成
                $image = time() . $file->getClientOriginalName();
                // アップロードするフォルダ名取得
                $target_path = public_path('uploads/');
                // アップロード処理
                $file->move($target_path, $image);
            }else{
                // 画像を選択していなければ、画像ファイルは元の名前のまま
                $image = $profile->image;
            }
            
            
            // 入力情報をもとにインスタンスのプロパティ変更
            $profile->nickname = $nickname;
            $profile->gender = $gender;
            $profile->introduction = $introduction;
            $profile->image = $image;
            
            // データベース更新
            $profile->save();
    
            // トップページへリダイレクト
            return redirect('/top')->with('flash_message', 'プロフィールを変更しました。');
        }else{
            return redirect('/top');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
