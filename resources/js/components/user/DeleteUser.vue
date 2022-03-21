<template>
    <div class="c-form">
        <div class="c-form__item-wrapper">
            <p class="u-pb__s">
                退会ボタンを押すと、今後同じメールアドレスで店舗登録を行うことができなくなります。よろしければ、以下のボタンを押してください。
            </p>
            <button class="c-btn__danger" @click="userDelete">退会する</button>
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
                .post("http://localhost:8000/user/api/delete")
                .then((Response) => {
                    console.log(Response);
                    window.location.href = "/";
                })
                .catch((error) => {
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        console.log("response error");
                        console.log(error.response.status);
                        // console.log(error.response.headers);

                        const responseErr = error.response.data.errors;

                        if (error.response.status === 401) {
                        }
                        // if (responseErr.email) {
                        //   setApiError(responseErr.email);
                        // } else if (responseErr.password) {
                        //   setApiError(responseErr.password);
                        // }
                    } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the
                        // browser and an instance of
                        // http.ClientRequest in node.js
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
