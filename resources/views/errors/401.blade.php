@extends('Layouts.app')

@section('title', '認証エラー')

@section('content')

    <div class="c-error-page">
        <h2 class="c-error-page__title">401エラー</h2>
        <p class="c-error-page__message">会員登録時やログイン時に正しく認証ができなかった為、このページを表示できません。</p>
        <a href={{ url()->previous() }} class="c-link__underline">前のページに戻る</a>
    </div>

@endsection
