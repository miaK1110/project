<template>
    <div>
        <loading-component :isLoading="this.isLoading"></loading-component>
        <div class="c-form">
            <div class="c-form__item-wrapper">
                <h3 class="c-form__title">商品登録ページ</h3>

                <div class="c-form__item">
                    <label for="product_name" class="c-form__label">
                        <span class="c-tag__require">必須</span>
                        商品名
                    </label>
                    <input
                        id="product_name"
                        type="text"
                        class="c-form__control"
                        name="product_name"
                        required
                        autocomplete="product_name"
                        autofocus
                        v-model="name"
                    />
                    <p class="c-form__err-msg" v-if="errMessages.nameErr">
                        {{ errMessages.nameErr }}
                    </p>
                </div>
                <div class="c-form__item">
                    <label for="category_id" class="c-form__label">
                        <span class="c-tag__require">必須</span>
                        商品カテゴリー
                    </label>
                    <select
                        id="category_id"
                        class="c-form__control"
                        name="category_id"
                        autocomplete="category_id"
                        autofocus
                        v-model="category"
                    >
                        <option value="" hidden>選択してください</option>
                        <option
                            v-for="category in categoryList"
                            v-bind:value="category.id"
                            v-bind:key="category.id"
                        >
                            {{ category.category_name }}
                        </option>
                    </select>
                    <p class="c-form__err-msg" v-if="errMessages.categoryErr">
                        {{ errMessages.categoryErr }}
                    </p>
                </div>
                <div class="c-form__item">
                    <label for="description" class="c-form__label">
                        <span class="c-tag__optional">任意</span>
                        商品説明
                    </label>
                    <textarea
                        id="description"
                        type="text"
                        class="c-form__control"
                        name="description"
                        autocomplete="description"
                        autofocus
                        v-model="description"
                    />
                    <p
                        class="c-form__err-msg"
                        v-if="errMessages.descriptionErr"
                    >
                        {{ errMessages.descriptionErr }}
                    </p>
                </div>
                <div class="c-form__item">
                    <label for="original-price" class="c-form__label">
                        <span class="c-tag__require">必須</span>
                        定価(税込み)
                    </label>
                    <input
                        id="original-price"
                        type="number"
                        class="c-form__control"
                        name="original-price"
                        required
                        autocomplete="original-price"
                        autofocus
                        min="0"
                        inputmode="numeric"
                        v-model="originalPrice"
                        @keydown.69.prevent
                    />
                    <p
                        class="c-form__err-msg"
                        v-if="errMessages.originalPriceErr"
                    >
                        {{ errMessages.originalPriceErr }}
                    </p>
                </div>
                <div class="c-form__item">
                    <label for="price" class="c-form__label">
                        <span class="c-tag__require">必須</span>
                        販売価格(税込み)
                    </label>
                    <input
                        id="price"
                        type="number"
                        class="c-form__control"
                        name="price"
                        min="0"
                        required
                        autocomplete="price"
                        autofocus
                        inputmode="numeric"
                        v-model="price"
                        @keydown.69.prevent
                    />
                    <p class="c-form__err-msg" v-if="errMessages.priceErr">
                        {{ errMessages.priceErr }}
                    </p>
                </div>
                <div class="c-form__item">
                    <label for="best-before-date" class="c-form__label">
                        <span class="c-tag__require">必須</span>
                        賞味期限
                    </label>
                    <input
                        id="best_before_date"
                        type="datetime-local"
                        class="c-form__control"
                        name="best-before-date"
                        required
                        autocomplete="best-before-date"
                        autofocus
                        v-model="bestBeforeDate"
                    />
                    <p
                        class="c-form__err-msg"
                        v-if="errMessages.bestBeforeDateErr"
                    >
                        {{ errMessages.bestBeforeDateErr }}
                    </p>
                </div>
                <div class="c-form__item">
                    <label for="product_img_file_path" class="c-form__label">
                        <div class="c-form__label--file">
                            <span class="c-tag__require">必須</span>
                        </div>
                        商品写真
                        <div class="c-form__control--file">
                            <p class="c-form__file-text">画像を選ぶ</p>
                            <input
                                id="product_img_file_path"
                                type="file"
                                name="product_img_file_path"
                                required
                                autocomplete="product_img_file_path"
                                autofocus
                                @change="onChangeFile"
                                ref="preview"
                            />
                        </div>
                        <p class="c-form__err-msg" v-if="errMessages.fileErr">
                            {{ errMessages.fileErr }}
                        </p>
                    </label>
                </div>
                <div class="c-form__preview" v-if="url"><img :src="url" /></div>
                <!-- エラーメッセージ -->
                <div class="c-form__errs-container u-pb__m">
                    <p class="c-form__err-msg" v-if="errMessages.nameErr">
                        {{ errMessages.nameErr }}
                    </p>
                    <p class="c-form__err-msg" v-if="errMessages.categoryErr">
                        {{ errMessages.categoryErr }}
                    </p>
                    <p
                        class="c-form__err-msg"
                        v-if="errMessages.descriptionErr"
                    >
                        {{ errMessages.descriptionErr }}
                    </p>
                    <p
                        class="c-form__err-msg"
                        v-if="errMessages.originalPriceErr"
                    >
                        {{ errMessages.originalPriceErr }}
                    </p>
                    <p class="c-form__err-msg" v-if="errMessages.priceErr">
                        {{ errMessages.priceErr }}
                    </p>
                    <p
                        class="c-form__err-msg"
                        v-if="errMessages.bestBeforeDateErr"
                    >
                        {{ errMessages.bestBeforeDateErr }}
                    </p>
                    <p class="c-form__err-msg" v-if="errMessages.fileErr">
                        {{ errMessages.fileErr }}
                    </p>
                </div>
                <!-- エラーメッセージここまで -->
                <button
                    class="c-btn--primary--higher"
                    @click="createProduct"
                    :disabled="isLoading"
                >
                    登録する
                </button>
            </div>
        </div>
    </div>
</template>

<script>
Vue.use(require("vue-moment"));
export default {
    name: "CreateProduct",
    data() {
        return {
            categoryList: {},
            name: "",
            description: "",
            category: "",
            originalPrice: "",
            price: "",
            bestBeforeDate: "",
            file: "",
            url: "",
            errMessages: {
                nameErr: "",
                descriptionErr: "",
                categoryErr: "",
                originalPriceErr: "",
                priceErr: "",
                bestBeforeDateErr: "",
                fileErr: "",
            },
            isLoading: false,
        };
    },
    methods: {
        // ファイル選択してる時に実行されるメソッド
        onChangeFile(e) {
            this.errMessages.fileErr = "";

            // もしファイルが未選択なら中断する
            if (e.target.files.length === 0) {
                this.reset();
                return false;
            }
            // もしファイルが画像ではなかったら処理を中断する
            if (!e.target.files[0].type.match("image.*")) {
                this.reset();
                this.errMessages.fileErr = "画像ファイルを選択してください";
                return false;
            }

            const reader = new FileReader();
            // 画像をプレビューさせる
            reader.onload = (e) => {
                this.url = e.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
            this.file = e.target.files[0];
        },
        reset() {
            // ファイルアップロードでバリデーションにひっかかった時に
            // リセットする処理
            this.file = "";
            this.url = "";
            this.$el.querySelector('input[type="file"]').value = null;
            if (!this.description) {
                this.description = "";
            }
        },
        createProduct(e) {
            this.isLoading = true;

            // エラーメッセージをクリアに
            this.errMessages = {
                nameErr: "",
                descriptionErr: "",
                categoryErr: "",
                originalPriceErr: "",
                priceErr: "",
                bestBeforeDateErr: "",
                fileErr: "",
            };

            let data = new FormData();

            data.append("name", this.name);
            data.append("category", this.category);
            data.append("description", this.description);
            data.append("originalPrice", this.originalPrice);
            data.append("price", this.price);
            data.append("bestBeforeDate", this.bestBeforeDate);
            data.append("file", this.file);

            axios
                .post("/seller/api/addproduct", data)
                .then((response) => {
                    console.log(response);
                    this.isLoading = false;
                    if (response.status === 200) {
                        // status 201ならマイページへ戻る
                        window.location.href = "/seller/home";
                    }
                })
                .catch((err) => {
                    this.isLoading = false;

                    if (err.response.status === 413) {
                        // Payload Too Largeの時
                        this.errMessages.fileErr = "画像ファイルが大きすぎます";
                    }
                    if (err.response.status === 422) {
                        // バリデーションエラーの時
                        const error = err.response.data.errors;
                        if (error.name) {
                            this.errMessages.nameErr = error.name[0];
                        } else if (error.category) {
                            this.errMessages.categoryErr = error.category[0];
                        } else if (error.description) {
                            this.errMessages.descriptionErr =
                                error.description[0];
                        } else if (error.originalPrice) {
                            this.errMessages.originalPriceErr =
                                error.originalPrice[0];
                        } else if (error.price) {
                            this.errMessages.priceErr = error.price[0];
                        } else if (error.bestBeforeDate) {
                            this.errMessages.bestBeforeDateErr =
                                error.bestBeforeDate[0];
                        } else if (error.file) {
                            this.errMessages.fileErr = error.file[0];
                        }
                    }
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
    },
    created() {
        axios
            .get("/api/getcategorylist")
            .then((response) => {
                if (response.status === 200) {
                    this.categoryList = response.data.categoryList;
                }
            })
            .catch((err) => {
                // カテゴリー取得できていない場合
                if (err.response.status === 500) {
                    // 500エラーページを表示
                    window.location.href = "/500";
                }
            });
    },
};
</script>
