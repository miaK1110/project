<template>
    <div class="c-home">
        <p class="u-mb__s">購入された商品一覧</p>
        <p class="c-form__err-msg" v-if="emptyMessages.sellerProducts">
            {{ emptyMessages.sellerProducts }}
        </p>
        <div class="p-product-list__list-container" v-if="sellerProducts">
            <div
                class="p-product-list__list-item"
                v-for="(productdata, index) in sellerProducts"
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
                <div class="p-product-list__button-box">
                    <a
                        class="p-product-list__button-box--detail"
                        :href="url(productdata.id)"
                    >
                        詳細</a
                    >
                </div>
            </div>
        </div>
        <!-- ページネーション -->
        <div class="c-pager u-mb__l">
            <ul class="c-pager__pagination">
                <li :class="{ disabled: current_page <= 1 }">
                    <a href="#" @click="change(1)"><span>«</span></a>
                </li>
                <li
                    :class="{ disabled: current_page <= 1 }"
                    class="c-pager--pre"
                >
                    <a href="#" @click="change(current_page - 1)"
                        ><span>&lt;</span></a
                    >
                </li>
                <li v-for="page in pages" :key="page">
                    <a
                        href="#"
                        @click="change(page)"
                        :class="{
                            'c-pager--active': page === current_page,
                        }"
                        ><span>{{ page }}</span></a
                    >
                </li>
                <li
                    :class="{ disabled: current_page >= last_page }"
                    class="c-pager--next"
                >
                    <a href="#" @click="change(current_page + 1)"
                        ><span>&gt;</span></a
                    >
                </li>
                <li :class="{ disabled: current_page >= last_page }">
                    <a href="#" @click="change(last_page)"><span>»</span></a>
                </li>
            </ul>
        </div>
        <!-- ページネーションここまで -->
    </div>
</template>

<script>
export default {
    name: "productsList",
    data() {
        return {
            sellerProducts: [],
            isSold: "", // 購入された商品かどうかの判定用
            // 商品が無いなら’商品がありません’の文字を表示
            emptyMessages: {
                sellerProducts: "",
            },
            current_page: 1, // 現在のページ番号
            last_page: 1, // 最終ページ番号
            total: 1, //総レコード数
            from: 0, // 表示する先頭のレコード
            to: 0, // 表示する最後のレコード
            page: 1,
        };
    },
    methods: {
        getAllSoldProducts(page) {
            axios
                .get(
                    "http://localhost:8000/seller/api/getallsoldproducts?page=" +
                        page
                )
                .then(({ data }) => {
                    console.log(data);
                    this.sellerProducts = data.data.data;
                    if (this.sellerProducts.length == 0) {
                        this.emptyMessages.sellingProducts =
                            "表示できる商品がありません";
                        return false;
                    }

                    this.current_page = data.data.current_page;
                    this.last_page = data.data.last_page;
                    this.total = data.data.total;
                    this.from = data.data.from;
                    this.to = data.data.to;
                })
                .catch((err) => {});
        },
        change(page) {
            if (page >= 1 && page <= this.last_page)
                this.getAllSoldProducts(page);
        },
        url(pid) {
            const url = "/product-detail/" + pid;
            return url;
        },
    },
    created() {
        this.getAllSoldProducts();
    },
    computed: {
        pages() {
            let start = _.max([this.current_page - 2, 1]);
            let end = _.min([start + 5, this.last_page + 1]);
            start = _.max([end - 5, 1]);
            return _.range(start, end);
        },
    },
};
</script>
