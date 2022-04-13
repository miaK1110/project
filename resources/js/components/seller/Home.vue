<template>
    <div class="c-home">
        <h3 class="c-home__title">店舗マイページ</h3>
        <div class="c-home__menu">
            <a class="c-home__menu-item" href="./create">商品を出品</a>
            <a class="c-home__menu-item" href="./edit-seller">店舗情報を編集</a>
            <a class="c-home__menu-item" href="./change-password"
                >パスワード変更</a
            >
            <a class="c-home__menu-item" href="./logout">ログアウト</a>
            <a class="c-home__menu-item" href="./delete">退会</a>
        </div>
        <div class="p-product-list__menu">
            <p class="p-product-list__menu-title">登録した商品一覧</p>
            <a
                class="c-link__underline"
                href="./products-list"
                v-if="!this.sellingProducts.length == 0"
                >全件表示</a
            >
        </div>
        <p class="c-form__err-msg" v-if="emptyMessages.sellingProducts">
            {{ emptyMessages.sellingProducts }}
        </p>
        <div class="p-product-list__list-container" v-if="sellingProducts">
            <div
                class="p-product-list__list-item"
                v-for="(productdata, index) in sellingProducts"
                v-bind:key="index"
            >
                <a
                    :href="url(productdata.id)"
                    class="p-product-list__product-link c-link__underline"
                >
                    <div class="p-product-list__img-box">
                        <img
                            :src="productdata.product_img_file_path"
                            @error="noImage"
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
                <p class="p-product-list__price u-mb__s">
                    {{ productdata.price }}円(税込)
                </p>
                <button
                    class="p-product-list__button-box--edit"
                    v-if="productdata.is_sold === 0"
                >
                    <a :href="editUrl(productdata.id)">編集</a>
                </button>
            </div>
        </div>
        <div class="p-product-list__menu">
            <p class="p-product-list__menu-title">購入された商品一覧</p>
            <a
                class="c-link__underline"
                href="./sold-products-list"
                v-if="!this.soldProducts.length == 0"
                >全件表示</a
            >
        </div>
        <p class="c-form__err-msg u-mb__m" v-if="emptyMessages.soldProducts">
            {{ emptyMessages.soldProducts }}
        </p>
        <div class="p-product-list__list-container" v-if="soldProducts.length">
            <div
                class="p-product-list__list-item"
                v-for="(productdata, index) in soldProducts"
                v-bind:key="index"
            >
                <a
                    :href="url(productdata.id)"
                    class="p-product-list__product-link c-link__underline"
                >
                    <div class="p-product-list__img-box">
                        <img
                            :src="productdata.product_img_file_path"
                            @error="noImage"
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HomeSeller",
    data() {
        return {
            sellingProducts: [],
            soldProducts: [],
            emptyMessages: {
                sellingProducts: "",
                soldProducts: "",
            },
        };
    },
    methods: {
        // 出品した商品の最新5件を取得
        getSellingProducts() {
            axios
                .get("/seller/api/getsellingproducts")
                .then((response) => {
                    // console.log(response);
                    this.sellingProducts = response.data.data;
                    if (this.sellingProducts.length == 0) {
                        this.emptyMessages.sellingProducts =
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
        // 購入された商品の最新5件を取得
        getSoldProducts() {
            axios
                .get("/seller/api/getsoldproducts")
                .then((response) => {
                    // console.log(response);
                    this.soldProducts = response.data.data;
                    if (this.soldProducts.length == 0) {
                        this.emptyMessages.soldProducts =
                            "表示できる商品がありません";
                    }
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
        noImage(element) {
            // 画像パスが切れている時のデフォルト画像
            element.target.src =
                "https://haiki-share-backet.s3.ap-northeast-1.amazonaws.com/common-img/default-product-image.jpg";
        },
        url(pid) {
            const url = "/product-detail/" + pid;
            return url;
        },
        editUrl(pid) {
            const url = "./edit-product/" + pid;
            return url;
        },
    },
    created() {
        this.getSellingProducts();
        this.getSoldProducts();
    },
};
</script>
