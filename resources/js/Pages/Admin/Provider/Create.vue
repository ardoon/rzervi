<script setup>
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';

defineProps({
    users: Object
});

let form = useForm({
    title: '',
    type: '',
    slug: '',
    address: '',
    lat: '',
    lng: '',
    user_id: '-1',
});

let submit = () => {
    form.post('/admin/providers');
};
</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    layout: PanelLayout,
}
</script>

<template>
    <Head title="New Service"/>
    <header class="flex justify-between mb-10">
        <h2 class="text-xl md:text-2xl text-slate-700">سرویس دهنده جدید</h2>
        <Link :href="route('admin.providers')" class="text-md text-slate-700 flex items-center">
            <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            بازگشت
        </Link>
    </header>
    <form autocomplete="off" class="flex flex-wrap space-y-4 lg:space-y-2 text-slate-700" @submit.prevent="submit">
        <div class="w-full lg:w-1/2 mt-2">
            <label class="text-lg block mb-3" for="title">عنوان</label>
            <input id="title" v-model="form.title" class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                   type="text">
            <div v-if="form.errors.title" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                 v-text="form.errors.title"></div>
        </div>
        <div class="w-full lg:w-1/2 mt-2">
            <label class="text-lg block mb-3" for="type">نوع</label>
            <input id="type" v-model="form.type" class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300" list="provider_types"
                   type="text">
            <datalist id="provider_types">
                <option value="پیرایش مردانه"></option>
                <option value="سالن زیبایی"></option>
                <option value="ناخن کار"></option>
                <option value="سالن تتو"></option>
                <option value="آرایشگر زنانه"></option>
            </datalist>
            <div v-if="form.errors.type" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                 v-text="form.errors.type"></div>
        </div>
        <div class="w-full lg:w-1/2 mt-2">
            <label class="text-lg block mb-3" for="slug">نامک</label>
            <input id="slug" v-model="form.slug" class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                   type="text">
            <div v-if="form.errors.slug" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                 v-text="form.errors.slug"></div>
        </div>
        <div class="w-full lg:w-1/2 mt-2">
            <label class="text-lg block mb-3" for="address">آدرس</label>
            <input id="address" v-model="form.address" class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                   type="text">
            <div v-if="form.errors.address" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                 v-text="form.errors.address"></div>
        </div>
        <div class="w-full lg:w-1/2 mt-2">
            <label class="text-lg block mb-3" for="lat">عرض جغرافیایی</label>
            <input id="lat" v-model="form.lat" class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                   type="text">
            <div v-if="form.errors.lat" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                 v-text="form.errors.lat"></div>
        </div>
        <div class="w-full lg:w-1/2 mt-2">
            <label class="text-lg block mb-3" for="lng">طول جغرافیایی</label>
            <input id="lng" v-model="form.lng" class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                   type="text">
            <div v-if="form.errors.lng" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                 v-text="form.errors.lng"></div>
        </div>
        <div class="w-full lg:w-1/2">
            <label class="text-lg block mb-3" for="user">کاربر</label>
            <select id="user" v-model="form.user_id" class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300 pt-1"
                    type="text">
                <option class="text-base" disabled value="-1">انتخاب کنید..</option>
                <option v-for="user in users" :value="user.id" class="text-base">
                    {{ user.first_name + ' ' + user.last_name }}
                </option>
            </select>
            <div v-if="form.errors.user" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                 v-text="form.errors.user"></div>
        </div>
        <div class="mt-4 w-full">
            <button :disabled="form.processing"
                    class="cursor-pointer text-white py-2 bg-indigo-500 hover:bg-indigo-600 px-6 rounded-xl disabled:bg-slate-300 disabled:cursor-default"
                    type="submit">ثبت
                سرویس دهنده
            </button>
        </div>
    </form>

</template>
