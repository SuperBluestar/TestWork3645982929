// import router from "@/router";
import BlogService from "@/services/BlogService";
import { getError } from "@/utils/helpers";

export const namespaced = true;

export const state = {
  blogs: [],
  blog: {
    title: "",
    description: "",
  },
  loading: false,
  paginator: {
    totalPage: 1,
    currentPage: 1,
    countPerPage: 10,
  },
  error: null,
  info: null,
};

export const mutations = {
  SET_BLOGS(state, blogs, paginator) {
    state.blogs = blogs;
    state.paginator = paginator;
  },
  ADD_BLOG(state, blog) {
    state.blogs.push(blog);
  },
  DELETE_BLOG(state, id) {
    state.blogs = state.blogs.filter((blog) => blog.id !== id);
  },
  // Just editing current blog
  SET_BLOG(state, blog) {
    state.blog = blog;
  },
  SET_LOADING(state, loading) {
    state.loading = loading;
  },
  SET_ERROR(state, error) {
    console.log(error);
    state.error = error;
  },
  SET_INFO(state, info) {
    state.info = info;
  },
};

export const actions = {
  async getBlogs({ commit }, page, search, countPerPage, orderBy) {
    commit("SET_LOADING", true);
    try {
      const res = await BlogService.getBlogs(
        page,
        search,
        countPerPage,
        orderBy
      );
      const { data } = res;
      if (data.success) {
        commit("SET_BLOGS", data.data);
      } else {
        commit("SET_BLOGS", []);
        commit("SET_ERROR", data.message);
      }
    } catch (error) {
      commit("SET_ERROR", getError(error));
    }
    commit("SET_LOADING", false);
  },
  async postBlog({ commit }, payload) {
    commit("SET_LOADING", true);
    try {
      const res = await BlogService.postBlog(payload);
      const { data } = res;
      if (data.success) {
        commit("ADD_BLOG", data.data);
        commit("SET_ERROR", "");
      } else {
        commit("SET_ERROR", data.message);
      }
    } catch (error) {
      commit("SET_ERROR", getError(error));
    }
    commit("SET_LOADING", false);
  },
  async getBlog({ commit }, id) {
    commit("SET_LOADING", true);
    try {
      const res = await BlogService.getBlog(id);
      const { data } = res;
      if (data.success) {
        commit("SET_BLOG", data.data);
        commit("SET_ERROR", "");
      } else {
        commit("SET_ERROR", data.message);
      }
    } catch (error) {
      commit("SET_ERROR", getError(error));
    }
    commit("SET_LOADING", false);
  },
  async updateBlog({ commit }, { id, payload }) {
    commit("SET_LOADING", true);
    try {
      const res = await BlogService.updateBlog(id, payload);
      const { data } = res;
      if (data.success) {
        commit("SET_BLOG", data.data);
        commit("SET_ERROR", null);
      } else {
        commit("SET_ERROR", data.message);
      }
    } catch (error) {
      commit("SET_ERROR", getError(error));
    }
    commit("SET_LOADING", false);
  },
  async deleteBlog({ commit }, id) {
    commit("SET_LOADING", true);
    try {
      const res = await BlogService.deleteBlog(id);
      const { data } = res;
      if (data.success) {
        commit("DELETE_BLOG", id);
        commit("SET_ERROR", "");
      } else {
        commit("SET_ERROR", data.message);
      }
    } catch (error) {
      commit("SET_ERROR", getError(error));
    }
    commit("SET_LOADING", false);
  },
};

export const getters = {
  allBlogs: (state) => {
    return state.blogs;
  },
  blog: (state) => {
    return state.blog;
  },
  blogTitleError: (state) => {
    return state.error?.title?.join(", ");
  },
  blogDescriptionError: (state) => {
    return state.error?.description?.join(", ");
  },
  blogInfo: (state) => {
    return state.info;
  },
  blogLoading: (state) => {
    return state.loading;
  },
};
