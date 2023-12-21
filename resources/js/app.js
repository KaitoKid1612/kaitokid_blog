import "./bootstrap";
import Vue from "vue";
import router from "./router";
import ViewUI from "view-design";
import "view-design/dist/styles/iview.css";

Vue.use(ViewUI);
import common from "./common.js";
Vue.mixin(common);

// window.Vue = require("vue");

Vue.component("mainapp", require("./components/mainapp.vue").default);

const app = new Vue({
    el: "#app",
    router,
});
