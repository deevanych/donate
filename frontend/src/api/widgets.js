import Vue from 'vue';

export default {
  async getList() {
    return Vue.prototype.$http({
      method: 'GET',
      url: '/widgets',
    });
  },
  async create(data) {
    return Vue.prototype.$http({
      method: 'POST',
      url: '/widgets',
      data,
    });
  },
  async get(id) {
    return Vue.prototype.$http({
      method: 'GET',
      url: `/widgets/${id}`,
    });
  },
};
