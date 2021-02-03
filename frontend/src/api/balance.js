import Vue from 'vue';

export default {
  async getBalance() {
    return Vue.prototype.$http({
      method: 'GET',
      url: '/balance',
    });
  },
};
