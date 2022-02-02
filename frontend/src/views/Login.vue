<template>
  <div class="p-5 h-full flex flex-col items-center justify-center">
    <div class="w-96">
      <h2 class="mb-4 text-4xl font-bold text-center">Login</h2>
      <div
        v-if="!!this.info"
        class="w-full border p-2 mb-2 bg-green-600 flex justify-between"
      >
        <span>{{ this.info }}</span>
        <span @click="clearInfo">X</span>
      </div>
      <LoginForm class="p-0 bg-white border rounded shadow" />
      <p class="mt-2 text-center text-gray-500">
        <router-link
          to="/register"
          class="text-pink-500 transition hover:text-pink-600"
          >Register for an account</router-link
        >
      </p>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import LoginForm from "@/components/LoginForm";

export default {
  name: "LoginView",
  components: {
    LoginForm,
  },
  computed: {
    ...mapGetters("auth", ["info"]),
  },
  methods: {
    ...mapActions("auth", ["clearInfo", "clearError"]),
  },
  mounted() {
    this.clearInfo();
    this.clearError();
  },
};
</script>
