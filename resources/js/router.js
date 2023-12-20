import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import newRoutePage from "./components/pages/newRoutePage";
import hooks from "./components/pages/basic/hooks.vue";
import methods from "./components/pages/basic/methods.vue";

//admin project pages
import home from "./components/pages/home.vue";
import tags from "./admin/pages/tags.vue";
import category from "./admin/pages/category.vue";

const routes = [
    //Project routes ...
    {
        path: "/",
        component: home,
        name: "home",
    },
    {
        path: "/tags",
        component: tags,
        name: "tags",
    },
    {
        path: "/category",
        component: category,
        name: "category",
    },
    {
        path: "/new-route",
        component: newRoutePage,
    },

    //vue hooks
    {
        path: "/hooks",
        component: hooks,
    },
    //more basics
    {
        path: "/methods",
        component: methods,
    },
];

export default new Router({
    mode: "history",
    routes,
});
