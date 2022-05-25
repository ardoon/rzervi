<template>

    <div class="container lg:w-1/2 lg:mx-auto relative">

        <Head>
            <title>رزرو</title>
        </Head>

        <provider-header image="/assets/provider-header-2.jpg"/>

        <back-button
            :url="'/book/' + provider.slug"
            class="absolute left-5 top-5 h-6 w-6"/>

        <section v-if="!user"
                 class="relative text-gray-700 bg-white w-11/12 shadow-2xl rounded-r-3xl -mt-12 mr-auto pt-5 pb-12">

            <div class="text-center">

                <p class="flex justify-center font-semibold mt-2 mb-8 text-lg">
                    رزرو خود را نهایی کنید!
                </p>

                <form>
                    <input v-model="form.name" class="border-0 rounded-xl h-10 w-10/12 text-md
                        block bg-gray-200 pt-1 px-4 mx-auto mt-3 focus:outline-0 focus:ring-0" placeholder="نام شما"
                           type="text">

                    <div v-show="form.errors.date" class="mt-2">
                        <p class="text-sm text-red-600">
                            {{ form.errors.date }}
                        </p>
                    </div>

                    <input v-model="form.phone" class="border-0 rounded-xl h-10 w-10/12 text-md
                        block bg-gray-200 pt-1 px-4 mx-auto mt-3 focus:outline-0 focus:ring-0" placeholder="شماره موبایل"
                           type="text">

                    <div v-show="form.errors.date" class="mt-2">
                        <p class="text-sm text-red-600">
                            {{ form.errors.date }}
                        </p>
                    </div>

                    <button class="bg-gray-600 py-2 text-white rounded-xl absolute -bottom-5 right-1/2 w-40 -mr-20">
                        ثبت نوبت
                    </button>
                </form>

            </div>

        </section>

        <section v-if="user"
                 class="relative text-gray-700 bg-white w-11/12 shadow-2xl rounded-r-3xl -mt-12 mr-auto pt-5 pb-12">

            <div class="text-center">

                <p class="flex justify-center font-semibold mt-2 mb-8 text-lg">
                    رزرو خود را نهایی کنید!
                </p>

                <form>
                    <div class="border-0 rounded-xl h-6 w-10/12 text-md
                                px-4 mx-auto mt-3 text-right flex text-sm">
                        <span class="w-12 block font-semibold">نام</span>
                        {{ user.first_name }} {{ user.last_name }}
                    </div>

                    <div class="border-0 rounded-xl h-6 w-10/12 text-md
                                px-4 mx-auto mt-3 text-right flex text-sm">
                        <span class="w-12 block font-semibold">موبایل</span>
                        {{ user.phone }}
                    </div>

                    <button class="bg-neutral-700 py-2 text-white rounded-xl absolute -bottom-5 right-1/2 w-40 -mr-20">
                        رزرو نوبت
                    </button>
                </form>

            </div>

        </section>

        <section class="mt-16 text-gray-700 w-11/12 mr-auto px-4 pb-10">

            <h3 class="text-center font-semibold">درخواست خود را مرور کنید</h3>

            <ul class="mt-8 text-sm space-y-2">
                <li>خدمت دهنده: {{ provider.title }}</li>
                <li>زمان نوبت: {{ time }}</li>
                <li class="pt-6">
                    لیست خدمات:
                    <table class="w-full mt-2">
                        <thead>
                        <tr>
                            <th class="py-1">عنوان</th>
                            <th class="py-1 flex items-center">قیمت<span class="text-gray-500 text-xs font-light mr-1">تومان</span>
                            </th>
                            <th class="py-1">بیعانه</th>
                        </tr>

                        </thead>
                        <tbody>
                        <tr v-for="service in services">
                            <td class="py-1">{{ service.name }}</td>
                            <td class="py-1">
                                <span v-if="service.pivot.price">
                                    {{ service.pivot.price }}
                                </span>
                            </td>
                            <td class="py-1">
                                <span v-if="service.pivot.deposit">
                                    {{ service.pivot.deposit }}
                                </span>
                                <span v-if="!service.pivot.deposit">
                                    ندارد
                                </span>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                            <tr class="font-semibold">
                                <td>مجموع</td>
                                <td>{{ total }}</td>
                                <td>{{ deposit ?? '0' }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </li>
            </ul>

        </section>

    </div>

</template>

<script>
import {Head, Link, useForm} from "@inertiajs/inertia-vue3";
import providerHeader from "@/Components/partials/provider-header"
import backButton from "@/Components/svg/back-button"
import providerCallButton from "@/Components/partials/provider-call-button";

import moment from "moment-jalaali";
import fa from "moment/locale/fa";

moment.locale("fa", fa);
moment.loadPersian({dialect: 'persian-modern'})

export default {
    name: "Booking",
    props: {
        user: {
            default: null,
            type: Object
        },
        provider: Object,
        server: Number,
        date: String,
        srvs: Array,
        services: Object,
        total: Number
    },
    components: {
        Head,
        vueLink: Link,
        providerHeader,
        backButton,
        providerCallButton,
    },
    data() {
        return {
            form: useForm({
                server: this.server,
                date: this.date,
                srvs: this.srvs,
            })
        }
    },
    computed: {
        time() {
            let jalali = moment(this.date, 'jYYYY/jM/jD HH:mm')
            return jalali.format("dddd jDD jMMMM jYYYY ساعت HH:mm")
        }
    },
    methods: {
        submit() {
            this.form.post('/book/' + this.provider.id);
        },
    },
}

</script>

<style>

</style>
