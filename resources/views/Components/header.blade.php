<header class="l-header">
    <div class="l-header__wrapper">
        <div class="l-header__img-container">
            <a href="/">
                <img src={{ asset('img/logo-small.png') }} alt="ロゴ画像" />
            </a>
        </div>
        <nav class="l-header__menu">
            <ul>
                <li><a href="http://localhost:8000/">トップ</a></li>
                <span>|</span>
                <li><a href="/products-list">商品一覧</a></li>
                @guest
                    <span>|</span>
                    <li><a href="/login">ログイン</a></li>
                    <span>|</span>
                    <li><a href="/register">会員登録</a></li>
                @endguest
                @auth
                    @if (Auth::guard('user')->user())
                        <span>|</span>
                        <li><a href="http://localhost:8000/user/home">マイページ</a></li>
                        <span>|</span>
                        <li><a href="http://localhost:8000/user/logout">ログアウト</a></li>
                    @elseif(Auth::guard('seller')->user())
                        <span>|</span>
                        <li><a href="http://localhost:8000/seller/home">マイページ</a></li>
                        <span>|</span>
                        <li><a href="http://localhost:8000/seller/logout">ログアウト</a></li>
                    @endif
                @endauth
            </ul>
        </nav>
        {{-- タブレットサイズより小さい画面はハンバーガーメニューを適用 --}}
        @guest
            <hamburger-menu-component></hamburger-menu-component>
        @endguest
        {{-- ログイン済みユーザーかつタブレットサイズより小さい画面用 --}}
        @auth
            <hamburger-menu-logged-in-component></hamburger-menu-logged-in-component>
        @endauth
    </div>
</header>
