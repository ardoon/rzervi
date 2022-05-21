<template>

    <vue-link
        :href="url"
        class="block bg-neutral-700 w-24 h-16 rounded-r-2xl shadow-xl pt-3.5 pr-3 text-lg text-white">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 inline mt-1.5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">

            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />

        </svg>

        <span>رزرو</span>

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
