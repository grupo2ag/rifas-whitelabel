<script setup>
defineProps({
    title: String,
    valueCount: Number,
});
</script>

<template>
    <div class="w-full stats bg-primary text-primary-content">
        <div class="px-3 py-2 stat">
            <div class="flex flex-row">
                <div class="w-9/12">
                    <div class="text-primary-bw lg:stat-title">{{ title }}</div>
                    <div class="text-primary-bw stat-value">{{ valueCount ?? 0 }}</div>
                </div>
                <div class="flex items-center w-3/12">
                    <div class="flex flex-row items-center justify-end w-full">
                        <slot name="icon" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
