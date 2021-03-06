import Vue from "vue";
import Vuex from "vuex";

import * as auth from "@/store/modules/Auth";
import * as blog from "@/store/modules/Blog";
import * as user from "@/store/modules/User";
import * as message from "@/store/modules/Message";

Vue.use(Vuex);

export default new Vuex.Store({
  strict: true,

  modules: {
    auth,
    blog,
    user,
    message,
  },
});
