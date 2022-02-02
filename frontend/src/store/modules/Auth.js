import router from "@/router";
import { getError, setToken } from "@/utils/helpers";
import AuthService from "@/services/AuthService";

export const namespaced = true;
export const ADMIN = 1023;
export const EDITOR = 2;
export const USER = 1;

export const state = {
  user: null,
  loading: true,
  error: null,
};

export const mutations = {
  SET_USER(state, user) {
    state.user = user;
  },
  SET_LOADING(state, loading) {
    state.loading = loading;
  },
  SET_ERROR(state, error) {
    state.error = error;
  },
};

export const actions = {
  logout({ commit }) {
      commit("SET_USER", null);
      setToken("")
      if (router.currentRoute.name !== "login")
        router.push({ path: "/login" });
  },
  async getAuthUser({ commit }) {
    commit("SET_LOADING", true);
    try {
      const res = await AuthService.getAuthUser();
      if (res.data.success) {
        commit("SET_USER", res.data.data);
        commit("SET_LOADING", false);
        if( router.currentRoute.query.redirect ) {
          router.push(router.currentRoute.query.redirect)
        } else {
          router.push("/blogs"); 
        }
      } else {
        commit("SET_USER", null);
        commit("SET_LOADING", false);
      }
    } catch (error) {
      commit("SET_LOADING", false);
      commit("SET_USER", null);
      commit("SET_ERROR", getError(error));
    }
  },
  async setAuth({ commit }, payload) {
    commit("SET_LOADING", true);
    try {
      const res = await AuthService.login(payload);
      const { data } = res;
      if (data.success) {
        setToken(data.data.token);
        commit("SET_USER", data.data);
        commit("SET_ERROR", "");
        if( router.currentRoute.query.redirect ) {
          router.push(router.currentRoute.query.redirect)
        } else {
          router.push("/blogs"); 
        }
      } else {
        // alert(data.message);
        commit("SET_ERROR", data.message);
      }
    } catch(error) {
      commit("SET_ERROR", getError(error));
    }
    commit("SET_LOADING", false);
  },
};

export const getters = {
  authUser: (state) => {
    return state.user;
  },
  authError: (state) => {
    return state.error;
  },
  isAdmin: (state) => {
    return state.user ? (state.user.rolebinary & ADMIN === ADMIN) : false;
  },
  isEditor: (state) => {
    return state.user ? (state.user.rolebinary & EDITOR === EDITOR) : false;
  },
  isUser: (state) => {
    return state.user ? (state.user.rolebinary & USER === USER) : false;
  },
  error: (state) => {
    return state.error;
  },
  loading: (state) => {
    return state.loading;
  },
  loggedIn: (state) => {
    return !!state.user;
  },
  guest: () => {
    const storageItem = window.localStorage.getItem("guest");
    if (!storageItem) return false;
    if (storageItem === "isGuest") return true;
    if (storageItem === "isNotGuest") return false;
  },
};
