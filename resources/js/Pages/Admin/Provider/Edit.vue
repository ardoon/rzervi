<script setup>
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    'current_provider': Object,
    'users': Object
});

let form = useForm({
    title: props.current_provider.title,
    type: props.current_provider.type,
    slug: props.current_provider.slug,
    address: props.current_provider.address,
    lat: props.current_provider.lat,
    lng: props.current_provider.lng,
    user_id: props.current_provider.user_id
});

let submit = () => {
    form.put('/admin/providers/' + props.current_provider.id);
};
</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    layout: PanelLayout,
}
</script>

<template>
    <Head title="Edit User"/>
        <header class="flex justify-between mb-10">
            <h2 class="text-xl md:text-2xl text-slate-700">ویرایش سرویس دهنده</h2>
            <Link :href="route('admin.providers')" class="text-md text-slate-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                بازگشت
            </Link>
        </header>
        <form @submit.prevent="submit" class="flex flex-wrap space-y-4 lg:space-y-2 text-slate-700" autocomplete="off">
            <div class="w-full lg:w-1/2 mt-2">
                <label for="title" class="text-lg block mb-3">عنوان</label>
                <input v-model="form.title" type="text" id="title"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.title" v-text="form.errors.title"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label for="type" class="text-lg block mb-3">نوع</label>
                <input v-model="form.type" type="text" id="type" list="provider_types"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <datalist id="provider_types">
                    <option value="پیرایش مردانه"></option>
                    <option value="سالن زیبایی"></option>
                    <option value="ناخن کار"></option>
                    <option value="سالن تتو"></option>
                    <option value="آرایشگر زنانه"></option>
                </datalist>
                <div v-if="form.errors.type" v-text="form.errors.type"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label for="slug" class="text-lg block mb-3">نامک</label>
                <input v-model="form.slug" type="text" id="slug"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.slug" v-text="form.errors.slug"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label for="address" class="text-lg block mb-3">آدرس</label>
                <input v-model="form.address" type="text" id="address"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.address" v-text="form.errors.address"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label for="lat" class="text-lg block mb-3">عرض جغرافیایی</label>
                <input v-model="form.lat" type="text" id="lat"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.lat" v-text="form.errors.lat"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label for="lng" class="text-lg block mb-3">طول جغرافیایی</label>
                <input v-model="form.lng" type="text" id="lng"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.lng" v-text="form.errors.lng"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label for="user" class="text-lg block mb-3">کاربر</label>
                <select v-model="form.user_id" type="text" id="user"
                        class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300 pt-1">
                    <option class="text-base" value="-1" disabled>انتخاب کنید..</option>
                    <option class="text-base" v-for="user in users" :value="user.id">{{ user.first_name + ' ' + user.last_name }}</option>
                </select>
                <div v-if="form.errors.user_id" v-text="form.errors.user_id"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="pt-6 w-full flex">
                <button type="submit"
                        class="cursor-pointer block text-white py-2 px-6 bg-indigo-500 hover:bg-indigo-600 rounded-xl disabled:bg-slate-300 disabled:cursor-default"
                        :disabled="form.processing">ویرایش
                </button>
                <Link :href="'/admin/providers/' + current_provider.id" preserve-scroll method="delete" as="button"
                      class="cursor-pointer block text-red-500 hover:text-white hover:bg-red-600 py-2 px-6 border-2 rounded-xl border-red-500 hover:border-red-600 rounded-xl mr-4">
                    حذف
                </Link>
            </div>

        </form>

</template>
