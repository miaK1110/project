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
            <div v-if="this.role === 'user'" class="menu__item">
                <a href="https://haikishare.com/user/home">マイページ</a>
            </div>
            <div v-if="this.role === 'seller'" class="menu__item">
                <a href="https://haikishare.com/seller/home">マイページ</a>
            </div>
            <div v-if="this.role === 'user'" class="menu__item">
                <a href="https://haikishare.com/user/logout">ログアウト</a>
            </div>
            <div v-if="this.role === 'seller'" class="menu__item">
                <a href="https://haikishare.com/seller/logout">ログアウト</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HamburgerMenuLoggedIn",
    data() {
        return {
            ActiveBtn: false,
            SmallScreen: false,
            role: "",
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
    mounted() {
        axios
            .get("/api/getrole")
            .then((response) => {
                this.role = response.data.role;
            })
            .catch(function (error) {
                console.log("取得に失敗しました。", error);
            });
    },
    destroyed() {
        window.removeEventListener("resize", this.handleScreenSize);
    },
};
</script>
