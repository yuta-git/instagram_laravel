@extends('layouts.app')
@section('title', $user->name . 'さんのマイページ')
@section('content')
    <div class="text-center">
        <h1>{{ $user->name }} さんのマイページ</h1>
    </div>
@endsection