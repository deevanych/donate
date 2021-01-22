import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: {

    },
    donatePage: {
      nickname: null,
      main_color: '#007bff',
      donate_button_text: 'Отправить',
      background_uri: null,
      enabled_media: null,
      enabled_donation_variations: null,
      enabled_donation_goals: null,
      donation_min_sum: null,
      donation_media_min_sum: null,
    },
  },
  getters: {
    getDonatePageSettings: (state) => (param) => state.donatePage[param],
  },
  mutations: {
    setDonatePageSettings(state, settings) {
      Object.keys(settings).forEach((key) => {
        state.donatePage[key] = settings[key];
      });
    },
  },
  actions: {
    setDonatePageSettings(state, settings) {
      state.commit('setDonatePageSettings', settings);
    },
  },
  modules: {
  },
});
