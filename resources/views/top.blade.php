@extends('layouts.app')
@section('title',  '投稿一覧')
@section('content')
    @if (isset($flash_message))
      <p class="alert alert-success" role="alert">{{ $flash_message }}</p>
    @endif
    <div class="text-center">
        <h1>投稿一覧</h1>
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
    
                {!! Form::open(['route' => ['posts.search'], 'method' => 'get']) !!}
                    <div class="form-group">
                        {!! Form::label('keyword', 'キーワード') !!}
                        {!! Form::text('keyword', old('title'), ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::submit('検索', ['class' => 'btn btn-primary btn-block']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        @if($posts->total() !== 0)
        <div class="row mt-3">
            <p>投稿件数: {{ $posts->total() }}件</p>
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
                    <td>
                        @if($post->user->profile)
                        <img src="{{ asset('uploads')}}/{{ $post->user->profile->image }}" alt="{{ $post->user->profile->image }}" class="avatar">
                        @else
                        <img src="{{ asset('images/no_image.jpg') }}" alt="アバター画像は未設定です" class="avatar">
                        @endif
                        {!! link_to_route('users.show', $post->user->name , ['id' => $post->user->id ],[]) !!}
                    </td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->content }}</td>
                    <td>{{ $post->created_at }}</td>
                </tr>
                @endforeach
            </table>
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
        @else
        <div class="row">
            <h2 class="mt-3 offset-sm-3 col-sm-6 text-center">投稿はありません</h2>
        </div>
        @endif
    </div>
@endsection