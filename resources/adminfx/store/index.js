import { createStore } from 'vuex';
import auth from './modules/auth';

const store = createStore({
  state: {
    min_sidebar: false,
    is_loading: true,
  },
  mutations: {
    setSidebar(state) {
      state.min_sidebar = !state.min_sidebar;
      state.is_loading = !state.is_loading;
    },
  },
  actions: {
    setSidebar({ commit }) {
      commit('setSidebar');
    },
  },
  modules: {
    auth,
  },
});
export default (app) => {
  app.$store = store;
  app.$can = (permission) => {
    return app.$store.getters['auth/canPermission'](permission);
  };
  app.config.globalProperties.$can = app.$can;
  store.app = app;
  app.use(store);
};
