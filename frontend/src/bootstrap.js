import Vue from 'vue';
import './scss/app.scss';
import Axios from 'axios';
import Vuesax from 'vuesax';
import Vuelidate from 'vuelidate';

// Vuelidate
Vue.use(Vuelidate);

// Vuesax
Vue.use(Vuesax);

// Cookie

// Axios
Vue.prototype.$http = Axios.create({
  baseURL: '/api/v1/',
  timeout: 10000,
});

if (localStorage.getItem('_token')) {
  Vue.prototype.$http.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('_token')}`;
}

Vue.use(require('vue-pusher'), {
  api_key: '4e2a53bcaa017d996bda',
  options: {
    cluster: 'eu',
    encrypted: true,
  },
});
