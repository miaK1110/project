<header class="l-header">
    <div class="l-header__wrapper">
        <div class="l-header__img-container">
            <a href="/">
                <img src="https://haiki-share-backet.s3.ap-northeast-1.amazonaws.com/common-img/logo-small.png"
                    alt="logo" />
            </a>
        </div>
        <nav class="l-header__menu">
            <ul>
                <li><a href="https://haikishare.com">トップ</a></li>
                <span>|</span>
                <li><a href="/products-list">商品一覧</a></li>
                {{-- ログインしているユーザーが店舗ユーザーの時 --}}
                @if (Auth::guard('seller')->check())
                    <span>|</span>
                    <li><a href="https://haikishare.com/seller/home">マイページ</a></li>
                    <span>|</span>
                    <li><a href="https://haikishare.com/seller/logout">ログアウト</a></li>
                    {{-- ログインしているユーザーが一般ユーザーの時 --}}
                @elseif(Auth::guard('user')->check())
                    <span>|</span>
                    <li><a href="https://haikishare.com/user/home">マイページ</a></li>
                    <span>|</span>
                    <li><a href="https://haikishare.com/user/logout">ログアウト</a></li>
                    {{-- ゲストユーザーの時 --}}
                @else
                    <span>|</span>
                    <li><a href="/login">ログイン</a></li>
                    <span>|</span>
                    <li><a href="/register">会員登録</a></li>
                @endif
            </ul>
        </nav>

        {{-- ログイン済みユーザーかつタブレットサイズより小さい画面用 --}}
        @if (Auth::guard('seller')->check() || Auth::guard('user')->check())
            <hamburger-menu-logged-in-component></hamburger-menu-logged-in-component>
        @else
            {{-- ゲストユーザーかつタブレットサイズより小さい画面はハンバーガーメニューを適用 --}}
            <hamburger-menu-component></hamburger-menu-component>
        @endif

    </div>
</header>
