<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';

defineProps({
    requests: Object
})

let checkDate = (date) => {
    let requestDate = new Date(date)
    if(requestDate.getTime() < Date.now()){
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
                } else if(e.mode === 'update') {
                    let index = this.requests.findIndex(item => item.id === e.request.id)
                    this.requests.splice(index, 1)
                    this.requests.splice( index, 0, e.request);
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
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">سرویس دهنده</th>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">تاریخ</th>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">یادداشت</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">ویرایش</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="request in requests">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10" v-for="img in request.responder.avatar">
                                            <img class="h-10 w-10 rounded-xl" :src="img.path" alt="">
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-medium text-gray-900">{{ request.responder.title }}</div>
                                            <div class="text-sm text-gray-500">{{ request.responder.type }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ request.status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ request.date['persian'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ request.responder_comment }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link v-if="request.status === 'در انتظار تایید'" :href="'/customer/requests/' + request.id + '/edit'" class="text-indigo-600 hover:text-indigo-900" preserve-scroll>ویرایش</Link>
                                    <Link v-if="request.status === 'تایید شده' && checkDate(request.date['original'])" :href="'/customer/requests/' + request.id + '/cancel'" method="post" preserve-scroll class="text-red-600 hover:text-red-900">لغو رزرو</Link>
                                    <Link v-if="request.status === 'رد شده' || request.status === 'لغو شده'" :href="'/customer/requests/' + request.id"  method="delete" preserve-scroll class="text-red-600 hover:text-red-900">حذف</Link>
                                </td>
                            </tr>

                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</template>
