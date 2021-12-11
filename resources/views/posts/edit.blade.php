@extends('layouts.app')
@section('title', '投稿ID: ' . $post->id . 'の編集')
@section('content')
    <div class="text-center">
        <h1>投稿ID:  {{ $post->id }}の編集</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => ['posts.update', 'id' => $post->id ], 'files' => true, 'method' => 'PUT']) !!}
                <div class="form-group">
                    {!! Form::label('title', 'タイトル') !!}
                    {!! Form::text('title', $post->title ? $post->title : old('title'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('content', '内容') !!}
                    {!! Form::text('content',  $post->content ? $post->content : old('content'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('image', '画像') !!}
                    {!! Form::file('image') !!}
                </div>

                {!! Form::submit('更新', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection