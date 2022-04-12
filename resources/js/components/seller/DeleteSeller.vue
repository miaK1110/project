<template>
    <div>
        <loading-component :isLoading="this.isLoading"></loading-component>
        <div class="c-form">
            <div class="c-form__item-wrapper">
                <p class="u-pb__s">
                    退会ボタンを押すと、今後同じメールアドレスで店舗登録を行うことができなくなります。よろしければ、以下のボタンを押してください。
                </p>
                <button class="c-btn__danger" @click="userDelete">
                    退会する
                </button>
            </div>
            <div class="u-align__center u-pt__s">
                <a class="c-link__underline" href="/seller/home"
                    >マイページへ戻る</a
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DeleteSeller",
    data() {
        return { isLoading: false };
    },
    methods: {
        userDelete: function () {
            this.isLoading = true;
            axios
                .post("/seller/api/delete")
                .then((response) => {
                    this.isLoading = false;
                    if (response.status === 200) {
                        // 200ならトップページへ遷移
                        window.location.href = "/";
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    if (err.response.status === 401) {
                        // 認証エラーならログイン画面へ戻る
                        window.location.href = "/seller/login";
                    }
                    if (err.response.status === 500) {
                        // 500エラーなら500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
    },
};
</script>
