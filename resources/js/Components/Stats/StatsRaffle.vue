<script setup>
defineProps({
    title: String,
    value: String | Number,
    textBottom: String
})
</script>

<template>
    <div class="w-full stats bg-primary text-primary-content">
        <div class="px-4 py-2 lg:stat">
            <div class="text-md lg:text-3xl stat-title text-primary-bw">{{title}}</div>
            <div class="stat-value text-primary-bw">{{value}}</div>
            <div class="flex flex-row items-center mt-1">
                <slot name="iconTextBottom"/>
                <div v-if="textBottom" class="stat-desc text-primary-bw">{{textBottom}}</div>
            </div>
        </div>
    </div>
</template>
