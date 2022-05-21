<template>

    <div class="container lg:w-1/2 lg:mx-auto relative">

        <Head>
            <title>رزرو {{ provider.title }}</title>
        </Head>

        <img
            :alt="provider.title"
            class="min-w-full max-h-1/3%"
            height="300"
            src="/assets/provider-header-2.jpg">

        <back-button
            :url="'/providers/' + provider.slug"
            class="absolute left-5 top-5 h-6 w-6"/>

    </div>

    <section class="relative text-gray-700 bg-white w-11/12 shadow-2xl rounded-3xl -mt-12 mx-auto pt-5 pb-8">

        <header class="text-2xl text-center">
            <h1>رزرو {{ provider.title }}</h1>
        </header>

        <div class="mt-10 text-center">

            <p class="flex justify-center">
                <clock-icon class="w-6 h-6 ml-1 text-gray-600 mb-1"/>
                زمان مورد نظر را انتخاب کنید
            </p>

            <DatePicker v-model="form.date"
                        :disable="checkDate"
                        :jump-minute="5"
                        :min="nowTime"
                        :round-minute="true"
                        class="rounded-xl h-10 w-10/12 text-lg
                        block bg-gray-200 pt-1 mx-auto mt-3"
                        display-format="dddd jDD jMMMM jYYYY  HH:mm"
                        placeholder="کلیک کنید"
                        type="datetime">
            </DatePicker>

            <input-error :message="form.errors.date" class="mt-2"></input-error>

        </div>

    </section>

    <section class="mt-16 px-6 text-gray-700">

        <header>
            <h2 class="flex justify-center items-center">
                خدمات مورد نیاز را انتخاب کنید
            </h2>
        </header>

        <div class="w-full lg:w-11/12 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-8 pb-10 text-sm">
            <div v-for="service in services"
                 :class="{'ring-2 ring-gray-600 ring-offset-2 bg-gray-600 text-white': form.srvs.includes(service.id),
                          'ring-1 ring-gray-300 ring-offset-2': !form.srvs.includes(service.id) }"
                 class="h-20 bg-gray-200 rounded-xl p-2 text-gray-600 text-center cursor-pointer"
                 @click="add_service(service.id)">

                <p class="text-center mb-2" :class="{'mt-5': !service.pivot.price, 'mt-2': service.pivot.price}">{{ service.name }}</p>
                <p class="text-center" v-show="service.pivot.price">{{ service.pivot.price }}</p>

            </div>
        </div>

    </section>

    <vue-link
        :disabled="form.processing"
        class="w-40 bg-gray-800 text-white disabled:bg-slate-300 disabled:cursor-default
        block mx-auto py-2 mb-5 text-center rounded-lg shadow-lg"
        as="button"
        @click="submit">

        رزرو کن!

    </vue-link>


</template>

<script>
import {Head, useForm} from "@inertiajs/inertia-vue3";
import backButton from "@/Components/svg/back-button"
import DatePicker from 'vue3-persian-datetime-picker'
import inputError from '@/Components/inputError'
import clockIcon from "@/Components/svg/clock-icon"
import {Link} from '@inertiajs/inertia-vue3';

export default {
    name: "Booking",
    props: {
        provider: Object
    },
    components: {
        Head,
        backButton,
        DatePicker,
        inputError,
        clockIcon,
        vueLink: Link,
    },
    data() {
        return {
            services: null,
            form: useForm({
                server: this.provider.id,
                date: '',
                requester_comment: '',
                srvs: [],
            })
        }
    },
    computed: {
        nowTime() {
            let nowGregorian = new Date()
            let nowJalali = new Date().toLocaleDateString('fa-IR');
            nowJalali = nowJalali.replace(/([۰-۹])/g, token => String.fromCharCode(token.charCodeAt(0) - 1728))
            let nowStr = nowJalali + ' ' + nowGregorian.getHours() + ':' + nowGregorian.getMinutes()
            return nowStr
        }
    },
    methods: {
        submit() {
            if (this.form.srvs.length > 0)
                this.form.post('/customer/requests');
            else
                alert('حداقل یک خدمت رو باید انتخاب کنید');
        },
        checkDate(formatted, dateMoment, checkingFor) {

            let today = new Date();
            let yesterday = new Date().setDate(today.getDate() - 1);

            return (
                dateMoment.locale('en') < yesterday
            )
        },
        add_service(id) {
            if (this.form.srvs.includes(id)) {
                delete this.form.srvs[this.form.srvs.indexOf(id)]

                this.form.srvs = this.form.srvs.filter(function (x) {
                    return x !== undefined;
                });

            } else {
                this.form.srvs.push(id);
            }
        }
    },
    mounted() {
        this.services =
            this.form.srvs = []
        axios
            .get('/providers/' + this.provider.id + '/get')
            .then(response => (this.services = response.data))
    }
}

</script>

<style>
.vpd-icon-btn {
    display: none;
}

element {

}

.vpd-input-group .form-control {
    border: none !important;
    background: transparent;
    width: 100%;
    text-align: center;
}

.vpd-controls svg, .vpd-time-column svg {
    display: initial;
}

.vpd-content {
    border-radius: 20px;
}

.vpd-header {
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    background-color: rgb(17, 24, 39) !important;
}

.vpd-selected .vpd-day-effect {
    background-color: rgb(17, 24, 39) !important;
}

.vpd-actions {
    text-align: center;
}

.vpd-actions button {
    color: rgb(17, 24, 39) !important;
}

.vpd-month-label > span:hover {
    border: none !important;
}

.vpd-container {
    top: 40%;
}
</style>
