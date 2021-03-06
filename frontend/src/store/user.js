import { getUserProfile } from '@/api/users';
import { userType } from '@/types/user';

export const user = {
  state: () => (userType),
  getters: {
    USER: (state) => state,
  },
  mutations: {
    SET_USER: (state, payload) => {
      Object.assign(state, payload);
    },
  },
  actions: {
    GET_USER: (state) => {
      const e = getUserProfile();
      e.then(({ data }) => {
        state.commit('SET_USER', data);
      });

      return e;
    },
  },
};

export default user;
