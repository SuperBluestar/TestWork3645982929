<template>
  <div class="p-5 xl:px-0">
    <div class="max-w-xl m-auto">
      <article
        class="p-5 bg-white rounded shadow flex justify-between items-center"
      >
        <span>Blogs</span>
        <router-link
          to="/blogs/create"
          v-if="isEditor"
          class="border p-2 flex cursor-pointer"
        >
          <span class="mr-2">+</span>
          <span>POST</span>
        </router-link>
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
        <div
          @click.prevent="openBlog(blog.id)"
          class="w-full border mb-2 p-2 cursor-pointer"
          v-for="(blog, id) in allBlogs"
          :key="id"
        >
          <div class="flex justify-between items-center py-2 border-b">
            <p class="text-blue-700">{{ blog.title }}</p>
            <div @click.prevent.stop="deleteBlog(blog.id)" v-if="isAdmin">
              <span class="text-red-800 border border-red-800 rounded"
                >Delete</span
              >
            </div>
          </div>
          <article>
            {{ blog.description.slice(0, 100) }}
            {{ blog.description.length > 100 ? "..." : "" }}
          </article>
          <div class="flex justify-end">
            <span class="text-sm">{{ blog.updated_at }}</span>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
// import HomeIcon from "@/components/icons/HomeIcon";

export default {
  name: "Blogs",
  components: {
    // HomeIcon
  },
  computed: {
    ...mapGetters("auth", ["isEditor", "isAdmin"]),
    ...mapGetters("blog", ["allBlogs"]),
  },
  methods: {
    ...mapActions("blog", ["getBlogs", "deleteBlog"]),
    openBlog(id) {
      this.$router.push(`/blogs/view/${id}`);
    },
  },
  mounted() {
    (async () => {
      await this.getBlogs();
    })();
  },
};
</script>
