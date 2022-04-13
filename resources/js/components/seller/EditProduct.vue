<template>
    <div>
        <loading-component :isLoading="this.isLoading"></loading-component>
        <div class="c-form">
            <div class="c-form__item-wrapper">
                <h3 class="c-form__title">商品編集ページ</h3>

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
                            :selected="category.id == category"
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
                            <p>変更する画像を選ぶ</p>
                            <input
                                id="product_img_file_path"
                                type="file"
                                name="product_img_file_path"
                                autocomplete="product_img_file_path"
                                autofocus
                                @change="onChangeFile"
                                ref="preview"
                            />
                        </div>
                    </label>
                    <p class="c-form__err-msg" v-if="errMessages.fileErr">
                        {{ errMessages.fileErr }}
                    </p>
                </div>
                <div class="c-form__preview" v-if="url">
                    <img :src="url" />
                </div>
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
                    class="c-btn__primary u-mb__s"
                    @click="editProduct"
                    :disabled="isLoading"
                >
                    編集する
                </button>
                <button
                    class="c-btn__danger"
                    @click="deleteProduct"
                    :disabled="isLoading"
                >
                    削除する
                </button>
            </div>
        </div>
    </div>
</template>

<script>
Vue.use(require("vue-moment"));
import moment from "moment";
export default {
    name: "EditProduct",
    data() {
        return {
            categoryList: {},
            id: "",
            seller: "",
            name: "",
            description: "",
            category: "",
            originalPrice: "",
            price: "",
            bestBeforeDate: "",
            file: "",
            url: "",
            showDeleteBtn: true,
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
    computed: {},
    methods: {
        getId() {
            // url取得
            const path = window.location.pathname;
            // セグメンツに分ける。結果 ['', 'product-detail', '4']
            const segments = path.split("/");
            // 3番目のセグメントを返す（商品ID）
            return segments[3];
        },
        getCategoryData() {
            axios
                .get("/api/getcategorylist")
                .then((response) => {
                    // console.log(response);
                    if (response.status === 200) {
                        this.categoryList = response.data.categoryList;
                    }
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
        getProductData() {
            const id = this.getId();
            axios
                .get("/seller/api/getproduct/" + id)
                .then((response) => {
                    const resData = response.data.data;
                    this.id = resData.id;
                    this.seller = resData.seller_id;
                    this.name = resData.product_name;
                    this.category = resData.category_id;
                    this.description = resData.description;
                    this.originalPrice = resData.original_price;
                    this.price = resData.price;
                    this.bestBeforeDate = resData.best_defore_date;
                    // 出力される日付がdatetimeなのでdatetime-localに変更
                    this.bestBeforeDate = moment(this.bestBeforeDate).format(
                        "YYYY-MM-DDTHH:mm"
                    );
                    this.url = resData.product_img_file_path;
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
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
        editProduct(e) {
            this.isLoading = true;
            // console.log(this.$refs.preview.files[0]);
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

            data.set("id", this.id);
            data.set("seller", this.seller);
            data.set("name", this.name);
            data.set("category", this.category);
            data.set("description", this.description);
            data.set("originalPrice", this.originalPrice);
            data.set("price", this.price);
            data.set("bestBeforeDate", this.bestBeforeDate);

            if (this.file !== "") {
                data.set("file", this.file);
                // console.log(data.get("file"));
            }

            axios
                .post("/seller/api/updateproduct", data)
                .then((response) => {
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
                        this.errMessages.fileErr =
                            "アップロードできる画像ファイルの大きさは10MBまでです";
                    }
                    if (err.response.status === 422) {
                        // バリデーションエラーの時
                        const error = err.response.data.errors;
                        // 各バリデーションに引っかかるとnullが入るのでリセット
                        if (!this.description) {
                            this.description = "";
                        }
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
        deleteProduct() {
            let data = new FormData();

            data.append("id", this.id);
            data.append("seller", this.seller);
            // 万が一、削除前に違うファイルが選択されていたら
            if (this.file !== "") {
                this.errMessages.fileErr =
                    "削除前に新しく画像を選ぶことはできません。ページを更新してください。";
                return false;
            }
            data.append("file", this.url);
            // console.log(data.get("id"));

            const confirm =
                window.confirm("この商品を削除してもよろしいですか?");

            if (confirm) {
                this.isLoading = true;
                axios
                    .post("/seller/api/deleteproduct", data)
                    .then((response) => {
                        this.isLoading = false;
                        // console.log(response);
                        if (response.status === 200) {
                            // status 200ならマイページへ戻る
                            window.location.href = "/seller/home";
                        }
                    })
                    .catch((err) => {
                        this.isLoading = false;
                        if (err.response.status === 500) {
                            // 500エラーページを表示
                            window.location.href = "/500";
                        }
                    });
            } else {
                return false;
            }
        },
    },
    created() {},
    mounted() {
        this.getCategoryData();
        this.getProductData();
    },
};
</script>
