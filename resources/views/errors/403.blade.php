@extends('Layouts.app')

@section('title', 'アクセス許可エラー')

@section('content')

    <div class="c-error-page">
        <h2 class="c-error-page__title">403エラー</h2>
        <p class="c-error-page__message">このページへのアクセスが許可されていません。</p>
        <a href={{ url()->previous() }} class="c-link__underline">前のページに戻る</a>
    </div>

@endsection
