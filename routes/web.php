<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// 一般ユーザー
Route::group(['middleware' => ['guest']], function () {
    
    // プレビューした瞬間の設定
    Route::get('/', 'ToppagesController@index');
    // ログイン認証系
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login')->name('login.post');
    // ユーザ登録系
    Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
    Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

});

// ユーザー認証必要
Route::group(['middleware' => ['auth']], function () {
    
    // ログイン後のリダイレクト先
    Route::get('top', 'PostsController@index');
    
    // ログアウト
    Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');
    
    // ユーザー一覧、詳細表示
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    
    // プロフィール関係
    Route::resource('profiles', 'ProfilesController');
    
    // 画像投稿関係
    Route::resource('posts', 'PostsController');
    
    // タイムライン関係
    Route::get('timelines', 'UsersController@timelines')->name('users.timelines');
    
    // いいねランキング
    Route::get('rankings', 'PostsController@rankings')->name('posts.rankings');
    
    // キーワード検索
    Route::get('search', 'PostsController@search')->name('posts.search');
    
    // ネスト(ユーザー)
    Route::group(['prefix' => 'users/{id}'], function () {
        // いいねした投稿一覧
        Route::get('favorites', 'UsersController@favorites')->name('users.favorites');
        // フォロー・アンフォロー関係
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });
    
    //ネスト（投稿）
    Route::group(['prefix' => 'posts/{id}'], function () {
        // 投稿に対するコメント
        Route::post('comments', 'CommentsController@store')->name('comments.store');
        // いいね系
        Route::post('favorite', 'FavoritesController@store')->name('posts.favorite');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('posts.unfavorite');
    });

});