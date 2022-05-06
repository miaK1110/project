@extends('Layouts.app_without_footer')

@section('content')
    <form class="c-form" method="POST" action="{{ route('seller.password.email') }}">
        @csrf
        @if (session('status'))
            <div class="c-alert c-alert__success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="c-form__item-wrapper">
            <h3 class="c-form__title">パスワードリセット</h3>
            <p class="u-pb__s">登録されたメールアドレスにパスワード変更用のリンクを送ります。ボタンを押してからメール送信までにしばらく時間がかかる場合がございます。</p>

            <div class="c-form__item u-mb__m">
                <label for="email" class="c-form__label">
                    メールアドレス
                </label>
                <input id="email" type="email" class="c-form__control @error('email') is-invalid @enderror" name="email"
                    required autofocus />
                @error('email')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="c-btn c-btn--primary--higher">
                メールを送る
            </button>
            <a href="/seller/login" class="c-link__underline u-align__center u-pt__s">ログイン画面に戻る</a>
        </div>
    </form>
@endsection
