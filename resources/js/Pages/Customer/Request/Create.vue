<script>
import DatePicker from 'vue3-persian-datetime-picker'
import PanelLayout from '@/Layouts/Panel.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';

export default {
    components: {
        DatePicker,
        Head,
        Link
    },
    layout: PanelLayout,
    props: {
        servers: Object,
    },
    data() {
        return {
            services: null,
            form: useForm({
                server: '-1',
                date: '',
                requester_comment: '',
                srvs: [],
            })
        }
    },
    methods: {
        getServices(id) {
            this.form.srvs = []
            axios
                .get('/customer/requests/' + id + '/services')
                .then(response => (this.services = response.data))
        },
        submit() {
            if (this.form.srvs.length > 0)
                this.form.post('/customer/requests');
            else
                alert('حداقل یک خدمت رو باید انتخاب کنید');
        },
        add_service(id) {
            if (this.form.srvs.includes(id)) {
                delete this.form.srvs[this.form.srvs.indexOf(id)]

                this.form.srvs = this.form.srvs.filter(function(x) {
                    return x !== undefined;
                });

            } else {
                this.form.srvs.push(id);
            }
        }
    }
}
</script>

<template>
    <Head title="New Request"/>
    <header class="flex justify-between mb-10">
        <h2 class="text-xl md:text-2xl text-slate-700">ثبت درخواست رزرو جدید</h2>
        <Link :href="route('customer.requests')" class="text-md text-slate-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
            بازگشت
        </Link>
    </header>
    <form @submit.prevent="submit" class="flex flex-wrap space-y-4 lg:space-y-2 text-slate-700" autocomplete="off">
        <div class="w-full lg:w-1/2 mt-2">
            <label for="server" class="text-lg block mb-3">سرویس دهنده</label>
            <select v-model="form.server" id="server" @change="getServices(form.server)"
                    class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300 pt-1">
                <option disabled class="text-base" value="-1">انتخاب کنید</option>
                <option v-for="server in servers" class="text-base" :value="server.id">
                    {{ server.title }}
                </option>
            </select>
            <div v-if="form.errors.server" v-text="form.errors.server"
                 class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
        </div>

        <div class="w-full lg:w-1/2">
            <label for="date" class="text-lg block mb-3">تاریخ و زمان</label>
            <DatePicker id="date" v-model="form.date" type="datetime"
                        class="rounded-xl h-10 w-full lg:w-5/6 text-lg block bg-gray-50 border-2 border-gray-300 pt-1"></DatePicker>
            <div v-if="form.errors.date" v-text="form.errors.date"
                 class="text-red-500 text-xs mt-1 w-full lg:w-1/2"></div>
        </div>

        <div class="w-full">
            <label for="comment" class="text-lg block mb-3">یادداشت</label>
            <textarea id="comment" v-model="form.requester_comment"
                      class="rounded-xl h-20 w-full lg:w-11/12 text-lg block bg-gray-50 border-2 border-gray-300 pt-1"></textarea>
        </div>

        <div class="w-full lg:w-11/12 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 py-8">
            <div class="h-16 bg-gray-200 rounded-xl p-2 text-gray-600 text-center cursor-pointer"
                 v-for="service in services" @click="add_service(service.id)"
                 :class="{'ring-2 ring-indigo-500 ring-offset-2': form.srvs.includes(service.id), 'ring-1 ring-gray-300 ring-offset-2': !form.srvs.includes(service.id) }">
                <p class="text-center">{{ service.name }}</p>
                <p class="text-center">{{ service.pivot.price }}</p>
            </div>
        </div>
        <div class="mt-4 w-full">
            <button type="submit"
                    class="cursor-pointer text-white py-2 bg-indigo-500 hover:bg-indigo-600 px-6 rounded-xl disabled:bg-slate-300 disabled:cursor-default"
                    :disabled="form.processing">ثبت
                سرویس
            </button>
        </div>
    </form>


</template>

<style>
.vpd-icon-btn {
    display: none;
}

element {

}

.form-control {

    border: none !important;
    background: transparent;

}
</style>
