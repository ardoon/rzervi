<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

let props = defineProps({
    provider: String,
});

const form = useForm({
    first_name: '',
    last_name: '',
    gender: '',
    phone: '',
    password: '',
    password_confirmation: '',
    provider_slug: props.provider,
    terms: false,
});



const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register"/>
    <div class="w-full sm:w-3/4 xl:w-1/2 px-10 py-12 mx-auto text-gray-700">

        <h1 class="text-3xl text-center">به <span class="text-5xl font-bold text-blue-500">رزروی</span> خوش آمدید!</h1>
        <p class="text-center my-4">پلتفرم آنلاین مدیریت و رزرو نوبت آرایشگاه</p>
        <p class="text-center mb-10 lg:mb-20">
            ثبت نام کردید؟<Link :href="route('login')" class="text-blue-700"> وارد شوید</Link>
        </p>

        <form class="grid grid-cols-6 md:gap-3 lg:gap-6" @submit.prevent="submit">

            <BreezeValidationErrors class="mb-8 col-span-6" />

            <div class="mt-6 md:mt-2 lg:mt-0 relative border-b-2 focus-within:border-blue-500 mb-4 col-span-6 md:col-span-3">
                <input type="text" id="first_name" name="first_name" v-model="form.first_name" placeholder=" " class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" />
                <label for="first_name" class="absolute top-2.5 -z-1 origin-0 duration-300">نام</label>
            </div>

            <div class="mt-6 md:mt-2 lg:mt-0 relative border-b-2 focus-within:border-blue-500 mb-4 col-span-6 md:col-span-3">
                <input type="text" id="last_name" name="last_name" v-model="form.last_name" placeholder=" " class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" />
                <label for="last_name" class="absolute top-2.5 -z-1 origin-0 duration-300">نام خانوادگی</label>
            </div>

            <div class="mt-6 md:mt-2 lg:mt-0 relative border-b-2 focus-within:border-blue-500 mb-4 col-span-6 md:col-span-3">
                <select style="background: transparent;" type="text" id="gender" name="gender" v-model="form.gender" class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent pr-3">
                    <option value="male">مرد</option>
                    <option value="female">زن</option>
                </select>
                <label for="gender" class="absolute top-2.5 -z-1 origin-0 duration-300" :class="{'transform scale-90 -translate-y-8': form.gender !== ''}">جنسیت</label>
            </div>

            <div class="mt-6 md:mt-2 lg:mt-0 relative border-b-2 focus-within:border-blue-500 mb-4 col-span-6 md:col-span-3">
                <input type="text" id="phone" v-model="form.phone" placeholder=" " class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" />
                <label for="phone" class="absolute top-2.5 -z-1 origin-0 duration-300">شماره موبایل</label>
            </div>

            <div class="mt-6 md:mt-2 lg:mt-0 relative border-b-2 focus-within:border-blue-500 mb-4 md:mb-4 col-span-6 md:col-span-3">
                <input type="password" id="password" name="password" v-model="form.password" placeholder=" " class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" />
                <label for="password" class="absolute top-2.5 -z-1 origin-0 duration-300">گذرواژه</label>
            </div>

            <div class="mt-6 md:mt-2 lg:mt-0 relative border-b-2 focus-within:border-blue-500 mb-4 md:mb-4 col-span-6 md:col-span-3">
                <input type="password" id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation" placeholder=" " class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" />
                <label for="password_confirmation" class="absolute top-2.5 -z-1 origin-0 duration-300">تکرار گذرواژه</label>
            </div>

        </form>

        <div class="mt-0 sm:mt-6 mb-6">
            <button @click="submit" class="w-full md:w-1/2 bg-green-400 text-gray-900 pt-1 pb-2 rounded-lg text-lg font-light hover:bg-green-500" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">به ما بپیوندید</button>
        </div>

    </div>
</template>

<style scoped>
</style>
