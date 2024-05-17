<script setup>
import {
    EnvelopeIcon,
} from '@heroicons/vue/24/outline';
defineProps({
    value: String | Number,
    textBottom: String,
    shortName: String,
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
                                <div class="w-10 h-10 bg-white border rounded-full lg:w-16 lg:h-16 text-neutral-content border-white-light">
                                    <span class="lg:text-2xl">{{ shortName }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-auto px-2">
                            <div class="stat-title text-primary-bw">{{userName}}</div>
                            <div class="stat-value text-primary-bw">{{ value }}</div>
                        </div>
                    </div>
                </div>
                <div class="w-3/12">
                    <div class="flex flex-row justify-end w-full">
                        <slot name="cup" />
                    </div>
                </div>
            </div>
            <div class="flex flex-row items-center w-full px-1">
                <EnvelopeIcon class="w-3 mr-1"/>
                <div v-if="textBottom" class="stat-desc text-primary-bw">{{ textBottom }}</div>
            </div>
        </div>
    </div>
</template>
