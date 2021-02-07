import Vue from 'vue';
import Vuex from 'vuex';
import users from '@/api/users';
import balance from '@/api/balance';
import settings from '@/api/settings';
import donations from '@/api/donations';

const userObject = {
  profile: {
    name: '',
    avatar_url: '',
    email: '',
  },
  balance: 0,
  settings: {
    background_uri: '',
    donate_button_text: 'Отправить',
    donation_media_min_sum: 150,
    donation_min_sum: 100,
    enabled_donation_goals: false,
    enabled_donation_variations: false,
    enabled_media: false,
    main_color: '#007bff',
    description: '',
    donate_button_text_color: '#FFFFFF',
    background_color: 'rgba(255, 255, 255, .8)',
    background_blur: 2,
  },
  social_networks: [
    {
      title: '',
      pivot: {
        link: '',
      },
    },
  ],
  updated_at: '',
};

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    token: localStorage.getItem('_token') || '',
    user: userObject,
    userDonatePage: userObject,
  },
  getters: {
    TOKEN: (state) => state.token,
    IS_AUTH: (state) => !!state.token,
    USER_DONATE_PAGE: (state) => state.userDonatePage,
    USER: (state) => state.user.profile,
    BALANCE: (state) => state.user.balance,
    SETTINGS: (state) => state.user.settings,
  },
  mutations: {
    setUserProfile(state, payload) {
      state.user.profile = payload;
    },
    setToken(state, token) {
      state.token = token;
    },
    setSettings(state, payload) {
      state.user.settings = payload;
    },
    setBalance(state, payload) {
      state.user.balance = payload;
    },
    setUserDonatePage(state, payload) {
      state.userDonatePage = payload;
    },
  },
  actions: {
    async SET_TOKEN(state, token = null) {
      state.commit('setToken', token);
      Vue.prototype.$http.defaults.headers.common.Authorization = `Bearer ${token}`;
    },

    async SET_USER_DONATE_PAGE(state, user) {
      const e = users.getProfile(user);
      e.then((data) => {
        state.commit('setUserDonatePage', data.data);
      }).catch(() => {

      });

      return e;
    },

    async SAVE_SETTINGS(state) {
      const e = settings.saveSettings(state.getters.SETTINGS);
      e.then((data) => {
        state.commit('setSettings', data.data.settings);
        Vue.prototype.$vs.notification({
          position: 'top-right',
          border: data.data.status,
          title: 'Настройки сохранены',
          text: data.data.message,
        });
      }).catch(() => {

      });

      return e;
    },

    async GET_SETTINGS(state) {
      const e = settings.getSettings();
      e.then((response) => {
        state.commit('setSettings', response.data);
      }).catch(() => {

      });

      return e;
    },

    async GET_BALANCE(state) {
      const e = balance.getBalance();
      e.then((response) => {
        state.commit('setBalance', response.data);
      }).catch(() => {

      });

      return e;
    },

    async GET_USER_PROFILE(state) {
      const e = users.getProfile();
      e.then((data) => {
        state.commit('setUserProfile', data.data);
      }).catch(() => {

      });

      return e;
    },

    async LOGOUT(state) {
      localStorage.removeItem('_token');
      state.dispatch('SET_TOKEN');
    },

    async SEND_DONATION(state, data) {
      const e = donations.sendDonation(
        data.user,
        data.donation,
      );
      e.then((response) => {
        Vue.prototype.$vs.notification({
          position: 'top-right',
          border: response.data.status,
          title: 'Донат отправлен',
          text: response.data.message,
        });
      }).catch(() => {

      });

      return e;
    },
  },
  modules: {}
  ,
});
