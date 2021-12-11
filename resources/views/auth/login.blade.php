@extends('layouts.app')
@section('title', 'ログイン')
@section('content')
    <div class="text-center">
        <h1>ログイン</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            <form action="/login" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" class="form-control"  id="password">
                </div>

                <button type="submit" class="btn btn-primary btn-block">ログイン</button>
            </form>
        </div>
    </div>
@endsection