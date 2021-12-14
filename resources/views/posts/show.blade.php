@extends('layouts.app')
@section('title', '投稿ID: ' . $post->id . 'の詳細')
@section('content')
    <div class="text-center">
        <h1>投稿ID: {{ $post->id }} の詳細</h1>
    </div>
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>名前</th>
            <th>タイトル</th>
            <th>内容</th>
            <th>画像</th>
            <th>投稿日時</th>
            <th>いいね/いいいね解除</th>
            <th>いいねの数</th>
            <th>いいねした人の一覧</th>
        </tr>
        <tr>
            <td>{{ $post->id }}</td>
            <td>
                <p>
                @if($post->user->profile)
                <img src="{{ Storage::disk('s3')->url('uploads/' . $post->user->profile->image) }}" alt="{{ $post->user->profile->image }}" class="avatar">
                @else
                <img src="{{ asset('images/no_image.jpg') }}" alt="アバター画像は未設定です" class="avatar">
                @endif
                </p>
                {!! link_to_route('users.show', $post->user->name , ['id' => $post->user->id ],[]) !!}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->content }}</td>
            <td><img src="{{ asset('uploads')}}/{{$post->image}}" alt="{{ $post->image }}"></td>
            <td>{{ $post->created_at }}</td>
            <td>
                @if(!Auth::user()->is_favorite($post->id))
                {!! Form::open(['route' => ['posts.favorite', 'id' => $post->id ]]) !!}
                    {!! Form::submit('いいね', ['class' => 'btn btn-primary btn-block']) !!}
                {!! Form::close() !!}
                @else
                {!! Form::open(['route' => ['posts.unfavorite', 'id' => $post->id ], 'method' => 'DELETE']) !!}
                    {!! Form::submit('いいね解除', ['class' => 'btn btn-danger btn-block']) !!}
                {!! Form::close() !!}
                @endif
            </td>
            <td>{{ count($favorite_users) }}いいね</td>
            <td>
                <ul>
                    @foreach($favorite_users as $user)
                    <li>{!! link_to_route('users.show', $user->name , ['id' => $user->id ],[]) !!}</li>
                    @endforeach
                </ul>
            </td>
            <td></td>
        </tr>
    </table>

    @if($post->user->id === Auth::id())
    <div class="row mt-3">
        {!! link_to_route('posts.edit', '編集' , ['id' => $post->id ],['class' => 'btn btn-primary col-sm-6']) !!}
        
        {!! Form::open(['route' => ['posts.destroy', 'id' => $post->id ], 'method' => 'DELETE', 'class' => 'col-sm-6']) !!}
            {!! Form::submit('削除', ['class' => 'btn btn-danger btn-block col-sm-12']) !!}
        {!! Form::close() !!}

    </div>
    @endif
    
    <div class="text-center mt-5">
        <h2>コメント一覧</h2>
    </div>
    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => ['comments.store', 'id' => $post->id ]]) !!}
                <div class="form-group">
                    {!! Form::label('content', 'コメント') !!}
                    {!! Form::text('content', old('content'), ['class' => 'form-control']) !!}
                </div>
                {!! Form::submit('コメント投稿', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    @if(count($comments) !== 0)
    <table class="table table-bordered table-striped mt-3">
        <tr>
            <th>ID</th>
            <th>名前</th>
            <th>コメント内容</th>
            <th>投稿日時</th>
        </tr>
        @foreach($comments as $comment)
        <tr>
            <td>{{ $comment->id }}</td>
            <td>{!! link_to_route('users.show', $comment->user->name , ['id' => $comment->user->id ],[]) !!}</td>
            <td>{{ $comment->content }}</td>
            <td>{{ $comment->created_at }}</td>
        </tr>
        @endforeach
    </table>
    @else
    <div class="row mt-5">
        <div class="col-sm-12 text-center">
            コメントはまだありません。
        </div>
    </div>
    @endif

@endsection