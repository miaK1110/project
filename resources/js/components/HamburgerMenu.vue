<template>
    <div v-if="SmallScreen">
        <div class="hamburger_btn" v-on:click="ActiveBtn = !ActiveBtn">
            <span
                class="line line_01"
                v-bind:class="{ btn_line01: ActiveBtn }"
            ></span>
            <span
                class="line line_02"
                v-bind:class="{ btn_line02: ActiveBtn }"
            ></span>
            <span
                class="line line_03"
                v-bind:class="{ btn_line03: ActiveBtn }"
            ></span>
        </div>
        <div class="menu" v-bind:class="{ 'is-active': ActiveBtn }">
            <div class="menu__item">
                <a href="https://haikishare.com">トップページ</a>
            </div>
            <div class="menu__item"><a href="/products-list">商品一覧</a></div>
            <div class="menu__item"><a href="/login">ログイン</a></div>
            <div class="menu__item"><a href="/register">会員登録</a></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HamburgerMenu",
    data() {
        return {
            ActiveBtn: false,
            SmallScreen: false,
        };
    },
    methods: {
        handleScreenSize: function () {
            if (window.innerWidth <= 768) {
                this.SmallScreen = true;
            } else {
                this.SmallScreen = false;
            }
        },
    },
    created() {
        window.addEventListener("resize", this.handleScreenSize);
        this.handleScreenSize();
    },
    destroyed() {
        window.removeEventListener("resize", this.handleScreenSize);
    },
};
</script>
