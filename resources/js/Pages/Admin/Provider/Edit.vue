<script setup>
import PanelLayout from '@/Layouts/Panel.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    'current_provider': Object,
    'users': Object,
    'csrf': String
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
import myUpload from 'vue-image-crop-upload';
import {usePage} from "@inertiajs/inertia-vue3";

export default {
    data() {
        return {
            showUploader: false,
            params: {
                _token: this.$props.csrf,
                name: 'provider-' + usePage().props.value.auth.user.phone,
                type: 'provider',
                user_id: this.$props.current_provider.id
            },
            headers: {
                smail: '*_~'
            },
            imgDataUrl: ''
        }
    },
    computed: {
        show: {
            get () {
                return this.showUploader
            },

            set (value) {
                this.showUploader = !value
            }
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
        axios.get('/media/' + usePage().props.value.auth.user.id + '/provider')
            .then((response) => {
                if (response.data != '')
                    this.imgDataUrl = response.data
            });
    }
}
</script>

<template>
    <Head title="Edit User"/>
    <PanelLayout>
        <header class="flex justify-between mb-10">
            <h2 class="text-xl md:text-2xl text-slate-700">ویرایش سرویس دهنده</h2>
            <Link :href="route('admin.providers')" class="text-md text-slate-700 flex items-center">
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
            <Link v-if="imgDataUrl" :href="'/media/' + usePage().props.value.auth.user.id + '/avatar'"
                  class="text-red-500 mt-3 flex justify-center w-full"
                  method="delete" @click="imgDataUrl = ''">حذف تصویر
            </Link>

        </div>

        <my-upload v-model="show"
                   :headers="headers"
                   :height="100"
                   :params="params"
                   :width="100"
                   field="img"
                   img-format="png"
                   lang-type="fa"
                   noCircle="false"
                   url="/media"
                   @crop-success="cropSuccess"
                   @crop-upload-success="cropUploadSuccess"
                   @crop-upload-fail="cropUploadFail"></my-upload>

        <form autocomplete="off" class="flex flex-wrap space-y-4 lg:space-y-2 text-slate-700" @submit.prevent="submit">
            <div class="w-full lg:w-1/2 mt-2">
                <label class="text-lg block mb-3" for="title">عنوان</label>
                <input id="title" v-model="form.title"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       type="text">
                <div v-if="form.errors.title" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.title"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label class="text-lg block mb-3" for="type">نوع</label>
                <input id="type" v-model="form.type"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       list="provider_types"
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
                <input id="slug" v-model="form.slug"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       type="text">
                <div v-if="form.errors.slug" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.slug"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label class="text-lg block mb-3" for="address">آدرس</label>
                <input id="address" v-model="form.address"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       type="text">
                <div v-if="form.errors.address" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.address"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label class="text-lg block mb-3" for="lat">عرض جغرافیایی</label>
                <input id="lat" v-model="form.lat"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       type="text">
                <div v-if="form.errors.lat" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.lat"></div>
            </div>
            <div class="w-full lg:w-1/2 mt-2">
                <label class="text-lg block mb-3" for="lng">طول جغرافیایی</label>
                <input id="lng" v-model="form.lng"
                       class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300"
                       type="text">
                <div v-if="form.errors.lng" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.lng"></div>
            </div>
            <div class="w-full lg:w-1/2">
                <label class="text-lg block mb-3" for="user">کاربر</label>
                <select id="user" v-model="form.user_id"
                        class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300 pt-1"
                        type="text">
                    <option class="text-base" disabled value="-1">انتخاب کنید..</option>
                    <option v-for="user in users" :value="user.id" class="text-base">
                        {{ user.first_name + ' ' + user.last_name }}
                    </option>
                </select>
                <div v-if="form.errors.user_id" class="text-red-500 text-xs mt-1 w-full lg:w-1/2"
                     v-text="form.errors.user_id"></div>
            </div>
            <div class="pt-6 w-full flex">
                <button :disabled="form.processing"
                        class="cursor-pointer block text-white py-2 px-6 bg-indigo-500 hover:bg-indigo-600 rounded-xl disabled:bg-slate-300 disabled:cursor-default"
                        type="submit">ویرایش
                </button>
                <Link :href="'/admin/providers/' + current_provider.id" as="button"
                      class="cursor-pointer block text-red-500 hover:text-white hover:bg-red-600 py-2 px-6 border-2 rounded-xl border-red-500 hover:border-red-600 rounded-xl mr-4"
                      method="delete"
                      preserve-scroll>
                    حذف
                </Link>
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
