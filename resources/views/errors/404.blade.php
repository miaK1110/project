@extends('Layouts.app')

@php
header('charset=utf8mb4');
@endphp

@section('title', 'お探しのページは見つかりませんでした')

@section('content')

    <div class="c-error-page">
        <h2 class="c-error-page__title">404エラー</h2>
        <p class="c-error-page__message">お探しのページは見つかりませんでした。</p>
        <a href={{ url()->previous() }} class="c-link__underline">前のページに戻る</a>
    </div>

@endsection
