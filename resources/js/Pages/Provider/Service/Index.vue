<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
defineProps({
    'services': Object
});
</script>

<script>
import Layout from "../../../Layouts/Panel";

export default {
    layout: Layout,
}
</script>

<template>
    <Head title="Services"/>
    <div>
        <header>
            <h2 class="text-xl md:text-2xl mb-12 text-slate-700">خدمات</h2>
        </header>

        <Link :href="route('provider.services.create')" class="block mb-3 text-indigo-500 hover:text-indigo-600">
            افزودن خدمت
        </Link>

        <section class="mt-5 flex flex-wrap gap-5 justify-center lg:justify-start">
            <div v-for="service in services" class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="'/provider/services/' + service.id + '/edit'">
                    <p class="text-sm">{{ service.name }}</p>
                    <div class="text-sm text-gray-500 text-center mt-1" v-if="service.pivot.price">{{ service.pivot.price }} تومان</div>
                    <div class="text-sm text-gray-500 text-center mt-1" v-if="!service.pivot.price">...</div>
                </Link>
            </div>
        </section>

    </div>
</template>

<style scoped>

</style>
