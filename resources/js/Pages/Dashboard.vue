<script setup>
import {Head, Link, usePage} from '@inertiajs/inertia-vue3';
import {computed} from 'vue'

const user = computed(() => usePage().props.value.auth.user)
</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';

export default {
    layout: PanelLayout
}
</script>

<template>
    <Head title="Dashboard"/>
    <header>
        <h2 class="text-xl md:text-3xl">داشبورد</h2>
        <p class="mt-3">به پلتفرم آنلاین مدیریت و رزرو نوبت آنلاین خوش آمدید!</p>

        <section class="mt-10 flex flex-wrap justify-center lg:justify-start gap-5">
            <div v-if="user.type == 'admin'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('admin.users')">
                    <svg class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                    کاربران
                </Link>
            </div>

            <div v-if="user.type == 'admin'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('admin.services')">
                    <svg class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                    سرویس ها
                </Link>
            </div>

            <div v-if="user.type == 'admin'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('admin.providers')">
                    <svg class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                    سرویس دهندگان
                </Link>
            </div>

            <!--        PROVIDERS        -->
            <div v-if="user.type == 'provider'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('provider.users')">
                    <svg class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                    مشتریان
                </Link>
            </div>

            <div v-if="user.type == 'provider'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('provider.services')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    خدمات
                </Link>
            </div>

            <div v-if="user.type == 'provider'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('provider.requests')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 3l-6 6m0 0V4m0 5h5M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                    </svg>
                    رزرواسیون
                </Link>
            </div>

            <!--        CUSTOMERS         -->

            <div v-if="user.type == 'customer'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('customer.requests.create')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3h5m0 0v5m0-5l-6 6M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                    </svg>
                    رزرو جدید
                </Link>
            </div>

            <div v-if="user.type == 'customer'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('customer.servers')">
                    <svg class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    خدمت دهندگان
                </Link>
            </div>

            <div v-if="user.type == 'customer'"
                 class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('customer.requests')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-auto mb-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    رزرواسیون
                </Link>
            </div>

            <div
                class="bg-gray-50 cursor-pointer hover:shadow-blue-300 w-32 h-32 font-semibold rounded-xl shadow-lg border border-gray-100 flex items-center justify-center text-md text-gray-600">
                <Link :href="route('setting')">
                    <svg class="h-7 w-7 mx-auto mb-2 text-gray-600"
                         fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    تنظیمات
                </Link>
            </div>

        </section>
    </header>
</template>
