<template>
    <div>
        <loading-component :isLoading="this.isLoading"></loading-component>
        <div class="c-home">
            <h3 class="c-home__title">ユーザーマイページ</h3>
            <div class="c-home__menu">
                <a class="c-home__menu-item" href="edit-user"
                    >ユーザー情報を編集する</a
                >
                <a class="c-home__menu-item" href="./change-password"
                    >パスワード変更</a
                >
                <a class="c-home__menu-item" href="./logout">ログアウト</a>
                <a class="c-home__menu-item" href="./delete">退会する</a>
            </div>
            <p class="u-pb__m">購入した商品一覧</p>
            <p class="c-form__err-msg" v-if="emptyMessages.purchasedProducts">
                {{ emptyMessages.purchasedProducts }}
            </p>
            <div
                class="p-product-list__list-container"
                v-if="purchasedProducts"
            >
                <div
                    class="p-product-list__list-item"
                    v-for="(productdata, index) in purchasedProducts"
                    v-bind:key="index"
                >
                    <a
                        :href="url(productdata.id)"
                        class="p-product-list__product-link c-link__underline"
                    >
                        <div class="p-product-list__img-box">
                            <img
                                :src="productdata.product_img_file_path"
                                alt="商品の画像"
                            />
                        </div>

                        <p class="p-product-list__name">
                            {{ productdata.product_name }}
                        </p>
                    </a>
                    <s class="p-product-list__original-price"
                        >{{ productdata.original_price }}円(税込)</s
                    >
                    <p class="p-product-list__price">
                        {{ productdata.price }}円(税込)
                    </p>
                    <button
                        class="p-product-list__button-box--cancel"
                        @click="cancelPurchase(productdata.id)"
                    >
                        購入をキャンセル
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HomeUser",
    data() {
        return {
            purchasedProducts: [],
            emptyMessages: {
                purchasedProducts: "",
            },
            isLoading: false,
        };
    },
    methods: {
        url(pid) {
            const url = "/product-detail/" + pid;
            return url;
        },
        getAllPurchasedProducts() {
            axios
                .get("/user/api/getallpurchasedproducts")
                .then((response) => {
                    // console.log(response);
                    this.purchasedProducts = response.data.data;
                    if (this.purchasedProducts.length == 0) {
                        this.emptyMessages.purchasedProducts =
                            "表示できる商品がありません";
                        return false;
                    }
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
        cancelPurchase(id) {
            this.isLoading = true;
            let data = new FormData();

            data.append("id", id);

            axios
                .post("/user/api/cancelpurchase", data)
                .then((response) => {
                    this.isLoading = false;
                    if (response.status === 200) {
                        // status 200ならマイページへ戻る
                        window.location.reload();
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
    },
    created() {
        this.getAllPurchasedProducts();
    },
};
</script>
