@extends('layouts.app')
@section('title', '会員制写真投稿サイト')
@section('content')
    <div class="row">
        <p>{{ Auth::user()->name }}さん、ようこそ！</p>
        {!! link_to_route('logout.get', 'ログアウト', [], ['class' => 'offset-sm-1 col-sm-4 btn btn-danger']) !!}
    </div>
@endsection