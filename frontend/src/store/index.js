import Vue from 'vue';
import Vuex from 'vuex';
import userApi from '@/api/user';
import donation from '@/api/donation';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: {},
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
    USER_DONATE_PAGE: (state) => state.userDonatePage,
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setUserDonatePage(state, user) {
      state.userDonatePage = user;
      Vue.prototype.$vs.loading().close();
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

    async SEND_DONATION(state, data) {
      const e = donation.sendDonation(
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
