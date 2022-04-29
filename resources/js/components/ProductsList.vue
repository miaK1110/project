<template>
    <div class="p-product-list">
        <div class="p-product-list__wrapper">
            <div class="p-product-list__main">
                <div class="p-product-list__filter">
                    <h3 v-on:click="ShowFilter" class="p-product-list__title">
                        <i
                            class="fa-solid fa-square-plus p-product-list__icon"
                        ></i>
                        絞り込み条件
                    </h3>
                    <div v-if="openFilter">
                        <form action="GET">
                            <select
                                id="pref"
                                class="p-product-list__select"
                                name="pref"
                                autocomplete="pref"
                                autofocus
                                v-model="pref"
                            >
                                <option value="" hidden>都道府県</option>
                                <option
                                    v-for="(val, key, index) in prefData"
                                    v-bind:value="val"
                                    v-bind:key="index"
                                    :selected="key == pref"
                                >
                                    {{ val }}
                                </option>
                            </select>
                            <select
                                id="category_id"
                                class="p-product-list__select"
                                name="category_id"
                                autocomplete="category_id"
                                autofocus
                                v-model="category"
                            >
                                <option value="" hidden>カテゴリー</option>
                                <option
                                    v-for="category in categoryList"
                                    v-bind:value="category.id"
                                    v-bind:key="category.id"
                                    :selected="category.id == category"
                                >
                                    {{ category.category_name }}
                                </option>
                            </select>
                            <select
                                class="p-product-list__select"
                                v-model="price"
                            >
                                <option value="" hidden>価格順</option>
                                <option value="asc">価格が安い順</option>
                                <option value="desc">価格が高い順</option>
                            </select>
                            <select
                                class="p-product-list__select"
                                v-model="isExpired"
                            >
                                <option value="" hidden>賞味期限</option>
                                <option value="0">切れていない</option>
                                <option value="1">切れている</option>
                            </select>
                            <a
                                class="p-product-list__select-button"
                                @click="getSelectedProducts(page)"
                                >この条件で検索</a
                            >
                        </form>
                    </div>
                </div>
                <div class="p-product-list__list-container">
                    <div
                        class="p-product-list__list-item"
                        v-for="(productdata, index) in allProducts"
                        v-bind:key="index"
                    >
                        <a
                            :href="url(productdata.id)"
                            class="p-product-list__product-link c-link__underline"
                        >
                            <!-- 商品が売り切れじゃない時 -->
                            <div
                                class="p-product-list__img-box"
                                v-if="productdata.is_sold === 0"
                            >
                                <img
                                    class="p-product-list__img"
                                    :src="productdata.product_img_file_path"
                                    @error="noImage"
                                    alt="商品の画像"
                                />
                            </div>
                            <!-- 商品が売り切れだった時売り切れのラベルを表示する -->
                            <div
                                class="p-product-list__img-box--is-sold"
                                v-if="productdata.is_sold === 1"
                            >
                                <img
                                    class="p-product-list__img--is-sold"
                                    :src="productdata.product_img_file_path"
                                    alt="商品の画像"
                                />
                            </div>

                            <p class="p-product-list__name">
                                {{ productdata.product_name }}
                            </p>
                        </a>
                        <s class="p-product-list__original-price"
                            >{{ productdata.original_price }}円（税込）</s
                        >
                        <p class="p-product-list__price">
                            {{ productdata.price }}円（税込）
                        </p>
                    </div>
                </div>
                <!-- ページネーション -->
                <div class="c-pager u-mb__l">
                    <ul class="c-pager__pagination">
                        <li
                            :class="{
                                'c-pager__item--is-disabled':
                                    currentPageNum <= 1,
                            }"
                            class="c-pager__item"
                        >
                            <a href="#" @click="change(1)" class="c-pager__link"
                                ><span class="c-pager__mark">«</span></a
                            >
                        </li>
                        <li
                            :class="{
                                'c-pager__item--is-disabled':
                                    currentPageNum <= 1,
                                'c-pager--pre--is-disabled':
                                    currentPageNum <= 1,
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
                        <li
                            v-for="page in pages"
                            :key="page"
                            class="c-pager__item"
                        >
                            <a
                                href="#"
                                @click="change(page)"
                                :class="{
                                    'c-pager--active': page === currentPageNum,
                                }"
                                class="c-pager__link"
                                ><span class="c-pager__mark">{{
                                    page
                                }}</span></a
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
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductsList",
    data() {
        return {
            prefData: {},
            pref: "",
            categoryList: {},
            category: "",
            price: "",
            isExpired: "",
            isSold: 0,
            openFilter: false,
            allProducts: {},
            currentPageNum: 1,
            totalPageNum: 1,
            page: 1,
        };
    },

    methods: {
<<<<<<< HEAD
        // getProducts(page) {
        //     axios
        //         .get(
        //             "/api/getproducts?page=" +
        //                 page +
        //                 "&pref=" +
        //                 this.pref +
        //                 "&category=" +
        //                 this.category +
        //                 "&price=" +
        //                 this.price +
        //                 "&is-expired=" +
        //                 this.isExpired
        //         )
        //         .then(({ data }) => {
        //             console.log(data);
        //             this.allProducts = data.data.data;

        //             this.currentPageNum = data.data.current_page;
        //             this.totalPageNum = data.data.last_page;
        //         })
        //         .catch((err) => {
        //             if (err.response.status === 500) {
        //                 // 500エラーページを表示
        //                 window.location.href = "/500";
        //             }
        //         });
        // },
=======
>>>>>>> develop
        getSelectedProducts(page) {
            axios
                .get(
                    "/api/getselectedproducts?page=" +
                        page +
                        "&pref=" +
                        this.pref +
                        "&category=" +
                        this.category +
                        "&price=" +
                        this.price +
                        "&is-expired=" +
                        this.isExpired
                )
                .then(({ data }) => {
                    this.allProducts = data.data.data;
                    this.currentPageNum = data.data.current_page;
                    this.totalPageNum = data.data.last_page;
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
                this.getSelectedProducts(page);
        },
        getPrefData() {
            axios
                .get("/api/getprefdata")
                .then((response) => {
                    if (response.status === 200) {
                        this.prefData = response.data.prefData;
                    }
                })
                .catch((err) => {
                    if (err.response.status === 500) {
                        // 500エラーページを表示
                        window.location.href = "/500";
                    }
                });
        },
        getCategoryData() {
            axios
                .get("/api/getcategorylist")
                .then((response) => {
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
        ShowFilter() {
            this.openFilter = !this.openFilter;
        },
        url(pid) {
            const url = "/product-detail/" + pid;
            return url;
        },
    },
    created() {
        this.getPrefData();
        this.getCategoryData();
    },
    mounted() {
        this.getSelectedProducts(1);
    },
    computed: {
        pages() {
            let start = _.max([this.currentPageNum - 2, 1]);
            let end = _.min([start + 5, this.totalPageNum + 1]);
            start = _.max([end - 5, 1]);
            return _.range(start, end);
        },
    },
};
</script>
