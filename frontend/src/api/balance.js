import Vue from 'vue';

export const getBalance = () => Vue.prototype.$http({
  method: 'GET',
  url: '/balance',
});

export default { getBalance };
