@extends('Layouts.app')

@section('title', 'アクセス過多エラー')

@section('content')

    <div class="c-error-page">
        <h2 class="c-error-page__title">503エラー</h2>
        <p class="c-error-page__message">申し訳ございません。只今アクセスが集中している為、このページを表示することができません。</p>
        <a href={{ url()->previous() }} class="c-link__underline">前のページに戻る</a>
    </div>

@endsection
