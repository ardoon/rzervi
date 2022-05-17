<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    props: {
        providers: Object,
    },
    layout: PanelLayout
}
</script>

<template>
    <Head title="providers"/>
    <header>
        <h2 class="text-xl md:text-2xl mb-12">خدمات دهندگان</h2>
    </header>

    <section class="mt-5 flex flex-wrap gap-10">

        <div v-for="provider in providers"
             class="bg-gray-50 flex hover:shadow-blue-300 w-full lg:w-96 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 text-md text-gray-600">
            <img v-for="img in provider.avatar" :src="img.path" alt=""
                 class="h-28 w-28 mr-2 mt-2 rounded-xl">
            <div class="mt-3 pr-3 relative flex-grow">

                <h4 class="font-normal">{{ provider.title }}</h4>

                <a :href="'https://maps.google.com/?q='+ provider.lat +','+ provider.lng "
                   class="text-xs font-light hover:text-blue-400" target="_blank">{{ provider.address }}</a>

                <div class="lg:absolute lg:left-4 lg:bottom-4 mt-0 sm:mt-2 lg:mt-0 flex">
                    <a href="https://maps.google.com/?q=35.314481,46.996909" target="_blank" class="text-blue-500 hover:text-blue-700"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></a>

                    <Link :href="'/customer/servers/' + provider.id + '/join'"
                          class="text-green-500 hover:text-green-700 text-sm font-normal items-end mr-2">عضویت
                    </Link>
                </div>

            </div>
        </div>

    </section>

</template>
