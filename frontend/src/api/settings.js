import Vue from 'vue';

const getSettings = () => Vue.prototype.$http({
  method: 'GET',
  url: '/settings',
});

const saveSettings = (data) => Vue.prototype.$http({
  method: 'POST',
  url: '/settings',
  data,
});

export { getSettings, saveSettings };
