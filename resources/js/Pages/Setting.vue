<script setup>
import PanelLayout from '@/Layouts/Panel.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/inertia-vue3';

let form = useForm({
    first_name: usePage().props.value.auth.user.first_name,
    last_name: usePage().props.value.auth.user.last_name,
    type: usePage().props.value.auth.user.type,
    phone: usePage().props.value.auth.user.phone,
    password: '',
    password_confirmation: '',
    gender: usePage().props.value.auth.user.gender,
    image: null,
});

let submit = () => {
    form.put('/setting/' + usePage().props.value.auth.user.id)
}

</script>


<script>
import myUpload from 'vue-image-crop-upload';
import {usePage} from "@inertiajs/inertia-vue3";

export default {
    props: {
        csrf: String
    },
    data() {
        return {
            showUploader: false,
            params: {
                _token: this.csrf,
                name: 'avatar-' + usePage().props.value.auth.user.phone,
                type: 'avatar'
            },
            headers: {
                smail: '*_~'
            },
            imgDataUrl: ''
        }
    },
    components: {
        'my-upload': myUpload
    },
    methods: {
        toggleShow() {
            this.showUploader = true;
        },
        cropSuccess(imgDataUrl, field) {
            this.imgDataUrl = imgDataUrl;
        },
    },
    mounted() {
        axios.get('/media/' + usePage().props.value.auth.user.id + '/avatar')
            .then((response) => {
                if (response.data != '')
                    this.imgDataUrl = response.data
            });
            this.timerCount = this.time
    },
}

</script>

<template>
    <Head title="Setting"/>
    <PanelLayout>
        <header class="flex justify-between mb-10">
            <h2 class="text-xl md:text-2xl text-slate-700">تنظیمات</h2>
            <Link :href="route('dashboard')" class="text-md text-slate-700 flex items-center">
                <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                بازگشت
            </Link>
        </header>

        <div class="w-32">
            <a class="text-blue-600 cursor-pointer flex justify-center w-full" @click="toggleShow">تصویر پروفایل</a>
            <img v-if="imgDataUrl" :src="imgDataUrl" class="rounded-xl w-20 h-20 mt-3 mx-auto shadow-lg border-2">
            <Link @click="imgDataUrl = ''" v-if="imgDataUrl" :href="'/media/' + usePage().props.value.auth.user.id + '/avatar'"
                  class="text-red-500 mt-3 flex justify-center w-full" method="delete">حذف تصویر
            </Link>

        </div>
        <my-upload :headers="headers"
                   :height="100"
                   :params="params"
                   :width="100"
                   field="img"
                   img-format="png"
                   lang-type="fa"
                   url="/media"
                   :noCircle="true"
                   @crop-success="cropSuccess"
                   :modelValue="showUploader"
                   @update:modelValue="showUploader = !showUploader"
        ></my-upload>


        <form autocomplete="off" class="flex flex-wrap space-y-4 lg:space-y-2 text-slate-700 mt-8"
              @submit.prevent="submit">

            <div class="w-full lg:w-1/2 mt-2">
                <label class="text-lg block mb-3" for="first-name">نام</label>
                <input id="first-name" v-model="form.first_name"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       type="text">
                <div v-if="form.errors.first_name" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.first_name"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label class="text-lg block mb-3" for="last-name">نام خانوادگی</label>
                <input id="last-name" v-model="form.last_name"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       type="text">
                <div v-if="form.errors.last_name" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.last_name"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label class="text-lg block mb-3" for="gender">جنسیت</label>
                <select id="gender" v-model="form.gender"
                        class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300 pt-1"
                        type="text">
                    <option class="text-base" value="male">مرد</option>
                    <option class="text-base" value="female">زن</option>
                </select>
                <div v-if="form.errors.gender" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.gender"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label class="text-lg block mb-3" for="phone">شماره همراه</label>
                <input id="phone" v-model="form.phone" disabled="disabled"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-200 border-2 border-gray-300"
                       type="text">
                <div>تغییر</div>
                <div v-if="form.errors.phone" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.phone"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label class="text-lg block mb-3" for="password">گذرواژه</label>
                <input id="password" v-model="form.password"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       placeholder="الزامی نمی باشد"
                       type="password">
                <div v-if="form.errors.password" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.password"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label class="text-lg block mb-3" for="password-confirmation">تکرار گذرواژه</label>
                <input id="password-confirmation" v-model="form.password_confirmation"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       type="password">
                <div v-if="form.errors.password_confirmation" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.password_confirmation"></div>
            </div>


            <div class="pt-6 w-full flex">
                <button :disabled="form.processing"
                        class="cursor-pointer block text-white py-2 px-6 bg-indigo-500 hover:bg-indigo-600 rounded-xl disabled:bg-slate-300 disabled:cursor-default"
                        type="submit">ویرایش
                </button>
            </div>

        </form>


    </PanelLayout>
</template>

<style>
.vue-image-crop-upload .vicp-wrap{
    width: 410px;
    border-radius: 18px;
}

.vicp-img{
    max-width: unset;
}

@media only screen and (max-width: 520px) {
    .vue-image-crop-upload .vicp-wrap{
        width: 310px;
        height: 470px;
        border-radius: 18px;
    }

    .vue-image-crop-upload .vicp-wrap .vicp-step1 .vicp-drop-area .vicp-hint {
        padding: 0px;
    }
}

</style>
