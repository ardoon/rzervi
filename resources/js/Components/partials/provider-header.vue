<template>
    <div class="min-w-full max-h-1/3% bg-fixed"
         v-bind:style="{ backgroundImage: 'url(' + image + ')', backgroundSize: '100%', height: '250px' }">
    </div>
</template>

<script>
export default {
    name: "provider-header",
    props: {
        image: String
    }
}
</script>

<style scoped>

</style>
