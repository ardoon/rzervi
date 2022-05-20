<template>
    <vue-link :href="url" class="block bg-neutral-700 w-24 h-16 rounded-r-2xl shadow-xl pt-4 pr-4 text-sm">
            <span class="inline-block bg-blue-50 px-1.5 rounded-md pb-2 pt-1 shadow-md text-black">رزرو</span>
    </vue-link>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';

export default {
    name: "provider-call-button",
    props: {
      url: String
    },
    components: {
        vueLink: Link
    }
}
</script>

<style scoped>

</style>
