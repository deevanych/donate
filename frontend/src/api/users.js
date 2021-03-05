import Vue from 'vue';

export const getUserProfile = (user) => Vue.prototype.$http({
  method: 'GET',
  url: (user) ? `/users/${user}` : '/users',
});

export default { getUserProfile };
