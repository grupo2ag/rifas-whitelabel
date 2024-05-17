<script setup>
import { computed } from 'vue';

const props = defineProps({
    size: String,
    color: String,
    type: String,
    disabled: {
        type: Boolean,
        default: false,
    },
    loading: {
        type: Boolean,
        default: false,
    }
});

const defaultClasses = computed(() => 'whitespace-nowrap rounded-lg text-center focus:outline-none transition');

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'xs':
            return 'text-xs px-1 py-1';
        case 'sm':
            return 'text-sm px-4 py-1.5';
        case 'lg':
            return 'text-lg px-7 py-3';
        default:
            return 'text-base leading-none px-4 py-3.5';
    }
});

const colorsClasses = computed(() => {
    switch (props.color) {
        case 'success':
            return 'bg-success text-success-bw';
        case 'warning':
            return 'bg-warning text-warning-bw';
        case 'black':
            return 'bg-black text-black-bw';
        default:
            return '';
    }
});

</script>

<template>
    <span class="py-0.5 px-3 text-sm rounded-lg"
          :class="[defaultClasses, sizeClasses, colorsClasses]">
        <slot/>
    </span>
</template>
