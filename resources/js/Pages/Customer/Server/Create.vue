<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    props: {
        providers: Object,
    },
    layout: PanelLayout
}
</script>

<template>
    <Head title="providers"/>
    <header>
        <h2 class="text-xl md:text-2xl mb-12">خدمات دهندگان</h2>
    </header>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider"
                                scope="col">
                                عنوان
                            </th>
                            <th class="px-6 py-3 text-right text-s font-medium text-gray-500 uppercase tracking-wider"
                                scope="col">
                                آدرس
                            </th>
                            <th class="px-6 py-3 text-center text-s font-medium text-gray-500 uppercase tracking-wider"
                                scope="col">
                                نقشه
                            </th>
                            <th class="relative px-6 py-3" scope="col">
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
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{
                                    provider.address
                                }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-indigo-500 hover:text-indigo-600"><a
                                :href="'https://maps.google.com/?q='+ provider.lat +','+ provider.lng "
                                target="_blank">
                                <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </a></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link :href="'/customer/servers/' + provider.id + '/join'"
                                      class="text-green-500 hover:text-green-700">عضویت
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
