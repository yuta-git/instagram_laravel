@extends('layouts.app')
@section('title', $user->name . 'さんのマイページ')
@section('content')
    <div class="text-center">
        <h1>{{ $user->name }} さんのマイページ</h1>
    </div>
    @if($profile)
    <div class="row mt-5">
        <div class="offset-sm-2 col-sm-3">
            <img src="{{ asset('uploads')}}/{{ $profile->image }}" alt="no image" class="image_icon">
        </div>
        <div class="offset-sm-1 col-sm-3 pt-3">
            <p>ニックネーム / {{ $profile->nickname }}</p>
            <p>性別 / {{ $profile->gender === 'man' ? '男性' : '女性' }}</p>
            <p>自己紹介 / {{ $profile->introduction }}</p>
        </div>
    </div>
    @else
    <div class="row mt-5">
        <p class="col-sm-12 text-center">プロフィールは未設定です</p>
    </div>
    @endif
    <div class="row mt-5">
        
        @if (Auth::id() != $user->id)
            @if (Auth::user()->is_following($user->id))
                {!! Form::open(['route' => ['user.unfollow', $user->id], 'method' => 'delete', 'class' => 'offset-sm-3 col-sm-6']) !!}
                    {!! Form::submit('フォロー解除', ['class' => "btn btn-danger btn-block"]) !!}
                {!! Form::close() !!}
            @else
                {!! Form::open(['route' => ['user.follow', $user->id], 'class' => 'offset-sm-3 col-sm-6']) !!}
                    {!! Form::submit('フォロー', ['class' => "btn btn-primary btn-block"]) !!}
                {!! Form::close() !!}
            @endif
        @endif
    </div>
    <div class="row mt-3">
        <p class="col-sm-4">{!! link_to_route('users.favorites', 'お気に入り投稿一覧(' . $user->favorites()->count() . ')', ['id' => $user->id ],['class' => 'nav-link text-center']) !!}</p>
        <p class="col-sm-4">{!! link_to_route('users.followings', 'フォロー一覧(' . $user->followings()->count() . ')', ['id' => $user->id ],['class' => 'nav-link text-center']) !!}</p>
        <p class="col-sm-4">{!! link_to_route('users.followers', 'フォローワー一覧(' . $user->followers()->count() . ')', ['id' => $user->id ],['class' => 'nav-link text-center']) !!}</p>
    </div>
    
    @if(count($posts) !== 0)
    <div class="text-center mt-5">
        <h2>{{ $user->name }} さんの投稿一覧</h2>
    </div>
     <div class="row mt-3">
        <p>投稿数: {{ $posts->total() }}</p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>タイトル</th>
                <th>内容</th>
                <th>投稿日時</th>
            </tr>
            @foreach($posts as $post)
            <tr>
                <td>{!! link_to_route('posts.show', $post->id , ['id' => $post->id ],[]) !!}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->content }}</td>
                <td>{{ $post->created_at }}</td>
            </tr>
            @endforeach
        </table>
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
    @else
    <div class="row mt-5">
        <p class="col-sm-12 text-center">{{ $user->name }} さんの投稿はまだありません</p>
    </div>
    @endif
@endsection