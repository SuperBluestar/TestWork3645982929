<template>
  <div class="p-5 xl:px-0">
    <div class="max-w-xl m-auto">
      <article
        class="p-5 bg-white rounded shadow flex justify-between items-center"
      >
        <span>New Blog</span>
        <router-link to="/blogs" class="border p-2 flex cursor-pointer">
          <span>All Blogs</span>
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
        <BaseInput
          type="text"
          label="Blog Title"
          name="title"
          v-model="title"
          placeholder="Type here"
          class="mb-2 w-full"
        />
        <FlashMessage :error="blogTitleError" />
        <BaseTextarea
          type="text"
          label="Blog Description"
          name="description"
          v-model="description"
          placeholder="Type here"
          rows="8"
          class="mb-2 w-full"
        />
        <FlashMessage :error="blogDescriptionError" />
        <BaseBtn
          class="w-full"
          @click.prevent="submit"
          type="submit"
          text="Submit"
        />
      </section>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
// import HomeIcon from "@/components/icons/HomeIcon";
import BaseInput from "@/components/BaseInput";
import BaseTextarea from "@/components/BaseTextarea";
import BaseBtn from "@/components/BaseBtn";
import FlashMessage from "@/components/FlashMessage";

export default {
  name: "BlogPost",
  components: {
    BaseInput,
    BaseTextarea,
    BaseBtn,
    FlashMessage,
  },
  data() {
    return {
      title: "",
      description: "",
    };
  },
  computed: {
    ...mapGetters("auth", ["isEditor"]),
    ...mapGetters("blog", [
      "blogTitleError",
      "blogDescriptionError",
      "blogInfo",
    ]),
  },
  methods: {
    ...mapActions("blog", ["postBlog"]),
    async submit() {
      const payload = {
        title: this.title,
        description: this.description,
      };
      await this.postBlog(payload);
    },
  },
  mounted() {},
};
</script>
