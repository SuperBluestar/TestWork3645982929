<template>
  <form class="relative" @submit.prevent="login">
    <div v-if="loading" class="absolute w-full h-full flex items-center justify-center bg-gray-500 bg-opacity-25">
      Loading
    </div>
    <div class="m-5">
      <BaseInput
        type="email"
        label="Email"
        name="email"
        v-model="email"
        autocomplete="email"
        placeholder="luke@jedi.com"
        class="mb-2"
      />
      <BaseInput
        type="password"
        label="Password"
        name="password"
        v-model="password"
        class="mb-4"
      />
      <div class="flex justify-between">
        <BaseBtn type="submit" text="Login" />
        <router-link to="/forgot-password" class="text-sm base-link flex items-center">
          Forgot your password?
        </router-link>
      </div>
      <FlashMessage :error="authError" />
    </div>
  </form>
</template>

<script>
import { mapGetters } from "vuex";
import BaseBtn from "@/components/BaseBtn";
import BaseInput from "@/components/BaseInput";
import FlashMessage from "@/components/FlashMessage";

export default {
  name: "LoginView",
  components: {
    BaseBtn,
    BaseInput,
    FlashMessage,
  },
  data() {
    return {
      email: null,
      password: null,
      error: null,
    };
  },
  computed: {
    ...mapGetters("auth", ["authError", "loading"]),
  },
  methods: {
    async login() {
      const device_name = Object.keys(this.$device).filter(key => this.$device[key])?.[0] || "Unknown Device";
      const payload = {
        email: this.email,
        password: this.password,
        device_name
      };
      this.error = null;
      await this.$store.dispatch("auth/setAuth", payload);
    },
  },
};
</script>
