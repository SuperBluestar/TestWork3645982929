<template>
    <div class="w-full h-full flex flex-col justify-center items-center">
        <h4 class="text-2xl">Verifying your email address</h4>
        <h5>Loading ...</h5>
    </div>
</template>

<script>
import AuthService from "@/services/AuthService";

export default {
    async mounted() {
        let token = this.$route.params.token;
        let email = this.$route.params.email;

        let res = await AuthService.sendVerification({ token, email});
        console.log(res)
    }
}
</script>
