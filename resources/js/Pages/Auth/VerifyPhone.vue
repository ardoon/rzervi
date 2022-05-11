<script setup>
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    code: '',
});

const submit = () => {
    form.post(route('verify.phone'));
};
</script>

<script>
export default {
    props: {
        phone: String,
        name: String,
        time: Number,
    },
    data() {
        return {
            canRequest: false,
            timerCount: this.seconds,
        }
    },
    mounted() {
        this.timerCount = this.time
    },
    watch: {

        timerCount: {
            handler(value) {

                if (value <= 0) {
                    this.canRequest = true
                }

                if (value > 0) {
                    setTimeout(() => {
                        this.timerCount--;
                    }, 1000);
                }

            },
            immediate: true // This ensures the watcher is triggered upon creation
        }

    }
}
</script>

<template>
    <Head title="Register"/>
    <div class="w-full md:w-96 px-10 pt-12 mx-auto text-gray-700">

        <h1 class="text-3xl text-center w-full">لطفا کد را وارد کنید</h1>
        <p class="text-center mt-4">{{ name }} عزیز کد احراز هویت شما به شماره {{ phone }} ارسال شد.</p>

        <form class="mt-16" @submit.prevent="submit">

            <BreezeValidationErrors class="mb-8" />

            <div class="relative mt-4 border-b-2 focus-within:border-blue-500 mb-10">
                <input type="text" id="code" name="code" v-model="form.code" placeholder=" " class="border-0 block w-full appearance-none focus:outline-none focus:ring-0 bg-transparent" />
                <label for="code" class="absolute top-2.5 -z-1 origin-0 duration-300">کد پیامک شده</label>
            </div>


            <div class="mt-6 mb-6">
                <button class="w-full bg-gray-900 text-white pt-1 pb-2 rounded-lg text-lg font-light hover:bg-gray-800" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">تایید کد</button>
            </div>
            <div class="flex justify-between">
<!--                <Link :href="route('logout')" method="post" class="text-blue-600">خارج شوید</Link>-->
                <p v-if="!canRequest" class="text-gray-600">امکان ارسال مجدد در {{timerCount}} ثانیه دیگر</p>
                <Link v-if="canRequest" :href="route('verify.phone')" class="text-blue-600">ارسال مجدد کد</Link>
            </div>

        </form>

    </div>

</template>

<style scoped>
</style>
