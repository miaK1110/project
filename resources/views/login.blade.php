@extends('Layouts.app_without_header_footer')

@section('titile', 'ログイン')

@section('content')
    <div class="p-register-login">
        <h3 class="p-register-login__title">ログイン</h3>
        <div class="p-register-login__container">
            <div class="p-register-login__item">
                <h4 class="p-register-login__title">店舗ログイン</h4>
                <img class="p-register-login__img"
                    src="https://haiki-share-backet.s3.ap-northeast-1.amazonaws.com/common-img/female-left.png"
                    alt="img-female-left" />
                <a class="c-btn__primary p-register-login__btn" href="/seller/login">ログイン</a>
            </div>
            <div class="p-register-login__item">
                <h4 class="p-register-login__title">一般ログイン</h4>
                <img class="p-register-login__img"
                    src="https://haiki-share-backet.s3.ap-northeast-1.amazonaws.com/common-img/male-right.png"
                    alt="img-male-right" />
                <a class="c-btn__primary p-register-login__btn" href="/user/login">ログイン</a>
            </div>
        </div>
        <div class="p-register-login__url-box">
            <a href="/register" class="c-link__underline">登録がお済みでない方はこちらへ</a>
            <a href="/" class="c-link__underline">トップページへ戻る</a>
        </div>
    </div>
@endsection
