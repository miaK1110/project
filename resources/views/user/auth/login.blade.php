@extends('Layouts.app_without_footer')

@section('title', '一般会員ログイン')

@section('content')
    <div class="c-form">
        <form class="c-form__item-wrapper" method="POST" action="{{ route('user.login') }}">
            <h2 class="c-form__title">一般ログイン</h2>
            @csrf
            {{-- email form --}}
            <div class="c-form__item">
                <label for="email" class="c-form__label">
                    {{ __('メールアドレス') }}
                </label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            {{-- password form --}}
            <div class="c-form__item">
                <label for="password" class="c-form__label">
                    {{ __('パスワード') }}
                </label>
                <input id="password" type="password" class="c-form__control @error('password') is-invalid @enderror"
                    name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>

                @error('password')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            {{-- remember me --}}
            <label for="remember" class="c-form__remember-me">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ __('ログイン状態を保持する') }}
            </label>

            <button type="submit" class="c-btn--primary u-mb__s">
                {{ __('ログイン') }}
            </button>

            <a class="c-link__underline u-align__center" href="{{ route('user.password.request') }}">
                {{ __('パスワードをお忘れですか？') }}
            </a>
        </form>
    </div>

@endsection
