@extends('Layouts.app')

@section('title', '接続エラー')

@section('content')

    <div class="c-error-page">
        <h2 class="c-error-page__title">419エラー</h2>
        <p class="c-error-page__message">接続に問題が発生している為ページを表示することができません。</p>
        <a href={{ url()->previous() }} class="c-link__underline">前のページに戻る</a>
    </div>

@endsection
