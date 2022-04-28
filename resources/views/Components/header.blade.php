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
                <li class="l-header__menu-item"><a href="https://haikishare.com" class="l-header__menu-link">トップ</a></li>
                <span class="l-header__menu-accent">|</span>
                <li class="l-header__menu-item"><a href="/products-list" class="l-header__menu-link">商品一覧</a></li>
                {{-- ログインしているユーザーが店舗ユーザーの時 --}}
                @if (Auth::guard('seller')->check())
                    <span class="l-header__menu-accent">|</span>
                    <li class="l-header__menu-item"><a href="https://haikishare.com/seller/home"
                            class="l-header__menu-link">マイページ</a></li>
                    <span class="l-header__menu-accent">|</span>
                    <li class="l-header__menu-item"><a href="https://haikishare.com/seller/logout"
                            class="l-header__menu-link">ログアウト</a></li>
                    {{-- ログインしているユーザーが一般ユーザーの時 --}}
                @elseif(Auth::guard('user')->check())
                    <span class="l-header__menu-accent">|</span>
                    <li class="l-header__menu-item"><a href="https://haikishare.com/user/home"
                            class="l-header__menu-link">マイページ</a></li>
                    <span class="l-header__menu-accent">|</span>
                    <li class="l-header__menu-item"><a href="https://haikishare.com/user/logout"
                            class="l-header__menu-link">ログアウト</a></li>
                    {{-- ゲストユーザーの時 --}}
                @else
                    <span class="l-header__menu-accent">|</span>
                    <li class="l-header__menu-item"><a href="/login" class="l-header__menu-link">ログイン</a></li>
                    <span class="l-header__menu-accent">|</span>
                    <li class="l-header__menu-item"><a href="/register" class="l-header__menu-link">会員登録</a></li>
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
