@extends('layouts.app')
@section('title', 'フォローワー会員一覧')
@section('content')
    <div class="text-center">
        <h1>フォローワー会員一覧</h1>
    </div>
    <div class="row mt-3">
        @if($users->total() !== 0)
        <p>フォローワー人数: {{ $users->total() }}人</p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>登録日時</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{!! link_to_route('users.show', $user->id , ['id' => $user->id ],[]) !!}</td>
                <td>
                    @if($user->profile)
                    <img src="{{ asset('uploads')}}/{{ $user->profile->image }}" alt="{{ $user->profile->image }}" class="avatar">
                    @else
                    <img src="{{ asset('images/no_image.jpg') }}" alt="アバター画像は未設定です" class="avatar">
                    @endif
                    {!! link_to_route('users.show', $user->name , ['id' => $user->id ],[]) !!}
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            @endforeach
        </table>
        {{ $users->links('pagination::bootstrap-4') }}
        @else
        <p class="mt-3 offset-sm-3 col-sm-6 text-center">フォローしてくれている会員はまだいません</p>
        @endif
        
    </div>
@endsection