import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import firstPage from "./components/pages/myFirstApp";
import newRoute from "./components/pages/newRoute";

const routes = [
    {
        path: "/my-new-route",
        component: firstPage,
    },
    {
        path: "/new-route",
        component: newRoute,
    },
];

export default new Router({
    mode: "history",
    routes,
});
