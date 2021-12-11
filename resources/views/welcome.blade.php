@extends('layouts.app')
@section('title', '会員制写真投稿サイト')
@section('content')
    <div class="row">
        {!! link_to_route('signup.get', '新規会員登録', [], ['class' => 'offset-sm-1 col-sm-4 btn btn-primary']) !!}
        {!! link_to_route('login', 'ログイン', [], ['class' => 'offset-sm-1 col-sm-4 btn btn-danger']) !!}
    </div>
@endsection