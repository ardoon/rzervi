<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';

defineProps(
    {
        requests: Object
    }
)

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
import {usePage} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Echo,
    },
    layout: PanelLayout,
    computed: {
        user() {
            return this.$page.props.auth.user
        },
    },
    methods: {
        getAvatar(first_name, last_name) {
            this.avatar = 'https://ui-avatars.com/api/?name=' + last_name[0] + first_name[0] + '&background=random'
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

    <section class="mt-10 flex flex-wrap gap-y-10 gap-x-4">

        <div v-for="request in requests"
             class="bg-gray-50 text-center hover:shadow-blue-300 w-48 h-44 font-semibold rounded-xl shadow-lg border border-gray-100 text-md text-gray-600">
            <Link :href="'/provider/requests/' + request.id">

                <img v-for="img in request.requester.avatar" :src="img.path" alt=""
                     class="h-12 w-12 mr-2 mt-4 rounded-xl shadow-md">

                <img v-if="request.requester.avatar.length === 0"
                     :src="'https://ui-avatars.com/api/?name=' + request.requester.first_name[0] + '&background=random'"
                     alt=""
                     class="h-12 w-12 mr-2 mt-4 rounded-xl shadow-md">

                <h4 class="font-normal -mt-8 text-right mr-16">{{ request.requester.first_name }}
                    {{ request.requester.last_name }}</h4>
                <hr class="mt-6">
                <p class="font-normal text-sm mt-4">زمان: {{ request.date['persian'] }}</p>
                <p class="font-normal text-sm my-2">وضعیت: {{ request.status }}</p>

                <!--            <Link v-if="request.status === 'در انتظار تایید'" :href="'/provider/requests/' + request.id + '/cancel'"-->
                <!--                  class="text-orange-600 hover:text-orange-900 ml-2 font-normal text-sm" method="post" preserve-scroll>-->
                <!--                رد درخواست-->
                <!--            </Link>-->
                <!--            <Link v-if="request.status === 'در انتظار تایید' && checkDate(request.date['original'])"-->
                <!--                  :href="'/provider/requests/' + request.id + '/accept'"-->
                <!--                  class="text-green-600 hover:text-green-900 font-normal text-sm" method="post"-->
                <!--                  preserve-scroll>تایید-->
                <!--            </Link>-->
                <!--            <Link v-if="request.status === 'تایید شده' && checkDate(request.date['original'])"-->
                <!--                  :href="'/provider/requests/' + request.id + '/cancel'"-->
                <!--                  class="text-orange-600 hover:text-orange-900 font-normal text-sm" method="post"-->
                <!--                  preserve-scroll>لغو رزرو-->
                <!--            </Link>-->
                <!--            <Link v-if="request.status === 'رد شده' && checkDate(request.date['original'])"-->
                <!--                  :href="'/provider/requests/' + request.id + '/accept'"-->
                <!--                  class="text-green-600 hover:text-green-900 font-normal text-sm" method="post"-->
                <!--                  preserve-scroll>قبول رزرو-->
                <!--            </Link>-->
                <!--            <Link v-if="request.status === 'لغو شده'" :href="'/provider/requests/' + request.id"-->
                <!--                  class="text-red-600 hover:text-red-900 font-normal text-sm"-->
                <!--                  method="delete" preserve-scroll>حذف-->
                <!--            </Link>-->
            </Link>
        </div>

    </section>

</template>
