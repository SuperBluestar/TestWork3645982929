import axios from "axios";

export const authClient = axios.create({
  baseURL: `${process.env.VUE_APP_API_URL}/api`,
  withCredentials: false, // required to handle the CSRF token
});

export default {
  async login(payload) {
    return authClient.post("/login", payload);
  },
  // async forgotPassword(payload) {
  //   await authClient.get("/sanctum/csrf-cookie");
  //   return authClient.post("/forgot-password", payload);
  // },
  getAuthUser() {
    return authClient.get("/user");
  },
  // async resetPassword(payload) {
  //   await authClient.get("/sanctum/csrf-cookie");
  //   return authClient.post("/reset-password", payload);
  // },
  // updatePassword(payload) {
  //   return authClient.put("/user/password", payload);
  // },
  async registerUser(payload) {
    return authClient.post("/register", payload);
  },
  sendVerification(payload) {
    return authClient.post("/email/verification", payload);
  },
  updateUser(payload) {
    return authClient.put("/user/profile-information", payload);
  },
};
