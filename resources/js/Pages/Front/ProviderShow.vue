<template>

    <div class="container lg:w-1/2 lg:mx-auto relative">

        <Head>
            <title>{{ provider.title }}</title>
        </Head>

        <provider-header image="/assets/provider-header-2.jpg" />

        <back-button
            class="absolute left-5 top-5 h-6 w-6"
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
import providerHeader from "@/Components/partials/provider-header"
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
        providerHeader,
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
