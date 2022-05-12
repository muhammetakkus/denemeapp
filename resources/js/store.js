import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate";

// Create a new store instance.
const store = createStore({
  state () {
    return {
      token: null,
      admin_token: null,
      user: null,
      admin: null,
    }
  },
  getters: {
    getToken (state) {
      return state.token
    },
    getAdminToken (state) {
      return state.admin_token
    },
    getUser (state) {
      return state.user
    },
    getAdmin (state) {
      return state.admin
    },
  },
  mutations: {
    setTokenAndUser (state, data) {
      state.token = data.token
      state.user = data.user
    },
    setAdminTokenAndAdmin (state, data) {
      state.admin_token = data.admin_token
      state.admin = data.admin
    },
    removeUser (state) {
      state.token = null
      state.user = null
    },
    removeAdmin (state) {
      state.admin_token = null
      state.admin = null
    }
  },
  plugins: [createPersistedState()]
})

export default store
