import Vue from 'vue';

export const auth = {
  state: () => ({
    token: localStorage.getItem('_token') || '',
  }),
  getters: {
    TOKEN: (state) => state.token,
    IS_AUTH: (state) => !!state.token,
  },
  mutations: {
    SET_TOKEN: (state, token) => {
      state.token = token;
    },
  },
  actions: {
    SET_TOKEN: (state, token) => {
      state.commit('SET_TOKEN', token);
      Vue.prototype.$http.defaults.headers.common.Authorization = `Bearer ${token}`;
    },
    LOGOUT: (state) => {
      localStorage.removeItem('_token');
      state.dispatch('SET_TOKEN');
    },
  },
};

export default auth;
