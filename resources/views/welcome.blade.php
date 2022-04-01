@extends('Layouts.app')

@section('title', 'haiki-share')

@section('content')

    <section class="l-main">
        <div class="l-main__main-visual">
            <img src="https://haiki-share-backet.s3.ap-northeast-1.amazonaws.com/common-img/main-visual.jpg"
                alt="main-visual-img">
            <div class="l-main__slogan">
                <h1>あのお弁当を、</h1>
                <h1>低価格で。</h1>
                <a class="c-btn__primary" href="/register">会員登録(無料)</a>
            </div>
        </div>
    </section>

    <section class="p-about">
        <div class="p-about-item">
            <p>『<span>haiki-share</span>』は、</p>
            <p>あなたが利用している</p><br />
            <p>コンビニのお弁当やおにぎりなどの</p><br />
            <p>食品を低価格で提供するサービスです。</p>
        </div>
    </section>

    <section class="p-about2">
        <div class="p-about2__wrapper">
            <h2>知っていますか？</h2>
            <div class="p-about2__text">
                <p>コンビニでは、1店舗あたり1日に10～15キロ
                    程度の食品を廃棄しています。
                    日本全体の食品ロスのうち約3ｰ5%は
                    コンビニからの廃棄物だと言われています。
                </p>
                <BR />
                <p>
                    しかし、その廃棄された物の中にはまだまだおいしく
                    食べれるものがたくさんあるのが現状。
                    このサービスを通して、
                    そのような食品を特別価格で手に入れましょう！</p>
            </div>
        </div>
    </section>

    <section class="p-about3">
        <div class="p-about3__title">
            <h2>どういう仕組みなの?</h2>
            <p>その疑問にお答えします!</p>
        </div>
        <div class="p-about3__wrapper">
            <div class="p-about3__img-container">
                <img src="https://haiki-share-backet.s3.ap-northeast-1.amazonaws.com/common-img/female-staff.png" />
            </div>
            <div class="p-about3__text-container">
                <h3>消費期限の前にある「販売期限」</h3>
                <p>コンビニで売っている食品には、「賞味期限」と「消費期限」の他に
                    「販売期限」というものが設定されています。これは「賞味期限・消費期限」よりもずっと手前に設定されており、
                    販売期限を過ぎたからといって品質や安全性に問題はありませんが
                    店頭に出すことはできなくなります。</p>
                <BR />
                <p>このサービスで販売期限を過ぎた食品の店頭販売の代わりを担うことで特別価格での食品販売を可能としています。</p>
            </div>
        </div>
    </section>

    <questions-component></questions-component>

    <section class="p-review">
        <h3>利用者様からのお声</h3>
        <div class="c-card">
            <div class="c-card__item">
                <p>
                    仕事が忙しくなかなか自炊ができない日々を
                    送っています。今まではほぼ毎日定価で
                    お弁当などを買っていましたがこのサイトを
                    知ってからはもう定価では買えません。
                    <BR /><BR />
                    もっと早くこのサイトを知りたかったです！
                </p>
            </div>
            <div class="c-card__item">
                <p>
                    最近テレビ・Youtubeで地球環境や、食品ロスの
                    話題を目にすることがよくあり、
                    私にも何かできることはないかな？
                    っと思っていたらこのサイトに出会いました。

                    地球にも家計にも優しいので今では
                    １週間に１回程度の頻度で
                    利用させていただいてとても満足しています！
                </p>
            </div>
            <div class="c-card__item">
                <p>
                    以前コンビニを利用した際、店員さんが
                    カゴいっぱいにお弁当を入れて捨てていたところを目撃し
                    もったいないと大変驚きました。
                    <br />
                    このサイトでもったいないを減らしつつ、浮いた食費を趣味に使えるのでとても助かっております。
                </p>
            </div>
        </div>
    </section>

    <div class="l-main__lower">
        <h3 class="l-main__lower-head">今すぐはじめましょう！</h3>
        <a class="c-btn__primary l-main__btn" href="/register">会員登録(無料)</a>
    </div>
@endsection
