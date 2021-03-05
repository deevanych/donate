import { getBalance } from '@/api/balance';

export const balance = {
  state: () => ({
    sum: 0,
  }),
  getters: {
    BALANCE: (state) => state.sum,
  },
  mutations: {
    SET_BALANCE: (state, payload) => {
      state.sum = payload;
    },
  },
  actions: {
    GET_BALANCE: (state) => {
      const e = getBalance();
      e.then(({ data }) => {
        state.commit('SET_BALANCE', data);
      });

      return e;
    },
  },
};

export default balance;
