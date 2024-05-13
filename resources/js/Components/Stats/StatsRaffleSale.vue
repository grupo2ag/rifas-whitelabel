<script setup>
defineProps({
    title: String,
    value: String | Number,
    textBottom: String,
    userName: String
})
</script>

<template>
    <div class="w-full stats bg-primary text-primary-content">
        <div class="px-2 py-1 lg:!stat">

            <div class="flex flex-row flex-wrap items-start mb-2">
                <div class="w-9/12">
                    <div class="flex flex-row items-center">
                        <div class="flex justify-start w-auto">
                            <div class="avatar placeholder">
                                <div class="w-10 h-10 rounded-full lg:w-16 lg:h-16 bg-neutral text-neutral-content">
                                    <span class="lg:text-2xl">{{ userName }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-auto px-2">
                            <div class="stat-title text-content">Donald Duck</div>
                            <div class="stat-value text-content">{{ value }}</div>
                        </div>
                    </div>
                </div>
                <div class="w-3/12">
                    <div class="flex flex-row justify-end w-full">
                        <slot name="cup" />
                    </div>
                </div>
            </div>
            <div class="flex flex-row w-full">
                <div v-if="textBottom" class="stat-desc text-content">{{ textBottom }}</div>
            </div>
        </div>
    </div>
</template>
