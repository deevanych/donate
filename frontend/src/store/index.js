import Vue from 'vue';
import Vuex from 'vuex';
import usersApi from '@/api/users';
import donationsApi from '@/api/donations';
import settingsApi from '@/api/settings';
import widgetsApi from '@/api/widgets';
import widgetsTypesApi from '@/api/widgetsTypes';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    token: localStorage.getItem('_token') || '',
    user: {
      name: '',
      avatar_url: '',
      email: '',
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
    widgets: [],
    widgetsTypes: [],
  },
  getters: {
    IS_AUTH: (state) => !!state.token,
    USER_DONATE_PAGE: (state) => state.userDonatePage,
    USER: (state) => state.user,
    USER_WIDGETS: (state) => state.widgets,
    WIDGETS_TYPES: (state) => state.widgetsTypes,
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setSettings(state, settings) {
      state.user.settings = settings;
    },
    setUserDonatePage(state, user) {
      state.userDonatePage = user;
    },
    setWidgets(state, widgets) {
      state.widgets = widgets;
    },
    setWidgetsTypes(state, widgetsTypes) {
      state.widgetsTypes = widgetsTypes;
    },
  },
  actions: {
    async SET_USER_DONATE_PAGE(state, user) {
      const e = usersApi.getInfo(user);
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

    async GET_WIDGETS(state) {
      const e = widgetsApi.getList();
      e.then((data) => {
        state.commit('setWidgets', data.data);
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

    async GET_WIDGET_TYPES(state) {
      const e = widgetsTypesApi.getList();
      e.then((data) => {
        state.commit('setWidgetsTypes', data.data);
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
      const e = settingsApi.saveSettings(state.user.settings);
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

    async GET_SETTINGS(state) {
      const e = settingsApi.getSettings();
      e.then((response) => {
        state.commit('setSettings', response.data);
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

    async GET_USER(state) {
      const e = usersApi.getInfo();
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
      const e = donationsApi.sendDonation(
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
    },
  },
  modules: {}
  ,
});
