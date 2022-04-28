<template>
    <div>
        <button
            class="c-btn__share c-btn__share--twitter"
            @click="twitterShare"
        >
            <i class="c-btn__share-icon fa-brands fa-twitter"></i>
            この商品をシェアする
        </button>
    </div>
</template>

<script>
export default {
    name: "TwitterShare",
    props: ["id", "name"],
    data() {
        return {};
    },
    methods: {
        twitterShare() {
            //シェアする画面を設定
            var shareURL =
                "https://twitter.com/intent/tweet?text=" +
                this.name +
                "%20%23haikishare" +
                "&url=" +
                "https://haikishare.com/product-detail/" +
                this.id;
            //シェア用の画面へ移行
            location.href = shareURL;
        },
    },
};
</script>
