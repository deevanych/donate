import Vue from 'vue';
import './scss/app.scss';
import Axios from 'axios';
import Vuesax from 'vuesax';
import Vuelidate from 'vuelidate';
import VueYoutube from 'vue-youtube';
import router from '@/router';
import VueHeadFul from 'vue-headful';
import PerfectScrollbar from 'vue2-perfect-scrollbar';
import VueClipboard from 'vue-clipboard2';
import store from './store';

// Clipboard
VueClipboard.config.autoSetContainer = true;
Vue.use(VueClipboard);

// ScrollBar
Vue.use(PerfectScrollbar);

// VueHeadFul
Vue.component('VueHeadFul', VueHeadFul);

// Vuelidate
Vue.use(Vuelidate);

// Vuesax
Vue.use(Vuesax);

// Youtube
Vue.use(VueYoutube);

// Axios
Vue.prototype.$http = Axios.create({
  baseURL: '/api/v1/',
  timeout: 10000,
});

Vue.prototype.$http.defaults.headers.common.Authorization = `Bearer ${store.getters.TOKEN}`;
Vue.prototype.$http.interceptors.response.use((response) => response, (error) => {
  Vue.prototype.$vs.notification({
    position: 'top-right',
    border: 'danger',
    title: 'Произошла ошибка',
    text: error.response.data.message,
  });
  if (error.response.status === 401) {
    store.dispatch('LOGOUT').then(() => {
      router.push('/');
    });
  }
  return Promise.reject(error);
});

// Pusher
Vue.use(require('vue-pusher'), {
  api_key: '4e2a53bcaa017d996bda',
  options: {
    cluster: 'eu',
    encrypted: true,
  },
});
