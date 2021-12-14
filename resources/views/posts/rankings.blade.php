@extends('layouts.app')
@section('title',  'いいね投稿ランキング')
@section('content')
    <div class="text-center">
        <h1>いいね投稿ランキング</h1>
        @if($posts->count() !== 0)
        <div class="row mt-3">
            <p>投稿件数: {{ $posts->count() }}件</p>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <th>いいね数</th>
                    <th>名前</th>
                    <th>タイトル</th>
                    <th>内容</th>
                    <th>投稿日時</th>
                </tr>
                @foreach($posts as $post)
                <tr>
                    <td>{!! link_to_route('posts.show', $post->id , ['id' => $post->id ],[]) !!}</td>
                    <td>{{ $post->favorite_users->count()}}</td>
                    <td>
                        @if($post->user->profile)
                        <img src="{{ Storage::disk('s3')->url('uploads/' . $post->user->profile->image) }}" alt="{{ $post->user->profile->image }}" class="avatar">
                        @else
                        <img src="{{ Storage::disk('s3')->url('uploads/' . 'images/no_image.jpg') }}" alt="アバター画像は未設定です" class="avatar">
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
        <h2 class="mt-3 text-center">投稿はまだありません</h2>
        @endif
    </div>
@endsection
