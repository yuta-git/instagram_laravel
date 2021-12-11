@extends('layouts.app')
@section('title', $user->name . 'さんのマイページ')
@section('content')
    <div class="text-center">
        <h1>{{ $user->name }} さんのマイページ</h1>
    </div>
    @if($profile)
    <div class="row mt-3">
        <div class="offset-sm-2 col-sm-3">
            <img src="{{ asset('uploads')}}/{{ $profile->image }}" alt="no image" class="image_icon">
        </div>
        <div class="offset-sm-1 col-sm-3 pt-3">
            <p>ニックネーム / {{ $profile->nickname }}</p>
            <p>性別 / {{ $profile->gender === 'man' ? '男性' : '女性' }}</p>
            <p>自己紹介 / {{ $profile->introduction }}</p>
        </div>
    </div>
    @else
    <div class="row mt-5">
        <p class="col-sm-12 text-center">プロフィールは未設定です</p>
    </div>
    @endif
@endsection