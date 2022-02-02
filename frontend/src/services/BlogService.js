import { authClient } from "@/services/AuthService";

export default {
  async getBlogs(page, search, countPerPage, orderBy) {
    return authClient.get(
      `/blogs?page=${page}&search=${search}&countPerPage=${countPerPage}&orderBy=${orderBy}`
    );
  },
  async postBlog(payload) {
    return authClient.post(`/blogs`, payload);
  },
  async getBlog(id) {
    return authClient.get(`/blogs/${id}`);
  },
  async updateBlog(id, payload) {
    return authClient.put(`/blogs/${id}`, payload);
  },
  async deleteBlog(id) {
    return authClient.delete(`/blogs/${id}`);
  },
};
