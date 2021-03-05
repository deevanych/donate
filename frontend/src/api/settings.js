import Vue from 'vue';

export const getSettings = () => Vue.prototype.$http({
  method: 'GET',
  url: '/settings',
});

export const saveSettings = (data) => Vue.prototype.$http({
  method: 'POST',
  url: '/settings',
  data,
});
