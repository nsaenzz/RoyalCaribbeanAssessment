import router from "./routes";
import VueRouter from "vue-router";
import Index from "./Index";
import Vuetify from './plugins/vuetify';

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(Vuetify)

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router,
    components:{
        "index": Index,
    },
});

