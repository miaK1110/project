<template>
    <div class="c-form">
        <div class="c-form__item-wrapper">
            <p class="u-pb__s">
                退会ボタンを押すと、今後同じメールアドレスで店舗登録を行うことができなくなります。よろしければ、以下のボタンを押してください。
            </p>
            <button class="c-btn--danger" @click="userDelete">退会する</button>
        </div>
        <div class="u-align__center u-pt__s">
            <a class="c-link__underline" href="/user/home">マイページへ戻る</a>
        </div>
    </div>
</template>

<script>
export default {
    name: "DeleteUser",
    methods: {
        userDelete: function () {
            axios
                .post("/user/api/delete")
                .then((res) => {
                    window.location.href = "/";
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
    },
};
</script>
