<script setup>
import {Head,Link, useForm} from '@inertiajs/inertia-vue3';

let form = useForm({
    first_name: '',
    last_name: '',
    phone: '',
    password: '',
    password_confirmation: '',
    type: 'customer',
    gender: 'male',
});

let submit = () => {
    form.post('/provider/users');
};
</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    layout: PanelLayout,
}
</script>

<template>
    <Head title="New User"/>
        <header class="flex justify-between mb-10">
            <h2 class="text-xl md:text-2xl text-slate-700">ثبت مشتری جدید</h2>
            <Link :href="route('provider.users')" class="text-md text-slate-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
                بازگشت
            </Link>
        </header>
        <form @submit.prevent="submit" class="flex flex-wrap space-y-4 lg:space-y-2 text-slate-700" autocomplete="off">
            <div class="w-full lg:w-1/2 mt-2">
                <label for="first-name" class="text-lg block mb-3">نام</label>
                <input v-model="form.first_name" type="text" id="first-name"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.first_name" v-text="form.errors.first_name" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label for="last-name" class="text-lg block mb-3">نام خانوادگی</label>
                <input v-model="form.last_name" type="text" id="last-name"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.last_name" v-text="form.errors.last_name" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label for="phone" class="text-lg block mb-3">شماره همراه</label>
                <input v-model="form.phone" type="text" id="phone"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300">
                <div v-if="form.errors.phone" v-text="form.errors.phone" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label for="gender" class="text-lg block mb-3">جنسیت</label>
                <select v-model="form.gender" type="text" id="gender"
                        class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300 pt-1">
                    <option class="text-base" value="male">مرد</option>
                    <option class="text-base" value="female">زن</option>
                </select>
                <div v-if="form.errors.gender" v-text="form.errors.gender"
                     class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
            </div>
            <div class="w-full">
                <button type="submit" class="cursor-pointer block text-white py-2 bg-indigo-500 hover:bg-indigo-600 px-8 mt-8 rounded-xl disabled:bg-slate-300 disabled:cursor-default" :disabled="form.processing">ثبت
                    مشتری
                </button>
            </div>
        </form>

</template>
