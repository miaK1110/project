/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import Vue from "vue";
import VueMoment from "vue-moment";

window.Vue = require("vue");
Vue.use(require("vue-moment"));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component("pagination", require("laravel-vue-pagination"));

Vue.component(
    "hamburger-menu-component",
    require("./components/HamburgerMenu.vue").default
);

Vue.component(
    "hamburger-menu-logged-in-component",
    require("./components/HamburgerMenuLoggedIn.vue").default
);
Vue.component(
    "questions-component",
    require("./components/Questions.vue").default
);
Vue.component(
    "delete-seller-component",
    require("./components/seller/DeleteSeller.vue").default
);
Vue.component(
    "delete-user-component",
    require("./components/user/DeleteUser.vue").default
);

Vue.component(
    "home-seller-component",
    require("./components/seller/Home.vue").default
);
Vue.component(
    "home-user-component",
    require("./components/user/Home.vue").default
);

Vue.component(
    "products-list-component",
    require("./components/ProductsList.vue").default
);

Vue.component(
    "product-detail-component",
    require("./components/ProductDetail.vue").default
);

Vue.component(
    "seller-products-list-component",
    require("./components/seller/ProductsList.vue").default
);

Vue.component(
    "seller-sold-products-list-component",
    require("./components/seller/SoldProductsList.vue").default
);

Vue.component(
    "create-product-component",
    require("./components/seller/CreateProduct.vue").default
);
Vue.component(
    "edit-product-component",
    require("./components/seller/EditProduct.vue").default
);
Vue.component(
    "twitter-share-component",
    require("./components/TwitterShare.vue").default
);
Vue.component(
    "edit-seller-info-component",
    require("./components/seller/EditSellerInfo.vue").default
);
Vue.component(
    "edit-user-info-component",
    require("./components/user/EditUserInfo.vue").default
);
Vue.component(
    "change-seller-password-component",
    require("./components/seller/ChangePassword.vue").default
);
Vue.component(
    "change-user-password-component",
    require("./components/user/ChangePassword.vue").default
);

Vue.component("loading-component", require("./components/Loading.vue").default);
/**
 *
 *
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
});
