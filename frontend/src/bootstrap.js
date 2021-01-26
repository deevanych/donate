import Vue from 'vue';
import './scss/app.scss';
import Axios from 'axios';
import Vuesax from 'vuesax';
import Vuelidate from 'vuelidate';
import VueMask from 'v-mask';
import router from '@/router';
import store from '@/store';

// Vuelidate
Vue.use(Vuelidate);

// Vuesax
Vue.use(Vuesax);

// Axios
Vue.prototype.$http = Axios.create({
  baseURL: '/api/v1/',
  timeout: 10000,
});

if (localStorage.getItem('_token')) {
  Vue.prototype.$http.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('_token')}`;
  Vue.prototype.$http.interceptors.response.use((response) => response, (error) => {
    if (error.response.status === 401) {
      store.dispatch('LOGOUT').then(() => {
        if (router.currentRoute.path !== '/') {
          router.push({ name: 'home' });
        } else {
          router.go();
        }
      });
    }
  });
}

// Mask
Vue.use(VueMask);

// Pusher
Vue.use(require('vue-pusher'), {
  api_key: '4e2a53bcaa017d996bda',
  options: {
    cluster: 'eu',
    encrypted: true,
  },
});
