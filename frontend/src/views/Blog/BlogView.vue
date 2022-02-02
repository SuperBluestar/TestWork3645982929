<template>
  <div class="p-5 xl:px-0">
    <div class="max-w-xl m-auto">
      <article
        class="p-5 bg-white rounded shadow flex justify-between items-center"
      >
        <span>New Blog</span>
        <div class="flex">
          <span
            @click="turnOnEditMode"
            v-if="isEditor && !editing"
            class="border p-2 flex cursor-pointer mr-2"
            >Edit Blog</span
          >
          <span
            @click="finishEditMode"
            v-if="isEditor && editing"
            class="border p-2 flex cursor-pointer mr-2"
            >Update Blog</span
          >
          <router-link to="/blogs" class="border p-2 flex cursor-pointer">
            <span>All Blogs</span>
          </router-link>
        </div>
      </article>
      <section
        class="
          border-l-2 border-r-2 border-b-2
          w-full
          flex flex-col
          justify-start
          items-start
          p-5
        "
      >
        <template v-if="!blogLoading">
          <template v-if="editing">
            <input class="w-full text-2xl border" v-model="title" />
            <textarea
              class="w-full"
              style="min-height: 10rem"
              v-model="description"
            />
          </template>
          <template v-else>
            <h3 class="w-full text-2xl border-b">{{ blog.title }}</h3>
            <div style="min-height: 10rem">{{ blog.description }}</div>
          </template>
          <div class="w-full flex justify-between mt-4">
            <span>{{ blog.created_at }}</span>
            <span>{{ blog.updated_at }}</span>
          </div>
        </template>
        <template v-else>
          <div
            class="w-full flex justify-center items-center"
            style="min-height: 12rem"
          >
            Loading ...
          </div>
        </template>
      </section>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
// import HomeIcon from "@/components/icons/HomeIcon";

export default {
  name: "BlogPost",
  components: {},
  data() {
    return {
      title: "",
      description: "",
      editing: false,
    };
  },
  computed: {
    ...mapGetters("auth", ["isEditor"]),
    ...mapGetters("blog", ["blog", "blogLoading"]),
  },
  watch: {
    blog: function (val) {
      this.title = val.title;
      this.description = val.description;
    },
  },
  methods: {
    ...mapActions("blog", ["getBlog", "updateBlog"]),
    turnOnEditMode() {
      this.editing = true;
    },
    async finishEditMode() {
      let payload = {
        title: this.title,
        description: this.description,
      };
      await this.updateBlog({
        id: this.$route.params.id,
        payload,
      });
      this.editing = false;
    },
  },
  mounted() {
    (async () => {
      await this.getBlog(this.$route.params.id);
    })();
  },
};
</script>
