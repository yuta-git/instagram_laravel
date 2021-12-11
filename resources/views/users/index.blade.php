@extends('layouts.app')
@section('title', '会員一覧')
@section('content')
    <div class="text-center">
        <h1>会員一覧</h1>
    </div>
    <div class="row">
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
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection