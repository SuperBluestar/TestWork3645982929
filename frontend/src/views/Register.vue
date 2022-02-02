<template>
  <div class="max-w-sm p-5 m-auto">
    <h2 class="mb-4 text-xl font-bold text-center">Register</h2>
    <div
      v-if="!!this.info"
      class="w-full border p-2 mb-2 bg-green-600 flex justify-between"
    >
      <span>{{ this.info }}</span>
      <span @click="clearInfo">X</span>
    </div>
    <RegisterForm class="p-0 bg-white border rounded shadow" />
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import RegisterForm from "@/components/RegisterForm";

export default {
  name: "RegisterView",
  components: {
    RegisterForm,
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
