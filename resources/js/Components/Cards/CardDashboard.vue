<script setup>
defineProps({
    title: String,
    valueCount: Number,
});
</script>

<template>
    <div class="w-full stats bg-primary text-primary-content">
        <div class="stat">
            <div class="text-white stat-title">{{ title }}</div>
            <div class="text-white stat-value">{{ valueCount ?? 0 }}</div>
        </div>
    </div>
</template>
