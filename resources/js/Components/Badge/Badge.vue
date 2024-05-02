<script>
export default {
    name: "Badge",
    props: {
        color: String
    }
}
</script>

<template>
    <span class="py-0.5 px-3 text-sm text-primary-bw rounded-lg" :class="'bg-' + color"><slot/></span>
</template>

<style scoped>

</style>
