import Vue from 'vue';
import Vuex from 'vuex';
import userApi from '@/api/user';
import donationApi from '@/api/donation';
import settingsApi from '@/api/settings';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    token: localStorage.getItem('_token') || '',
    user: {
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
    },
    userDonatePage: {
      avatar_url: '',
      created_at: '',
      donation_goals: [],
      donation_variations: [],
      email: '',
      id: 0,
      name: '',
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
    },
  },
  getters: {
    IS_AUTH: (state) => !!state.token,
    USER_DONATE_PAGE: (state) => state.userDonatePage,
    AUTH_USER: (state) => state.user,
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setUserDonatePage(state, user) {
      state.userDonatePage = user;
    },
  },
  actions: {
    async SET_USER_DONATE_PAGE(state, user) {
      const e = userApi.getInfo(user);
      e.then((data) => {
        state.commit('setUserDonatePage', data.data);
      }).catch((error) => {
        Vue.prototype.$vs.notification({
          position: 'top-right',
          border: 'danger',
          title: 'Произошла ошибка',
          text: error,
        });
      });

      return e;
    },

    async SAVE_SETTINGS(state) {
      const e = settingsApi.saveSettings(state.getters.AUTH_USER.settings);
      e.then((response) => {
        Vue.prototype.$vs.notification({
          position: 'top-right',
          border: 'success',
          title: 'Настройки сохранены',
          text: response.data.message,
        });
      }).catch((error) => {
        Vue.prototype.$vs.notification({
          position: 'top-right',
          border: 'danger',
          title: 'Произошла ошибка',
          text: error,
        });
      });

      return e;
    },

    async SET_USER(state) {
      const e = userApi.getInfo();
      e.then((data) => {
        state.commit('setUser', data.data);
      }).catch(() => {

      });

      return e;
    },

    async LOGOUT() {
      localStorage.removeItem('_token');
    },

    async SEND_DONATION(state, data) {
      const e = donationApi.sendDonation(
        data.user,
        data.donation,
      );
      e.then((response) => {
        Vue.prototype.$vs.notification({
          position: 'top-right',
          border: 'success',
          title: 'Донат отправлен',
          text: response.data.message,
        });
      }).catch((error) => {
        Vue.prototype.$vs.notification({
          position: 'top-right',
          border: 'danger',
          title: 'Произошла ошибка',
          text: error,
        });
      });

      return e;
    }
    ,
  },
  modules: {}
  ,
});
