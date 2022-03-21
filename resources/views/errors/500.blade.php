@extends('Layouts.app')

@section('title', 'サーバーエラー')

@section('content')

    <div class="c-error-page">
        <h2 class="c-error-page__title">500エラー</h2>
        <p class="c-error-page__message">申し訳ありません。現在このサイトがメンテナンス中あるいはプログラミングエラーが発生している為ページを表示できません。</p>
        <a href={{ url()->previous() }} class="c-link__underline">前のページに戻る</a>
    </div>

@endsection
