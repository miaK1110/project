@extends('Layouts.app_without_header_footer')

@section('titile', '会員登録')

@section('content')
    <div class="p-register-login">
        <h3 class="p-register-login__title">会員登録</h3>
        <div class="p-register-login__container">
            <div class="p-register-login__item">
                <h4 class="p-register-login__title">店舗登録</h4>
                <img class="p-register-login__img"
                    src="https://haiki-share-backet.s3.ap-northeast-1.amazonaws.com/common-img/female-left.png"
                    alt="img-female-left" />
                <a class="c-btn--primary p-register-login__btn" href="/seller/register">登録する</a>
            </div>
            <div class="p-register-login__item">
                <h4 class="p-register-login__title">一般登録</h4>
                <img class="p-register-login__img"
                    src="https://haiki-share-backet.s3.ap-northeast-1.amazonaws.com/common-img/male-right.png"
                    alt="img-male-right" />
                <a class="c-btn--primary p-register-login__btn" href="/user/register">登録する</a>
            </div>
        </div>
        <div class="p-register-login__url-box">
            <a href="/login" class="p-register-login__url-item c-link__underline">登録済みの方はこちらへ</a>
            <a href="/" class="p-register-login__url-item c-link__underline">トップページへ戻る</a>
        </div>
    </div>
@endsection
