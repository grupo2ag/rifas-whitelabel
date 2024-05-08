<script setup>
    defineProps({
        height: String
    })
</script>

<template>
    <div class="px-4 py-5 sm:p-6 sm:rounded-lg">
        <slot name="content" />
    </div>
</template>
