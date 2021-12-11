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
        </tr>
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->user->name }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->content }}</td>
            <td><img src="{{ asset('uploads')}}/{{$post->image}}" alt="{{ $post->image }}"></td>
            <td>{{ $post->created_at }}</td>
        </tr>
    </table>

@endsection