import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import firstPage from "./components/pages/myFirstApp";
import newRoutePage from "./components/pages/newRoutePage";
import hooks from "./components/pages/basic/hooks.vue";
import methods from "./components/pages/basic/methods.vue";

const routes = [
    //Project routes ...

    {
        path: "/404",
        component: errorPage,
    },
    {
        path: "/my-new-route",
        component: firstPage,
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
