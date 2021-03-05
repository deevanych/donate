import Vue from 'vue';

const getSettings = () => Vue.prototype.$http({
  method: 'GET',
  url: '/settings',
});

const saveSettings = (settings) => Vue.prototype.$http({
  method: 'POST',
  url: '/settings',
  data: {
    settings,
  },
});

export { getSettings, saveSettings };
