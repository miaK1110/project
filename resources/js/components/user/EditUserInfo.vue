<template>
    <div class="c-form">
        <div class="c-form__item-wrapper">
            <h3 class="c-form__title">登録情報編集ページ</h3>

            <div class="c-form__item">
                <label for="email" class="c-form__label">
                    <span class="c-tag__require">必須</span>
                    メールアドレス
                </label>
                <input
                    id="email"
                    type="email"
                    class="c-form__control"
                    name="email"
                    required
                    autofocus
                    v-model="email"
                />
                <p class="c-form__err-msg" v-if="errMessages.emailErr">
                    {{ errMessages.emailErr }}
                </p>
            </div>
            <div class="c-form__item">
                <label for="familyName" class="c-form__label">
                    <span class="c-tag__require">必須</span>
                    名字
                </label>
                <input
                    id="familyName"
                    type="text"
                    class="c-form__control"
                    name="familyName"
                    required
                    autofocus
                    v-model="familyName"
                />
                <p class="c-form__err-msg" v-if="errMessages.familyNameErr">
                    {{ errMessages.familyNameErr }}
                </p>
            </div>

            <div class="c-form__item">
                <label for="firstName" class="c-form__label">
                    <span class="c-tag__require">必須</span>
                    名前
                </label>
                <input
                    id="firstName"
                    type="text"
                    class="c-form__control"
                    name="firstName"
                    required
                    autofocus
                    v-model="firstName"
                />
                <p class="c-form__err-msg" v-if="errMessages.firstNameErr">
                    {{ errMessages.firstNameErr }}
                </p>
            </div>

            <div class="c-form__item">
                <label for="postcode" class="c-form__label">
                    <span class="c-tag__require">必須</span>
                    郵便番号
                </label>
                <input
                    id="postcode"
                    type="text"
                    class="c-form__control"
                    name="postcode"
                    required
                    autofocus
                    v-model="postcode"
                />
                <p class="c-form__err-msg" v-if="errMessages.postcodeErr">
                    {{ errMessages.postcodeErr }}
                </p>
            </div>
            <div class="c-form__item">
                <label for="pref" class="c-form__label">
                    <span class="c-tag__require">必須</span>
                    都道府県
                </label>
                <select
                    id="pref"
                    class="c-form__control"
                    name="pref"
                    autocomplete="pref"
                    autofocus
                    v-model="pref"
                >
                    <option value="" hidden>選択してください</option>
                    <option
                        v-for="(val, key, index) in prefData"
                        v-bind:value="val"
                        v-bind:key="index"
                        :selected="key == pref"
                    >
                        {{ val }}
                    </option>
                </select>
                <p class="c-form__err-msg" v-if="errMessages.prefErr">
                    {{ errMessages.prefErr }}
                </p>
            </div>
            <div class="c-form__item">
                <label for="city" class="c-form__label">
                    <span class="c-tag__require">必須</span>
                    市町村区
                </label>
                <input
                    id="city"
                    type="text"
                    class="c-form__control"
                    name="city"
                    required
                    autofocus
                    v-model="city"
                />
                <p class="c-form__err-msg" v-if="errMessages.cityErr">
                    {{ errMessages.cityErr }}
                </p>
            </div>

            <div class="c-form__item">
                <label for="address" class="c-form__label">
                    <span class="c-tag__require">必須</span>
                    それ以降の住所
                </label>
                <input
                    id="address"
                    type="text"
                    class="c-form__control"
                    name="address"
                    autocomplete="address"
                    autofocus
                    v-model="address"
                />
                <p class="c-form__err-msg" v-if="errMessages.addressErr">
                    {{ errMessages.addressErr }}
                </p>
            </div>

            <div class="c-form__item u-pb__m">
                <label for="phone" class="c-form__label">
                    <span class="c-tag__require">必須</span>
                    電話番号
                </label>
                <input
                    id="phone"
                    type="text"
                    class="c-form__control"
                    required
                    autofocus
                    v-model="phone"
                />
                <p class="c-form__err-msg" v-if="errMessages.phoneErr">
                    {{ errMessages.phoneErr }}
                </p>
            </div>

            <!-- エラーメッセージ -->
            <div class="c-form__errs-container u-pb__m">
                <p class="c-form__err-msg" v-if="errMessages.emailErr">
                    {{ errMessages.emailErr }}
                </p>
                <p class="c-form__err-msg" v-if="errMessages.familyNameErr">
                    {{ errMessages.familyNameErr }}
                </p>
                <p class="c-form__err-msg" v-if="errMessages.firstNameErr">
                    {{ errMessages.firstNameErr }}
                </p>
                <p class="c-form__err-msg" v-if="errMessages.postcodeErr">
                    {{ errMessages.postcodeErr }}
                </p>
                <p class="c-form__err-msg" v-if="errMessages.prefErr">
                    {{ errMessages.prefErr }}
                </p>
                <p class="c-form__err-msg" v-if="errMessages.cityErr">
                    {{ errMessages.cityErr }}
                </p>
                <p class="c-form__err-msg" v-if="errMessages.addressErr">
                    {{ errMessages.addressErr }}
                </p>
                <p class="c-form__err-msg" v-if="errMessages.phoneErr">
                    {{ errMessages.phoneErr }}
                </p>
            </div>
            <!-- エラーメッセージここまで -->
            <button class="c-btn--primary--higher" @click="editInfo">
                編集する
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditUserInfo",
    data() {
        return {
            prefData: {},
            id: "",
            email: "",
            firstName: "",
            familyName: "",
            postcode: "",
            pref: "",
            city: "",
            address: "",
            phone: "",
            errMessages: {
                emailErr: "",
                familyNameErr: "",
                firstNameErr: "",
                postcodeErr: "",
                prefErr: "",
                cityErr: "",
                addressErr: "",
                phoneErr: "",
            },
        };
    },
    methods: {
        getUserAndPrefData() {
            axios
                .get("/user/api/getuserandprefdata")
                .then((response) => {
                    if (response.status === 200) {
                        this.prefData = response.data.prefData;

                        const userData = response.data.userData;
                        this.id = userData.id;
                        this.email = userData.email;
                        this.firstName = userData.first_name;
                        this.familyName = userData.family_name;
                        this.postcode = userData.postcode;
                        this.pref = userData.prefecture;
                        this.city = userData.city;
                        this.address = userData.address;
                        this.phone = userData.phone;
                    }
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
        editInfo() {
            // エラーメッセージをリセット
            this.errMessages = {
                emailErr: "",
                familyNameErr: "",
                firstNameErr: "",
                postcodeErr: "",
                prefErr: "",
                cityErr: "",
                addressErr: "",
                phoneErr: "",
            };

            let data = new FormData();

            data.append("id", this.id);
            data.append("email", this.email);
            data.append("family_name", this.familyName);
            data.append("first_name", this.firstName);
            data.append("postcode", this.postcode);
            data.append("pref", this.pref);
            data.append("city", this.city);
            data.append("address", this.address);
            data.append("phone", this.phone);

            axios
                .post("/user/api/edituserinfo", data)
                .then((res) => {
                    if (res.status === 200) {
                        // status 200ならマイページへ戻る
                        window.location.href = "/user/home";
                    }
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                    if (err.response.status === 422) {
                        const error = err.response.data.errors;
                        if (error.email) {
                            this.errMessages.emailErr = error.email[0];
                        } else if (error.family_name) {
                            this.errMessages.familyNameErr =
                                error.family_name[0];
                        } else if (error.first_name) {
                            this.errMessages.firstNameErr = error.first_name[0];
                        } else if (error.postcode) {
                            this.errMessages.postcodeErr = error.postcode[0];
                        } else if (error.pref) {
                            this.errMessages.prefErr = error.pref[0];
                        } else if (error.city) {
                            this.errMessages.cityErr = error.city[0];
                        } else if (error.address) {
                            this.errMessages.addressErr = error.address[0];
                        } else if (error.phone) {
                            this.errMessages.phoneErr = error.phone[0];
                        }
                    }
                });
        },
    },
    created() {
        this.getUserAndPrefData();
    },
};
</script>
