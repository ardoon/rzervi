<script setup>
import { Head } from '@inertiajs/inertia-vue3';
</script>

<script>
import PanelLayout from '@/Layouts/Panel.vue';
export default {
    layout: PanelLayout
}
</script>

<template>
    <Head title="Dashboard" />
        <header>
            <h2 class="text-xl md:text-3xl">داشبورد</h2>
        </header>
</template>
