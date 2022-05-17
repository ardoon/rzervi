<script>
import DatePicker from 'vue3-persian-datetime-picker'
import PanelLayout from '@/Layouts/Panel.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import Echo from 'laravel-echo'

export default {
    components: {
        DatePicker,
        Head,
        Link,
        Echo
    },
    props: {
        current_request: Object,
        services: Object
    },
    layout: PanelLayout,
    data() {
        return {
            responder_comment: this.current_request.responder_comment
        }
    },
    methods: {
        checkDate(date) {
            let requestDate = new Date(date)
            if(requestDate.getTime() < Date.now()){
                return false
            }
            return true
        }
    }
}
</script>

<template>
    <Head title="Edit Request"/>
    <header class="flex justify-between mb-10">
        <h2 class="text-xl md:text-2xl text-slate-700">مشاهده درخواست</h2>
        <Link :href="route('provider.requests')" class="text-md text-slate-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
            بازگشت
        </Link>
    </header>

    <div class="grid grid-cols-6 text-gray-700 text-md pt-4 space-y-5 space-y-reverse">
        <h2 class="col-span-6 mb-5 font-semibold">
            مشخصات درخواست دهنده:
        </h2>
        <div class="col-span-6 lg:col-span-3 xl:col-span-2">
            درخواست دهنده:
            <Link :href="'/provider/users/' + current_request.requester.id + '/edit'">
                {{ current_request.requester.first_name }} {{ current_request.requester.last_name }}
            </Link>
        </div>
        <div class="col-span-6 lg:col-span-3 xl:col-span-2 col-start-1">
            ایمیل:
            {{ current_request.requester.email }}
        </div>
        <div class="col-span-6 lg:col-span-3 xl:col-span-2 col-start-1">
            شماره همراه:
            {{ current_request.requester.phone }}
        </div>
        <div class="col-span-6 lg:col-span-3 xl:col-span-2 col-start-1">
            زمان درخواست داده شده:
            {{ current_request.date['persian'] }}
        </div>
        <div class="col-span-6 lg:col-span-3 xl:col-span-2 col-start-1">
            وضعیت:
            {{ current_request.status }}
        </div>
        <div class="col-span-6 lg:col-span-3 xl:col-span-2 col-start-1">
            یادداشت:
            {{ current_request.requester_comment ?? 'ندارد' }}
        </div>
    </div>

    <div class="grid grid-cols-6 text-gray-700 text-md pt-2">
        <h2 class="col-span-6 mb-5 font-semibold">
            خدمات درخواست داده شده:
        </h2>
        <ul class="text-md space-y-2 col-span-6">
            <li v-for="(service, index) in services">{{ ++index }} - {{ service.name }}</li>
        </ul>
    </div>

    <hr class="my-3">

    <div>
        <input type="text" id="comment" v-model="responder_comment" placeholder="یادداشت شما" class="rounded-md h-10 w-full lg:w-1/2 border-gray-300">
    </div>

    <div class="flex text-lg mt-5">
        <Link v-if="current_request.status === 'در انتظار تایید'" :href="'/provider/requests/' + current_request.id + '/cancel'" method="post" :data="{ comment: responder_comment }" class="text-orange-600 hover:text-orange-900 ml-2">رد درخواست</Link>
        <Link v-if="current_request.status === 'در انتظار تایید' && checkDate(current_request.date['original'])" :href="'/provider/requests/' + current_request.id + '/accept'" method="post" :data="{ comment: responder_comment }" class="text-green-600 hover:text-green-900">تایید</Link>
        <Link v-if="current_request.status === 'تایید شده' && checkDate(current_request.date['original'])" :href="'/provider/requests/' + current_request.id + '/cancel'" method="post" :data="{ comment: responder_comment }" class="text-orange-600 hover:text-orange-900">لغو رزرو</Link>
        <Link v-if="current_request.status === 'رد شده' && checkDate(current_request.date['original'])" :href="'/provider/requests/' + current_request.id + '/accept'" method="post" :data="{ comment: responder_comment }" class="text-green-600 hover:text-green-900">قبول رزرو</Link>
        <Link v-if="current_request.status === 'لغو شده'" :href="'/provider/requests/' + current_request.id"  method="delete" class="text-red-600 hover:text-red-900">حذف</Link>
    </div>

</template>

<style>
.vpd-icon-btn {
    display: none;
}

element {

}

.form-control {

    border: none !important;
    background: transparent;

}
</style>
