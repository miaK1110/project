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
                .post("http://localhost:8000/seller/api/delete", 2)
                .then((Response) => {
                    this.isLoading = false;
                    window.location.href = "/";
                })
                .catch((error) => {
                    this.isLoading = false;
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        console.log("response error");
                        console.log(error.response.status);
                        // console.log(error.response.headers);

                        const responseErr = error.response.data.errors;

                        if (error.response.status === 401) {
                        }
                    } else if (error.request) {
                        console.log("request error");
                        console.log(error.request);
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log("Error", error.message);
                    }
                    console.log(error.config);
                });
        },
    },
};
</script>
