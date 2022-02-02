<template>
  <div class="p-5 h-full flex flex-col items-center justify-center">
    <div class="w-96">
      <h2 class="mb-4 text-4xl font-bold text-center">Login</h2>
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
import LoginForm from "@/components/LoginForm";

export default {
  name: "LoginView",
  components: {
    LoginForm,
  },
};
</script>
