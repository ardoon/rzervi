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

    <section class="mt-5 flex flex-wrap gap-10">

        <Link :href="'/provider/users/' + user.id + '/edit'" v-for="user in users"
             class="bg-gray-50 flex hover:shadow-blue-300 w-full lg:w-64 h-20 font-semibold rounded-xl shadow-lg border border-gray-100 text-md text-gray-600">
            <img v-for="img in user.avatar" :src="img.path" alt=""
                 class="h-14 w-14 mr-3 mt-3 rounded-xl">

            <img v-if="user.avatar.length === 0"
                 :src="'https://ui-avatars.com/api/?name=' + user.first_name[0] + '&background=random'"
                 alt=""
                 class="h-14 w-14 mr-3 mt-3 rounded-xl">

            <div class="mt-3 pr-3 relative flex-grow">

                <h4 class="font-normal">{{ user.first_name }} {{ user.last_name }}</h4>

                <p class="font-normal mt-2">{{ user.phone }}</p>

            </div>
        </Link>

    </section>

</template>
