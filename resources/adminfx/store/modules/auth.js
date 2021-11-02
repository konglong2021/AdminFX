import auth from '@/api/auth';
import { router, publicPages } from '@/configs/router';

// initial state
const state = () => ({
  isDone: false,
  isAuth: false,
  isAdmin: false,
  user: false,
  permissions: false,
  error: false,
  isShowPasswordForm: false,
});

// getters
const getters = {
  canPermission: (state) => (permission) => {
    if (state.isAdmin || !state.isDone) {
      return true;
    }
    if (!state.permissions || state.permissions.length === 0) return false;
    if (Array.isArray(permission)) {
      return permission.filter((item) => state.permissions.indexOf(item) > -1).length > 0;
    }
    return state.permissions.indexOf(permission) > -1;
  },
};

// actions
const actions = {
  login({ dispatch, commit }, { email, password }) {
    auth.login({
      email,
      password,
      device_name: 'web',
    }).then(({ data }) => {
      console.log(data);
      auth.setToken(data.token);
      commit('setAuth', true);
      dispatch('refreshUser');
      commit('setError', null);
      router.push('/');
    }).catch(({ response }) => {
      console.log(response);
      commit('setError', response.data);
      if (response.status === 401) {
        // dispatch('logout');
      }
    });
  },
  refreshUser({ commit, dispatch }) {
    if (auth.checkAuth()) {
      auth.me().then(({ data }) => {
        commit('setAuth', true);
        commit('setUser', data.data.user);
        commit('setPermissions', data.data.permissions);
        commit('setAdmin', data.data.isAdmin);
        dispatch('checkRouter');
      }).catch(() => {
        dispatch('logout');
      });
    } else {
      dispatch('logout');
    }
  },
  logout({ commit }) {
    auth.clearToken(true);
    commit('setAuth', false);
    commit('setUser', false);
    commit('setPermissions', false);
    router.push('/login');
  },
  checkRouter({ getters }) {
    const route = this.app.config.globalProperties.$route;
    const canPer = route.meta.can;
    if (canPer && !publicPages.includes(route.path) && !getters.canPermission(canPer)) {
      router.push('/');
    }
  },
  showChangePasswordForm({ commit }) {
    commit('setIsShowPasswordForm', true);
  },
  closeChangePasswordForm({ commit }) {
    commit('setIsShowPasswordForm', false);
  },
};

// mutations
const mutations = {
  setAuth(state, flg) {
    state.isAuth = flg;
    if (!state.isDone) state.isDone = true;
  },
  setAdmin(state, isAdmin) {
    state.isAdmin = isAdmin;
  },
  setPermissions(state, permissions) {
    state.permissions = permissions;
  },
  setUser(state, user) {
    state.user = user;
  },
  setError(state, error) {
    state.error = error;
  },
  setIsShowPasswordForm(state, isShowPasswordForm) {
    state.isShowPasswordForm = isShowPasswordForm;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
