require('./bootstrap');

//вендоры
import Vue from 'vue';
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// компоненты
import App from "./components/layouts/App.vue";

//роуты
const routes = [
    {
        path: '/',
        components: {
            default: App,
        }
    }
];

const router = new VueRouter({routes, mode: 'history'});
const app = new Vue({router}).$mount('#app');
