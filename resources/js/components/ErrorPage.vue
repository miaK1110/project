<template>
    <div class="c-error-page">
        <h2 class="c-error-page__title">500エラー</h2>
        <p class="c-error-page__message">
            申し訳ありません。現在このサイトがメンテナンス中あるいはエラーが発生している為ページを表示、処理を実行することができません。
        </p>
        <a :href="url" class="c-link__underline">前のページに戻る</a>
    </div>
</template>

<script>
export default {
    name: "ErrorPage",
    props: {
        url: String,
    },
};
</script>
