@extends('layouts.app')
@section('title', '新規画像投稿')
@section('content')
    <div class="text-center">
        <h1>新規画像投稿</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => ['posts.store'], 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('title', 'タイトル') !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('content', '内容') !!}
                    {!! Form::text('content',  old('content'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('image', '画像') !!}
                    {!! Form::file('image') !!}
                </div>

                {!! Form::submit('投稿', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection