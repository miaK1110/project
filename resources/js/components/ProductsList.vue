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
                    <div v-if="OpenFilter">
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
                                    :src="productdata.product_img_file_path"
                                    alt="商品の画像"
                                />
                            </div>
                            <!-- 商品が売り切れだった時売り切れのラベルを表示する -->
                            <div
                                class="p-product-list__img-box--is-sold"
                                v-if="productdata.is_sold === 1"
                            >
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
                            <a href="#" @click="change(last_page)"
                                ><span>»</span></a
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
            OpenFilter: false,
            allProducts: {},
            page: 1,
            current_page: 1, // 現在のページ番号
            last_page: 1, // 最終ページ番号
            total: 1, //総レコード数
            from: 0, // 表示する先頭のレコード
            to: 0, // 表示する最後のレコード
        };
    },

    methods: {
        getProducts(page) {
            axios.get("/api/getproducts?page=" + page).then(({ data }) => {
                // console.log(data);
                this.allProducts = data.data.data;

                this.current_page = data.data.current_page;
                this.last_page = data.data.last_page;
                this.total = data.data.total;
                this.from = data.data.from;
                this.to = data.data.to;
            });
        },
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
                    this.current_page = data.data.current_page;
                    this.last_page = data.data.last_page;
                    this.total = data.data.total;
                    this.from = data.data.from;
                    this.to = data.data.to;
                });
        },
        change(page) {
            if (page >= 1 && page <= this.last_page)
                this.getSelectedProducts(page);
        },
        getPrefData() {
            axios
                .get("/api/getprefdata")
                .then((response) => {
                    // console.log(response);
                    if (response.status === 200) {
                        this.prefData = response.data.prefData;
                    }
                })
                .catch((err) => {
                    this.message = err.response.data.errors;
                });
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
                    this.message = err.response.data.errors;
                });
        },
        ShowFilter() {
            this.OpenFilter = !this.OpenFilter;
        },
        url(pid) {
            const url = "/product-detail/" + pid;
            // console.log(url);
            return url;
        },
    },
    created() {
        this.getPrefData();
        this.getCategoryData();
    },
    mounted() {
        this.getProducts(1);
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
