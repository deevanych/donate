import Vue from 'vue';

export default {
  async getProfile(userName = '') {
    return Vue.prototype.$http({
      method: 'GET',
      url: (userName) ? `/users/${userName}` : '/users',
    });
  },
};
