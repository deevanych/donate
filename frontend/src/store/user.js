import { getUserProfile } from '@/api/users';

export const user = {
  state: () => ({
    name: '',
    avatar_url: '',
    email: '',
    social_networks: [
      {
        title: '',
        pivot: {
          link: '',
        },
      },
    ],
  }),
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
