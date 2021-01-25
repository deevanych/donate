import Vue from 'vue';

export default {
  async getInfo(userName = '') {
    return Vue.prototype.$http({
      method: 'GET',
      url: `/users/${userName}`,
    });
  },
};
