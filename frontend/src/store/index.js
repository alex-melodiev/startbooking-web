import Vue from "vue";
import Vuex from "vuex";
import VuexPersistence from 'vuex-persist';
import user from "../modules/user/store";
import login from "../modules/login/store";
import favorite from "../modules/favorite/store";
import i18n, { selectedLocale } from "../modules/i18n";

Vue.use(Vuex);

const vuexPersistentSessionStorage = new VuexPersistence({
  key: process.env.VUE_APP_SLUG,
  modules: ["user", "favorite"],
});

export default new Vuex.Store({
  state: {
      locale: selectedLocale
  },
  mutations: {
      updateLocale(state, newLocale) {
          state.locale = newLocale
      }
  },
  actions: {
      changeLocale({ commit }, newLocale) {
          i18n.locale = newLocale // important!
          commit('updateLocale', newLocale)
      }
  },
  modules: {
    user,
    login,
    favorite
  },
  plugins: [vuexPersistentSessionStorage.plugin],
});
