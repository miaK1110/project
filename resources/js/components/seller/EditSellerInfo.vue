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
                    <p class="c-form__err-msg" v-if="errMessages.emailErr">
                        {{ errMessages.emailErr }}
                    </p>
                </div>

                <div class="c-form__item">
                    <label for="company" class="c-form__label">
                        <span class="c-tag__require">必須</span>
                        企業名
                    </label>
                    <select
                        id="company"
                        class="c-form__control"
                        name="company"
                        autocomplete="company"
                        autofocus
                        v-model="company"
                    >
                        <option value="" hidden>選択してください</option>
                        <option
                            v-for="(val, key, index) in companyData"
                            v-bind:value="key + 1"
                            v-bind:key="index"
                            :selected="key == company"
                        >
                            {{ val }}
                        </option>
                    </select>
                    <p class="c-form__err-msg" v-if="errMessages.companyErr">
                        {{ errMessages.companyErr }}
                    </p>
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
                    <p class="c-form__err-msg" v-if="errMessages.branchErr">
                        {{ errMessages.branchErr }}
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
                    <p class="c-form__err-msg" v-if="errMessages.phoneErr">
                        {{ errMessages.phoneErr }}
                    </p>
                </div>
                <!-- エラーメッセージ -->
                <div class="c-form__errs_container u-pb__m">
                    <p class="c-form__err-msg" v-if="errMessages.emailErr">
                        {{ errMessages.emailErr }}
                    </p>
                    <p class="c-form__err-msg" v-if="errMessages.companyErr">
                        {{ errMessages.companyErr }}
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

                <button class="c-btn--primary--higher" @click="editInfo">
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
            companyData: {},
            prefData: {},
            id: "",
            email: "",
            company: "",
            branch: "",
            postcode: "",
            pref: "",
            city: "",
            address: "",
            phone: "",
            errMessages: {
                emailErr: "",
                companyErr: "",
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
                    if (response.status === 200) {
                        this.companyData = response.data.companyData;
                        this.prefData = response.data.prefData;
                        const sellerData = response.data.sellerData;

                        this.id = sellerData.id;
                        this.email = sellerData.email;
                        this.company = sellerData.company;
                        this.branch = sellerData.branch;
                        this.pref = sellerData.prefecture;
                        this.postcode = sellerData.postcode;
                        this.city = sellerData.city;
                        this.address = sellerData.address;
                        this.phone = sellerData.phone;
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
            this.isLoading = true;
            // エラーメッセージをリセット
            this.errMessages = {
                emailErr: "",
                companyErr: "",
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
            data.append("company", this.company);
            data.append("branch", this.branch);
            data.append("postcode", this.postcode);
            data.append("pref", this.pref);
            data.append("city", this.city);
            data.append("address", this.address);
            data.append("phone", this.phone);

            axios
                .post("/seller/api/editsellerinfo", data)
                .then((response) => {
                    this.isLoading = false;
                    if (response.status === 200) {
                        window.location.href = "/seller/home";
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                    if (err.response.status === 422) {
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
                    }
                });
        },
    },
    created() {
        this.getSellerAndPrefData();
    },
};
</script>
