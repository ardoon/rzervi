<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';

defineProps({
    'providers': Object
});
</script>

<script>
import Layout from "../../../Layouts/Panel";

export default {
    layout: Layout,
}
</script>

<template>
    <Head title="Providers"/>
    <div>
        <header>
            <h2 class="text-xl md:text-2xl mb-12 text-slate-700">سرویس دهندگان</h2>
        </header>

        <Link :href="route('admin.providers.create')" class="block mb-3 text-indigo-500 hover:text-indigo-600">
            افزودن سرویس دهنده
        </Link>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">
                                    عنوان
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">
                                    نامک
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider">
                                    آدرس
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-s font-medium text-gray-500 uppercase tracking-wider">
                                    نقشه
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">ویرایش</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="provider in providers">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10" v-for="img in provider.avatar">
                                            <img class="h-10 w-10 rounded-xl" :src="img.path" alt="">
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-medium text-gray-900">{{ provider.title }}</div>
                                            <div class="text-sm text-gray-500">{{ provider.type }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ provider.slug }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{
                                        provider.address
                                    }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-indigo-500 hover:text-indigo-600"><a
                                    :href="'https://maps.google.com/?q='+ provider.lat +','+ provider.lng "
                                    target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </a></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="'/admin/providers/' + provider.id + '/edit'"
                                          class="text-indigo-600 hover:text-indigo-900">ویرایش
                                    </Link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
