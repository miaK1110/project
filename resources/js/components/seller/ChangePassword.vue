<template>
    <div class="c-form">
        <div class="c-form__item-wrapper">
            <h3 class="c-form__title">パスワード編集</h3>

            <div class="c-form__item">
                <label for="currentPassword" class="c-form__label">
                    現在使用中のパスワード
                </label>
                <input
                    id="currentPassword"
                    type="password"
                    class="c-form__control"
                    name="currentPassword"
                    required
                    autofocus
                    v-model="currentPassword"
                />
                <p
                    class="c-form__err-msg"
                    v-if="errMessages.currentPasswordErr"
                >
                    {{ errMessages.currentPasswordErr }}
                </p>
            </div>

            <div class="c-form__item">
                <label for="newPassword" class="c-form__label">
                    新しいパスワード
                </label>
                <input
                    id="newPassword"
                    type="password"
                    class="c-form__control"
                    name="newPassword"
                    required
                    autofocus
                    v-model="newPassword"
                />
                <p class="c-form__err-msg" v-if="errMessages.newPasswordErr">
                    {{ errMessages.newPasswordErr }}
                </p>
            </div>

            <div class="c-form__item">
                <label for="rePassword" class="c-form__label">
                    新しいパスワード(再確認)
                </label>
                <input
                    id="rePassword"
                    type="password"
                    class="c-form__control"
                    name="rePassword"
                    required
                    autofocus
                    v-model="rePassword"
                />
                <p class="c-form__err-msg" v-if="errMessages.rePasswordErr">
                    {{ errMessages.rePasswordErr }}
                </p>
            </div>
            <button class="c-btn__primary" @click="changePassword">
                パスワードを更新する
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ChangePassword",
    data() {
        return {
            id: "",
            currentPassword: "",
            newPassword: "",
            rePassword: "",
            errMessages: {
                currentPasswordErr: "",
                newPasswordErr: "",
            },
        };
    },
    methods: {
        getIdAndRole() {
            axios
                .get("/api/getrole")
                .then((response) => {
                    // console.log(response);
                    if (response.status === 200) {
                        this.id = response.data.id;
                    }
                })
                .catch((err) => {
                    // 情報取得できていないならマイページへ戻る
                    window.location.href = "/seller/home";
                });
        },
        changePassword() {
            // エラーメッセージをリセット
            this.errMessages = {
                currentPasswordErr: "",
                newPasswordErr: "",
            };

            // もし新しいパスワードと確認用のパスワードが違うならエラーを出す
            if (this.newPassword !== this.rePassword) {
                this.errMessages.newPasswordErr =
                    "新しいパスワードと再確認用のパスワードが一致しません";
                return false;
            }

            // dataに情報を格納
            let data = new FormData();
            data.append("id", this.id);
            data.append("new_password", this.newPassword);
            data.append("current_password", this.currentPassword);

            axios
                .post("/seller/api/changepassword", data)
                .then((response) => {
                    // console.log(response);
                    if (response.status === 200) {
                        // status 200ならマイページへ戻る
                        window.location.href = "/seller/home";
                    }
                })
                .catch((err) => {
                    const error = err.response.data.errors;
                    // バリデーションエラー
                    if (error.current_password) {
                        this.errMessages.currentPasswordErr =
                            error.current_password[0];
                    } else if (error.new_password) {
                        this.errMessages.newPasswordErr = error.new_password[0];
                    } else {
                        // バリデーションエラーじゃないエラーならマイページへ戻る
                        window.location.href = "/seller/home";
                    }
                });
        },
    },
    created() {
        this.getIdAndRole();
    },
};
</script>
