@extends('Layouts.app_without_footer')

@section('title', '一般会員登録')

@section('content')
    <div class="c-form">
        <form class="c-form__item-wrapper" method="POST" action="{{ route('user.register') }}">
            <h2 class="c-form__title">一般ユーザー登録</h2>
            <p class="u-pb__m">一般ユーザー用登録フォームです。
                店舗の方はご利用いただけません。下記項目全て入力必須です</p>
            @csrf

            {{-- Eメール form --}}
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

            {{-- パスワード form --}}
            <div class="c-form__item">
                <label for="password" class="c-form__label">
                    {{ __('パスワード') }}
                </label>
                <input id="password" type="password" class="c-form__control @error('password') is-invalid @enderror"
                    name="password" value="{{ old('password') }}" required autocomplete="password" autofocus
                    placeholder="半角英数字6文字以上でご入力ください">
                @error('password')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- パスワード再確認form --}}
            <div class="c-form__item">
                <label for="password-confirm" class="c-form__label">{{ __('パスワード（再確認用）') }}</label>
                <input id="password-confirm" type="password" class="c-form__control" name="password_confirmation" required
                    autocomplete="new-password">
            </div>

            {{-- 名字form --}}
            <div class="c-form__item">
                <label for="family_name" class="c-form__label">
                    {{ __('名字') }}
                </label>
                <input id="family_name" type="text" class="c-form__control @error('family_name') is-invalid @enderror"
                    name="family_name" value="{{ old('family_name') }}" placeholder="例）山田" required
                    autocomplete="family_name" autofocus>

                @error('family_name')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- 名前form --}}
            <div class="c-form__item">
                <label for="first_name" class="c-form__label">
                    {{ __('名前') }}
                </label>
                <input id="first_name" type="text" class="c-form__control @error('first_name') is-invalid @enderror"
                    name="first_name" value="{{ old('first_name') }}" placeholder="例）太郎" required
                    autocomplete="first_name" autofocus>

                @error('first_name')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            {{-- postcode form --}}
            <div class="c-form__item">
                <label for="postcode" class="c-form__label">
                    {{ __('郵便番号') }}
                </label>
                <input id="postcode" type="text" class="c-form__control @error('postcode') is-invalid @enderror"
                    name="postcode" value="{{ old('postcode') }}" placeholder="ハイフンなしの半角数字でご入力ください" required
                    autocomplete="postcode" autofocus>

                @error('postcode')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            {{-- 都道府県form --}}
            <div class="c-form__item">
                <label for="prefecture" class="c-form__label">
                    {{ __('都道府県') }}
                </label>

                <select class="form-control @error('prefecture') is-invalid @enderror" name="prefecture" required>
                    <option value="" hidden>選択してください</option>
                    @foreach (config('pref') as $key => $item)
                        <option value="{{ $item }}" @if (old('prefecture') == $item) selected @endif>
                            {{ $item }}</option>
                    @endforeach
                </select>
                @error('prefecture')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- 市町村区form --}}
            <div class="c-form__item">
                <label for="city" class="c-form__label">
                    {{ __('市町村区') }}
                </label>
                <input id="city" type="text" class="c-form__control @error('city') is-invalid @enderror" name="city"
                    value="{{ old('city') }}" placeholder="例）渋谷区" required autocomplete="city" autofocus>

                @error('city')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- 以降の住所form --}}
            <div class="c-form__item">
                <label for="address" class="c-form__label">
                    {{ __('以降の住所') }}
                </label>
                <input id="address" type="text" class="c-form__control @error('address') is-invalid @enderror"
                    name="address" value="{{ old('address') }}" placeholder="例）神宮前一丁目二番三号" required
                    autocomplete="address" autofocus>

                @error('address')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            {{-- 電話番号form --}}
            <div class="c-form__item u-pb__m">
                <label for="phone" class="c-form__label">
                    {{ __('電話番号') }}
                </label>
                <input id="phone" type="tel" inputmode="tel" class="c-form__control @error('phone') is-invalid @enderror"
                    name="phone" value="{{ old('phone') }}" placeholder="ハイフンなしの半角数字でご入力ください" required
                    autocomplete="phone" autofocus>

                @error('phone')
                    <span class="c-form__err-msg" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>



            <button type="submit" class="c-btn--primary--higher">
                {{ __('登録する') }}
            </button>
        </form>
        <div class="u-align__center u-pt__s">
            <a href="/" class="c-link__underline">トップページへ戻る</a>
        </div>
    </div>
@endsection
