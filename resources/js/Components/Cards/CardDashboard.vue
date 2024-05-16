<script setup>
defineProps({
    title: String,
    valueCount: Number,
});
</script>

<template>
    <div class="w-full stats bg-primary text-primary-content">
        <div class="px-3 py-1 lg:stat">
            <div class="text-content lg:stat-title">{{ title }}</div>
            <div class="text-content stat-value">{{ valueCount ?? 0 }}</div>
        </div>
    </div>
</template>
