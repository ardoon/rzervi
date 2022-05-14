<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import {Head, useForm, Link} from '@inertiajs/inertia-vue3';

const props = defineProps({
    phone: String,
    token: String,
});

const form = useForm({
    token: props.token,
    phone: props.phone,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Reset Password"/>
    <div class="w-full md:w-96 px-10 pt-24 mx-auto text-gray-700">

        <div class="mb-8 text-sm text-gray-600">
            <b class="text-xl block">لطفاً گذرواژه جدید خود را وارد کنید</b>
        </div>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <div class="relative mt-10 border-b-2 focus-within:border-blue-500 mb-10">
                <input id="phone" v-model="form.phone" autocomplete="off" class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" name="phone" placeholder=" "
                       type="text"/>
                <label class="absolute top-2.5 -z-1 origin-0 duration-300" for="phone">شماره موبایل</label>
            </div>

            <div class="relative mt-8 border-b-2 focus-within:border-blue-500 mb-10">
                <input id="password" v-model="form.password" autocomplete="off" class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" placeholder=" "
                       type="password"/>
                <label class="absolute top-2.5 -z-1 origin-0 duration-300" for="password">گذرواژه</label>
            </div>

            <div class="relative mt-8 border-b-2 focus-within:border-blue-500 mb-10">
                <input id="password_confirmation" v-model="form.password_confirmation" autocomplete="off" class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" placeholder=" "
                       type="password"/>
                <label class="absolute top-2.5 -z-1 origin-0 duration-300" for="password_confirmation">تکرار گذرواژه</label>
            </div>

            <div class="flex justify-between mt-4">
                <Link class="text-center items-center text-blue-700 pt-2">
                    <Link :href="route('login')" class="text-blue-700 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                                                                                              stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg> بازگشت</Link>
                </Link>
                <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md text-sm text-white hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                    بازیابی گذرواژه
                </button>
            </div>
        </form>
    </div>
</template>
