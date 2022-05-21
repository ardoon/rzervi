<template>
    <div class="relative bg-white w-11/12 shadow-2xl rounded-r-3xl -mt-12 mr-auto py-6 pr-7 pl-12 text-sm text-gray-700">

        <h1 class="text-2xl font-semibold">{{ providerTitle }}</h1>

        <p class="mt-8 flex items-center">
            <heart-icon class="h-5 w-5 ml-1 text-rose-500"></heart-icon>
            {{ likesCount }} نفر می پسندند
        </p>

        <p class="mt-3 flex items-start leading-5">
            <location-icon class="h-5 w-5 ml-1 text-gray-500"></location-icon>
            {{ address }}
        </p>

        <p class="mt-3 flex items-center">
            <clock-icon class="h-4 w-4 ml-1 text-gray-500"></clock-icon>
            {{ start }} صبح - {{ end }} عصر
        </p>

    </div>
</template>

<script>
import heartIcon from "@/Components/svg/heart-icon"
import locationIcon from "@/Components/svg/location-icon"
import clockIcon from "@/Components/svg/clock-icon"

export default {
    name: "provider-info",
    props: {
        providerTitle: String,
        likesCount: Object,
        address: Object,
        start: Object,
        end: Object
    },
    components: {
        heartIcon,
        locationIcon,
        clockIcon,
    }
}
</script>

<style scoped>

</style>
