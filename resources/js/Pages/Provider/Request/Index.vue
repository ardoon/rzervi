<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';

defineProps(
    {
        requests: Object
    }
)

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
    computed: {
        user() {
            return this.$page.props.auth.user
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

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">مشتری</th>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">تاریخ</th>
                                <th scope="col" class="px-6 py-3 text-center text-s font-medium text-gray-500 uppercase tracking-wider">مشاهده</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">ویرایش</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="request in requests">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10" v-for="img in request.requester.avatar">
                                            <img class="h-10 w-10 rounded-xl" :src="img.path" alt="">
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-medium text-gray-900">{{ request.requester.first_name }} {{ request.requester.last_name }}</div>
                                            <div class="text-sm text-gray-500">{{ request.requester.phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ request.status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ request.date['persian'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500"><Link :href="'/provider/requests/' + request.id" class="flex justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </Link></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link v-if="request.status === 'در انتظار تایید'" :href="'/provider/requests/' + request.id + '/cancel'" method="post" preserve-scroll class="text-orange-600 hover:text-orange-900 ml-2">رد درخواست</Link>
                                    <Link v-if="request.status === 'در انتظار تایید' && checkDate(request.date['original'])" :href="'/provider/requests/' + request.id + '/accept'" method="post" preserve-scroll class="text-green-600 hover:text-green-900">تایید</Link>
                                    <Link v-if="request.status === 'تایید شده' && checkDate(request.date['original'])" :href="'/provider/requests/' + request.id + '/cancel'" method="post" preserve-scroll class="text-orange-600 hover:text-orange-900">لغو رزرو</Link>
                                    <Link v-if="request.status === 'رد شده' && checkDate(request.date['original'])" :href="'/provider/requests/' + request.id + '/accept'" method="post" preserve-scroll class="text-green-600 hover:text-green-900">قبول رزرو</Link>
                                    <Link v-if="request.status === 'لغو شده'" :href="'/provider/requests/' + request.id"  method="delete" preserve-scroll class="text-red-600 hover:text-red-900">حذف</Link>
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
