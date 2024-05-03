<template>
    <div v-if="!!message" class="flex mt-1 relative">
        <p class="text-xs bg-red font-semibold text-white py-0.5 px-1 rounded">
            {{ message }}
        </p>
    </div>
</template>

<script>
export default {
    props: {
        message: String
    }
}
</script>

<style scoped>

</style>
