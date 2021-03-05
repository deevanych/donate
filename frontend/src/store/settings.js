import { getSettings, saveSettings } from '@/api/settings';

export const settings = {
  state: () => ({
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
    background_color: '{"angle":0,"stops":[["#FFFFFF",0],["#f6ce01",1]]}',
    background_blur: 2,
  }),
  getters: {
    SETTINGS: (state) => state,
  },
  mutations: {
    SET_SETTING: (state, payload) => {
      Object.assign(state, payload);
    },
  },
  actions: {
    SAVE_SETTINGS: (state) => {
      const query = saveSettings(state.settings);
      query.then(({ data }) => {
        state.commit('SET_SETTING', data.settings);
      });

      return query;
    },

    GET_SETTINGS: (state) => {
      const query = getSettings();
      query.then(({ data }) => {
        state.commit('SET_SETTING', data);
      });

      return query;
    },
  },
};

export default settings;
