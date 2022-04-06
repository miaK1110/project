<template>
    <div>
        <loading-component :isLoading="this.isLoading"></loading-component>
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
                </div>

                <div class="c-form__item">
                    <label for="branch" class="c-form__label">
                        <span class="c-tag__require">必須</span>
                        支店名
                    </label>
                    <input
                        id="branch"
                        type="text"
                        class="c-form__control"
                        name="branch"
                        required
                        autofocus
                        v-model="branch"
                    />
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
                </div>

                <div class="c-form__item">
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
                </div>
                <!-- エラーメッセージ -->
                <div class="u-pb__m">
                    <p class="c-form__err-msg" v-if="errMessages.emailErr">
                        {{ errMessages.emailErr }}
                    </p>
                    <p class="c-form__err-msg" v-if="errMessages.branchErr">
                        {{ errMessages.branchErr }}
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

                <button class="c-btn__primary" @click="editInfo">
                    編集する
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditSellerInfo",
    data() {
        return {
            prefData: {},
            id: "",
            email: "",
            branch: "",
            postcode: "",
            pref: "",
            city: "",
            address: "",
            phone: "",
            errMessages: {
                emailErr: "",
                branchErr: "",
                postcodeErr: "",
                prefErr: "",
                cityErr: "",
                addressErr: "",
                phoneErr: "",
            },
            isLoading: false,
        };
    },
    methods: {
        getSellerAndPrefData() {
            axios
                .get("/seller/api/getsellerandprefdata")
                .then((response) => {
                    // console.log(response);
                    if (response.status === 200) {
                        this.prefData = response.data.prefData;

                        const sellerData = response.data.sellerData;

                        this.id = sellerData.id;
                        this.email = sellerData.email;
                        this.branch = sellerData.branch;
                        this.pref = sellerData.prefecture;
                        this.postcode = sellerData.postcode;
                        this.city = sellerData.city;
                        this.address = sellerData.address;
                        this.phone = sellerData.phone;
                    }
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        editInfo() {
            this.isLoading = true;
            // エラーメッセージをリセット
            this.errMessages = {
                emailErr: "",
                branchErr: "",
                postcodeErr: "",
                prefErr: "",
                cityErr: "",
                addressErr: "",
                phoneErr: "",
            };
            let data = new FormData();

            data.append("id", this.id);
            data.append("email", this.email);
            data.append("branch", this.branch);
            data.append("postcode", this.postcode);
            data.append("pref", this.pref);
            data.append("city", this.city);
            data.append("address", this.address);
            data.append("phone", this.phone);
            // console.log(...data.entries());

            axios
                .post("/seller/api/editsellerinfo", data)
                .then((response) => {
                    // console.log(response)
                    this.isLoading = false;
                    if (response.status === 200) {
                        window.location.href = "/seller/home";
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    const error = err.response.data.errors;
                    if (error.email) {
                        this.errMessages.emailErr = error.email[0];
                    } else if (error.branch) {
                        this.errMessages.branchErr = error.branch[0];
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
                    // ステータスが500ならマイページへ戻る
                    if (err.status === 500) {
                        window.location.href = "/seller/home";
                    }
                });
        },
    },
    created() {
        this.getSellerAndPrefData();
    },
};
</script>
