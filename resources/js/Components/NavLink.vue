<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'flex items-center p-2 rounded-lg border border-transparent bg-primary-bw/30 transition duration-150 ease-in-out'
        : 'flex items-center p-2 rounded-lg border border-transparent hover:border-primary-bw/30 transition duration-150 ease-in-out';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
