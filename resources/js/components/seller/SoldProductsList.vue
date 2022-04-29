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
                            class="p-product-list__img"
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
                <li
                    :class="{
                        'c-pager__item--is-disabled': currentPageNum <= 1,
                    }"
                    class="c-pager__item"
                >
                    <a href="#" @click="change(1)" class="c-pager__link"
                        ><span class="c-pager__mark">«</span></a
                    >
                </li>
                <li
                    :class="{
                        'c-pager__item--is-disabled': currentPageNum <= 1,
                        'c-pager--pre--is-disabled': currentPageNum <= 1,
                    }"
                    class="c-pager--pre c-pager__item"
                >
                    <a
                        href="#"
                        @click="change(currentPageNum - 1)"
                        class="c-pager__link"
                        ><span class="c-pager__mark">&lt;</span></a
                    >
                </li>
                <li v-for="page in pages" :key="page" class="c-pager__item">
                    <a
                        href="#"
                        @click="change(page)"
                        :class="{
                            'c-pager--active': page === currentPageNum,
                        }"
                        class="c-pager__link"
                        ><span class="c-pager__mark">{{ page }}</span></a
                    >
                </li>
                <li
                    :class="{
                        'c-pager__item--is-disabled':
                            currentPageNum >= totalPageNum,
                        'c-pager--next--is-disabled':
                            currentPageNum >= totalPageNum,
                    }"
                    class="c-pager--next c-pager__item"
                >
                    <a
                        href="#"
                        @click="change(currentPageNum + 1)"
                        class="c-pager__link"
                        ><span class="c-pager__mark">&gt;</span></a
                    >
                </li>
                <li
                    :class="{
                        'c-pager__item--is-disabled':
                            currentPageNum >= totalPageNum,
                    }"
                    class="c-pager__item"
                >
                    <a
                        href="#"
                        @click="change(totalPageNum)"
                        class="c-pager__link"
                        ><span class="c-pager__mark">»</span></a
                    >
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
            currentPage: 1, // 現在のページ番号
            totalPageNum: 1, // 最終ページ番号
        };
    },
    methods: {
        getAllSoldProducts(page) {
            axios
                .get("/seller/api/getallsoldproducts?page=" + page)
                .then(({ data }) => {
                    this.sellerProducts = data.data.data;
                    if (this.sellerProducts.length === 0) {
                        this.emptyMessages.sellingProducts =
                            "表示できる商品がありません";
                        return false;
                    }

                    this.currentPage = data.data.current_page;
                    this.totalPageNum = data.data.last_page;
                    this.total = data.data.total;
                    this.from = data.data.from;
                    this.to = data.data.to;
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
        change(page) {
            if (page >= 1 && page <= this.totalPageNum)
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
            let start = _.max([this.currentPage - 2, 1]);
            let end = _.min([start + 5, this.totalPageNum + 1]);
            start = _.max([end - 5, 1]);
            return _.range(start, end);
        },
    },
};
</script>
