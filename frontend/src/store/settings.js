import { getSettings, saveSettings } from '@/api/settings';
import { settingsType } from '@/types/settings';

export const settings = {
  state: () => (settingsType),
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
      const query = saveSettings(state.getters.SETTINGS);
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
