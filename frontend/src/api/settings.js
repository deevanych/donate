import Vue from 'vue';

export default {
  async saveSettings(settings = {}) {
    return Vue.prototype.$http({
      method: 'POST',
      url: '/settings',
      data: settings,
    });
  },

  async getSettings() {
    return Vue.prototype.$http({
      method: 'GET',
      url: '/settings',
    });
  },
};
