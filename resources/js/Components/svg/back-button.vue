<template>
    <vue-link :href="url" class="text-gray-700 hover:text-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </vue-link>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';

export default {
    name: "back-button",
    props: {
        url: String
    },
    components: {
        vueLink: Link
    }
}
</script>
