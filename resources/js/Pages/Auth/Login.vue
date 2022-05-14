<script setup>
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    username: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in"/>
    <div class="w-full md:w-96 px-10 pt-12 mx-auto text-gray-700">

        <h1 class="text-3xl text-center">به <span class="text-5xl font-bold text-blue-500">رزروی</span> خوش آمدید!</h1>
        <p class="text-center mt-4">پلتفرم آنلاین مدیریت و رزرو نوبت آرایشگاه</p>

<!--        <p class="text-3xl text-center mt-6 flex items-end justify-center">-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />-->
<!--            </svg>-->
<!--            ورود-->
<!--        </p>-->


        <form class="mt-16" @submit.prevent="submit">

            <BreezeValidationErrors class="mb-8" />

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div class="relative mt-4 border-b-2 focus-within:border-blue-500 mb-10">
                <input type="text" id="username" name="username" v-model="form.username" placeholder=" " class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" />
                <label for="username" class="absolute top-2.5 -z-1 origin-0 duration-300">شماره موبایل</label>
            </div>

            <div class="relative my-4 border-b-2 focus-within:border-blue-500">
                <input type="password" id="password" name="password" v-model="form.password" placeholder=" " class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" />
                <label for="password" class="absolute top-2.5 -z-1 origin-0 duration-300">گذرواژه</label>
            </div>

            <div class="mt-8 mb-4">
                <input style="border-radius: 4px;" type="checkbox" id="remember" name="remember" v-model="form.remember" placeholder=" " class="focus:ring-0 rounded-sm"/>
                <label for="remember" class="mr-2">مرا به خاطر بسپار</label>
            </div>

            <Link :href="route('password.request')" class="text-blue-700" v-if="canResetPassword">بازیابی گذرواژه</Link>

            <div class="mt-6 mb-6">
                <button class="w-full bg-gray-900 text-white pt-1 pb-2 rounded-lg text-lg font-light hover:bg-gray-800" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">ورود</button>
            </div>

            اکانت ندارید؟<Link :href="route('register')" class="text-blue-700"> ثبت نام کنید</Link>
        </form>

    </div>

</template>
