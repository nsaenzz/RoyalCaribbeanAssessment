import Register from "./components/Registration";
import Home from "./components/Home";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: Home,
        name: "home",
    },
    {
        path: "/registration",
        component: Register,
        name: "registration",
    },

];

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;