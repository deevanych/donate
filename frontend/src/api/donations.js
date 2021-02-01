import Vue from 'vue';

export default {
  async sendDonation(userName = '', donation = {}) {
    return Vue.prototype.$http({
      method: 'POST',
      url: `/users/${userName}/donations`,
      data: {
        donation,
      },
    });
  },
};
