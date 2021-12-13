@extends('layouts.app')
@section('title', '会員一覧')
@section('content')
    <div class="text-center">
        <h1>会員一覧</h1>
    </div>
    <div class="row mt-3">
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
    </div>
@endsection