<script setup>
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    'current_service': Object,
    'services': Object,
});

let form = useForm({
    service_id: props.current_service.service_id,
    price: props.current_service.price,
    description: props.current_service.description,
});

let submit = () => {
    form.put('/provider/services/' + props.current_service.service_id);
};
</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    layout: PanelLayout,
}
</script>

<template>
    <Head title="Edit Service"/>
        <header class="flex justify-between mb-10">
            <h2 class="text-xl md:text-2xl text-slate-700">ویرایش سرویس</h2>
            <Link :href="route('provider.services')" class="text-md text-slate-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                بازگشت
            </Link>
        </header>
        <form @submit.prevent="submit" class="flex flex-wrap space-y-4 lg:space-y-2 text-slate-700" autocomplete="off">
            <div class="w-full lg:w-1/2 mt-2">
                <label for="gender" class="text-lg block mb-3">خدمت <small>(ضروری)</small></label>
                <select v-model="form.service_id" type="text" id="gender"
                        class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300 pt-1">
                    <option v-for="service in services" class="text-base" :value="service.id">{{ service.name }} ({{ service.gender }})</option>
                </select>
                <div v-if="form.errors.gender" v-text="form.errors.gender"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>

            <div class="w-full lg:w-1/2">
                <label for="price" class="text-lg block mb-3">قیمت (تومان)</label>
                <input v-model="form.price" type="number" id="price"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.price" v-text="form.errors.price"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>

            <div class="w-full">
                <label for="description" class="text-lg block mb-3">توضیحات</label>
                <input v-model="form.description" type="text" id="description"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.description" v-text="form.errors.description"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="pt-6 w-full flex">
                <button type="submit"
                        class="cursor-pointer block text-white py-2 px-6 bg-indigo-500 hover:bg-indigo-600 rounded-xl disabled:bg-slate-300 disabled:cursor-default"
                        :disabled="form.processing">ویرایش
                </button>
                <Link :href="'/provider/services/' + current_service.service_id" preserve-scroll method="delete" as="button"
                      class="cursor-pointer block text-red-500 hover:text-white hover:bg-red-600 py-2 px-6 border-2 rounded-xl border-red-500 hover:border-red-600 rounded-xl mr-4">
                    حذف
                </Link>
            </div>

        </form>

</template>
