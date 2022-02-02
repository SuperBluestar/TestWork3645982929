<template>
  <form class="relative" @submit.prevent="registerUser">
    <div v-if="loading" class="absolute w-full h-full flex items-center justify-center bg-gray-500 bg-opacity-25">
      Loading
    </div>
    <div class="m-5">
      <BaseInput
        type="text"
        label="Name"
        name="name"
        v-model="name"
        placeholder="Luke Skywalker"
        class="mb-2"
      />
      <BaseInput
        type="email"
        label="Email"
        name="email"
        v-model="email"
        placeholder="luke@jedi.com"
        class="mb-2"
      />
      <BaseInput
        type="password"
        label="Password"
        name="password"
        v-model="password"
        class="mb-2"
      />
      <BaseInput
        type="password"
        label="Confirm Password"
        name="confirm_password"
        v-model="passwordConfirm"
        class="mb-4"
      />
      <BaseBtn type="submit" text="Register" />
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
  name: "RegisterForm",
  components: {
    BaseBtn,
    BaseInput,
    FlashMessage,
  },
  data() {
    return {
      name: null,
      email: null,
      password: null,
      passwordConfirm: null,
      error: null,
    };
  },
  computed: {
    ...mapGetters("auth", ["authError", "loading"]),
  },
  methods: {
    async registerUser() {
      const device_name = Object.keys(this.$device).filter(key => this.$device[key])?.[0] || "Unknown Device";
      this.error = null;
      const payload = {
        name: this.name,
        email: this.email,
        password: this.password,
        confirm_password: this.passwordConfirm,
        device_name
      };
      
      await this.$store.dispatch("auth/register", payload);
    },
  },
};
</script>
