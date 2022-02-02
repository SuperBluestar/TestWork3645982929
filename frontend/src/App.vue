<template>
  <div id="app" style="min-height: 100vh; width: 100%">
    <template v-if="!initialLoading">
      <Header />
      <main class="container mx-auto" style="height: calc(100vh - 64px)">
        <router-view />
      </main>
    </template>
    <template v-else>
      <div class="absolute w-full h-full flex justify-center items-center">
        Loading...
      </div>
    </template>
  </div>
</template>

<script>
import Header from "@/components/Header";
import { getToken, setToken } from "@/utils/helpers";
import { mapGetters } from "vuex";

export default {
  name: "app",
  components: {
    Header,
  },
  computed: {
    ...mapGetters("auth", ["initialLoading"]),
  },
  mounted() {
    let token = getToken();
    setToken(token);
    (async () => {
      await this.$store.dispatch("auth/getAuthUser");
    })();
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,700");

.fade-enter,
.fade-leave-active {
  opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
</style>
