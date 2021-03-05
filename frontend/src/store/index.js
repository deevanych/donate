import Vue from 'vue';
import Vuex from 'vuex';

// modules
import { settings } from './settings';
import { user } from './user';
import { auth } from './auth';
import { balance } from './balance';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    settings,
    user,
    auth,
    balance,
  },
});
