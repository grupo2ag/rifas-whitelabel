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

const defaultClasses = computed(() => 'whitespace-nowrap  text-center focus:outline-none transition');

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'xs':
            return 'text-xs px-2 py-1 rounded-lg';
        case 'sm':
            return 'text-sm px-3 py-1.5 rounded-xl';
        case 'lg':
            return 'text-lg px-7 py-3';
        default:
            return 'text-base leading-none px-4 py-3.5';
    }
});

const colorsClasses = computed(() => {
    switch (props.color) {
        case 'primary':
            return 'bg-primary text-primary-bw';
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
    <span :class="[defaultClasses, sizeClasses, colorsClasses]">
        <slot/>
    </span>
</template>
