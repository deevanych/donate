import Vue from 'vue';

export const sendDonation = (user, donation) => Vue.prototype.$http({
  method: 'POST',
  url: `/users/${user}/donations`,
  data: {
    donation,
  },
});

export default { sendDonation };
