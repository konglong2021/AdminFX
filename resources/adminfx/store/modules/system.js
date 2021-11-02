// initial state
const state = () => ({
})

// getters
const getters = {}

// actions
const actions = {
  setAuth({ commit }) {
      commit('setAuth', true)
  }
}

// mutations
const mutations = {
  setAuth(state, isAuth) {
      state.auth = isAuth
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
