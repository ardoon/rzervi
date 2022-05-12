<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    props: {
        users: Object,
    },
    layout: PanelLayout
}
</script>

<template>
    <Head title="Customers"/>
        <header>
            <h2 class="text-xl md:text-2xl mb-12">مشتریان</h2>
        </header>

        <Link :href="route('provider.users.create')" class="block mb-3 text-indigo-500 hover:text-indigo-600">
            افزودن مشتری
        </Link>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">نام</th>
                                <th scope="col" class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">شماره همراه</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">ویرایش</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in users">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10" v-for="img in user.avatar">
                                            <img class="h-10 w-10 rounded-xl" :src="img.path" alt="">
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-medium text-gray-900">{{ user.first_name }} {{ user.last_name }}</div>
                                            <div class="text-sm text-gray-500">{{ user.email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ user.phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="'/provider/users/' + user.id + '/edit'" class="text-indigo-600 hover:text-indigo-900">ویرایش</Link>
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
