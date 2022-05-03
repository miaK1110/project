<template>
    <div v-cloak>
        <loading-component :isLoading="this.isLoading"></loading-component>
        <div class="p-product-detail">
            <h3 class="p-product-detail__title">
                {{ this.product.product_name }}
            </h3>
            <div class="p-product-detail__wrapper">
                <div class="p-product-detail__image-container">
                    <img
                        class="p-product-detail__img"
                        :src="this.product.product_img_file_path"
                        @error="noImage"
                    />
                </div>
                <div
                    class="p-product-detail__text-container"
                    v-show="showInfomation"
                >
                    <h4 class="p-product-detail__description">
                        {{ this.product.description }}
                    </h4>
                    <p class="p-product-detail__price">
                        {{ this.product.price }}円（税込）
                    </p>
                    <div class="p-product-detail__details">
                        <p>
                            賞味期限:
                            {{
                                changeDateFormat(this.product.best_defore_date)
                            }}
                        </p>
                        <p>
                            販売店舗名：{{ this.company + this.seller.branch }}
                        </p>
                        <p>
                            住所：{{
                                this.seller.prefecture +
                                this.seller.city +
                                this.seller.address
                            }}
                        </p>
                        <p>郵便番号:{{ this.seller.postcode }}</p>
                        <p>電話番号：{{ this.seller.phone }}</p>
                    </div>
                    <twitter-share
                        :id="this.product.id"
                        :name="this.product.product_name"
                    ></twitter-share>
                </div>
            </div>
            <div class="p-product-detail__btn-container">
                <!-- 一般ユーザーで商品が売り切れじゃない場合 -->
                <div v-if="this.role === 'user' && this.sold === 0">
                    <button
                        class="c-btn--primary c-btn--primary--big u-mb__s"
                        @click="purchaseProduct"
                    >
                        この商品を購入する
                    </button>
                    <p class="p-product-detail__attention">
                        お支払いは店舗でしていただきます。
                    </p>
                </div>
                <!-- ゲストユーザーで商品が売り切れじゃない場合 -->
                <div v-if="this.role === 'guest' && this.sold === 0">
                    <p class="p-product-detail__attention">
                        商品を購入するにはログインが必要です。
                    </p>
                    <a
                        class="c-link__underline"
                        href="https://haikishare.com/user/login"
                        >こちらからログインをしてください。</a
                    >
                </div>
            </div>
            <!-- 商品が売り切れだった場合 -->
            <div class="u-align__center u-pb__s" v-if="this.sold === 1">
                <p class="p-product-detail__attention">
                    この商品は売り切れです。
                </p>
            </div>
            <div class="u-align__center">
                <button
                    class="c-btn--danger"
                    v-if="isPurchaser"
                    @click="cancelPurchase()"
                >
                    購入をキャンセル
                </button>
            </div>
        </div>
    </div>
</template>

<script>
Vue.use(require("vue-moment"));
import moment from "moment";
// momentの表示言語を日本語にする
moment.locale("ja");
import TwitterShare from "./TwitterShare.vue";
import Loading from "./Loading.vue";
export default {
    name: "ProductDetail",
    components: {
        "twitter-share": TwitterShare,
        Loading,
    },
    data() {
        return {
            role: "", // 店舗・一般ユーザー・ゲスト
            uId: "", // ログイン済みの店舗・一般ユーザーのID
            pId: "", // 商品ID
            product: [], // 商品の情報
            seller: [], // この商品を売っている店の情報
            company: "", // この商品を売っている店の企業名(略称)
            sold: "", // 売り切れている商品かどうか
            isPurchaser: false, // 購入したユーザーと見ているユーザーが同じか
            isLoading: false, // ローディング中か判定
            showInfomation: false,
        };
    },
    methods: {
        // 賞味期限がdatetimeで返ってくるのでフォーマットを変換
        changeDateFormat(date) {
            return moment(date).format("YYYY[年]MMMMDo h[時]mm[分]");
        },
        getId() {
            // url取得
            const path = window.location.pathname;
            // セグメンツに分ける。結果 ['', 'product-detail', '4']
            const segments = path.split("/");
            // 2番目のセグメントを返す（商品ID）
            return segments[2];
        },
        getProduct() {
            const id = this.getId();
            axios
                .get("/api/getproduct/" + id)
                .then((response) => {
                    this.product = response.data.productdata;
                    this.pId = response.data.productdata.id;
                    this.seller = response.data.sellerdata;
                    this.company = response.data.companyname;
                    this.sold = response.data.productdata.is_sold;
                    this.isPurchaser = response.data.is_purchaser;
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
        getRole() {
            axios
                .get("/api/getrole")
                .then((response) => {
                    this.role = response.data.role;
                    this.uId = response.data.id;
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
        purchaseProduct() {
            this.isLoading = true;
            let data = new FormData();

            data.append("pid", this.product.id);
            data.append("uid", this.id);
            data.append("role", this.role);
            axios
                .post("/api/purchaseproduct", data)
                .then((response) => {
                    this.isLoading = false;
                    if (response.status === 200) {
                        // status 200ならマイページへ戻る
                        window.location.href = "/user/home";
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    // エラーが発生した場合
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
        cancelPurchase() {
            this.isLoading = true;
            let data = new FormData();

            data.append("id", this.pId);

            axios
                .post("/user/api/cancelpurchase", data)
                .then((response) => {
                    this.isLoading = false;
                    if (response.status === 200) {
                        // status 200ならマイページへ戻る
                        window.location.href = "/user/home";
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    // エラーが発生した場合
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
    },
    created() {
        this.getProduct();
        this.getRole();
        this.showInfomation = true;
    },
};
</script>
