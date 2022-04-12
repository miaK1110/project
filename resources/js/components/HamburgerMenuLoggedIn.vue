<template>
    <div v-if="SmallScreen" class="p-hamburger">
        <div class="p-hamburger__btn" v-on:click="ActiveBtn = !ActiveBtn">
            <span
                class="p-hamburger__line p-hamburger__line01"
                v-bind:class="{ 'p-menu-btn__line01': ActiveBtn }"
            ></span>
            <span
                class="p-hamburger__line p-hamburger__line02"
                v-bind:class="{ 'p-menu-btn__line02': ActiveBtn }"
            ></span>
            <span
                class="p-hamburger__line p-hamburger__line03"
                v-bind:class="{ 'p-menu-btn__line03': ActiveBtn }"
            ></span>
        </div>
        <div class="p-menu" v-bind:class="{ 'is-active': ActiveBtn }">
            <div class="p-menu__item">
                <a href="https://haikishare.com">トップページ</a>
            </div>
            <div class="p-menu__item">
                <a href="/products-list">商品一覧</a>
            </div>
            <div v-if="this.role === 'user'" class="p-menu__item">
                <a href="https://haikishare.com/user/home">マイページ</a>
            </div>
            <div v-if="this.role === 'seller'" class="p-menu__item">
                <a href="https://haikishare.com/seller/home">マイページ</a>
            </div>
            <div v-if="this.role === 'user'" class="p-menu__item">
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
            .catch((err) => {
                if (err.response.status === 500) {
                    // 500エラーページを表示
                    window.location.href = "/500";
                }
            });
    },
    destroyed() {
        window.removeEventListener("resize", this.handleScreenSize);
    },
};
</script>
