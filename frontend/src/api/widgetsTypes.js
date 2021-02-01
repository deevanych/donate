import Vue from 'vue';

export default {
  async getList() {
    return Vue.prototype.$http({
      method: 'GET',
      url: '/widgets/types',
    });
  },
};
