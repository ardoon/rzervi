<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';

defineProps({
    requests: Object
})

let checkDate = (date) => {
    let requestDate = new Date(date)
    if (requestDate.getTime() < Date.now()) {
        return false
    }
    return true
}
</script>

<script>
import Echo from "laravel-echo";
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    components: {
        Echo,
    },
    layout: PanelLayout,
    data() {
        return {
            list: this.requests
        }
    },
    computed: {
        user() {
            return this.$page.props.auth.user
        }
    },
    methods: {
        showComment(comment) {
            alert(comment)
        }
    },
    mounted() {
        window.Echo.private(`users.${this.user.id}`)
            .listen('BookingNotification', (e) => {
                if (e.mode === 'store') {
                    this.requests.push(e.request)
                } else if (e.mode === 'update') {
                    let index = this.requests.findIndex(item => item.id === e.request.id)
                    this.requests.splice(index, 1)
                    this.requests.splice(index, 0, e.request);
                } else {
                    this.requests.splice(this.requests.findIndex(item => item.id === e.request.id), 1)
                }
            });
    }
}
</script>

<template>
    <Head title="Requests"/>
    <header>
        <h2 class="text-xl md:text-2xl mb-12">درخواست های رزرو</h2>
    </header>

    <Link :href="route('customer.requests.create')" class="block mb-3 text-indigo-500 hover:text-indigo-600">
        رزرو جدید
    </Link>

    <section class="mt-5 flex flex-wrap gap-10">

        <div v-for="request in requests"
             class="bg-gray-50 flex hover:shadow-blue-300 w-full lg:w-72 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 text-md text-gray-600">
            <img v-for="img in request.responder.avatar" :src="img.path" alt=""
                 class="h-28 w-28 mr-2 mt-2 rounded-xl">
            <div class="mt-3 pr-3 relative flex-grow">

                <h4 class="font-normal">{{ request.responder.title }}</h4>
                <p class="font-normal text-sm mt-2">زمان: {{ request.date['persian'] }}</p>
                <p class="font-normal text-sm my-2">وضعیت: {{ request.status }}</p>

                <div class="lg:absolute lg:left-4 lg:bottom-2 mt-0 sm:mt-2 lg:mt-0 flex">
                    <Link v-if="request.status === 'در انتظار تایید'" :href="'/customer/requests/' + request.id + '/edit'" class="text-indigo-600 hover:text-indigo-900 font-normal text-sm" preserve-scroll>ویرایش</Link>
                    <Link v-if="request.status === 'تایید شده' && checkDate(request.date['original'])" :href="'/customer/requests/' + request.id + '/cancel'" method="post" preserve-scroll class="text-red-600 hover:text-red-900 font-normal text-sm">لغو رزرو</Link>
                    <Link v-if="request.status === 'رد شده' || request.status === 'لغو شده'" :href="'/customer/requests/' + request.id"  method="delete" preserve-scroll class="text-red-600 hover:text-red-900 font-normal text-sm">حذف</Link>
                </div>

            </div>
        </div>

    </section>

</template>
