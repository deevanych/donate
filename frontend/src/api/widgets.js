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
  async update(widgetId, data) {
    return Vue.prototype.$http({
      method: 'PUT',
      url: `/widgets/${widgetId}`,
      data,
    });
  },
  async get(widgetId) {
    return Vue.prototype.$http({
      method: 'GET',
      url: `/widgets/${widgetId}`,
    });
  },
};
