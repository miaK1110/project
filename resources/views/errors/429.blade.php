@extends('Layouts.app')

@section('title', 'リクエストエラー')

@section('content')

    <div class="c-error-page">
        <h2 class="c-error-page__title">429エラー</h2>
        <p class="c-error-page__message">リクエストが多過ぎた為、ページを表示することができませんでした。</p>
        <a href={{ url()->previous() }} class="c-link__underline">前のページに戻る</a>
    </div>

@endsection
