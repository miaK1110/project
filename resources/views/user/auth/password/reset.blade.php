@extends('Layouts.app_without_footer')

@section('content')
    <form class="c-form" method="POST" action="{{ route('user.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="c-form__item-wrapper">
            <h3 class="c-form__title">パスワード変更</h3>
            <div class="c-form__item">
                <label for="email" class="c-form__label">
                    メールアドレス
                </label>
                <input id="email" type="email" class="c-form__control @error('email') is-invalid @enderror" name="email"
                    required autocomplete="email" autofocus value="{{ $email ?? old('email') }}" />
                @error('email')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="c-form__item">
                <label for="password" class="c-form__label">
                    新しいパスワード
                </label>
                <input id="password" type="password" class="c-form__control" name="password" required
                    autofocus="new-password" />
                @error('password')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="c-form__item">
                <label for="password-confirm" class="c-form__label">
                    新しいパスワード(再確認)
                </label>
                <input id="password-confirm" type="password" class="c-form__control" name="password_confirmation" required
                    autofocus="new-password" />
            </div>
            <button type="submit" class="c-btn c-btn--primary">
                パスワードを更新する
            </button>
        </div>
    </form>
@endsection
