<template>

    <div class="container lg:w-1/2 lg:mx-auto relative">
        <Head>
            <title>{{ provider.title }}</title>
        </Head>

        <img
            :alt="provider.title"
            height="300"
            class="min-w-full max-h-1/3%"
            src="/assets/provider-header-2.jpg">

        <back-button
            class="absolute right-5 top-5 h-6 w-6"
            url="/providers" />

        <provider-info
            :provider-title="provider.title"
            likes-count="22"
            :address="provider.address"
            start="10:00"
            end="08:00" />

        <provider-call-button
            :url="'/book/' + provider.slug"
            class="relative mr-auto -mt-8"
        />

        <provider-about />
    </div>

</template>

<script>
import {Head} from "@inertiajs/inertia-vue3";
import providerInfo from "@/Components/partials/provider-info"
import providerCallButton from "@/Components/partials/provider-call-button"
import providerAbout from "@/Components/partials/provider-about"
import backButton from "@/Components/svg/back-button"


export default {
    name: "ProviderShow",
    props: {
        provider: Object
    },
    components: {
        providerInfo,
        providerCallButton,
        providerAbout,
        Head,
        backButton,
    }
}
</script>

<style scoped>

</style>
