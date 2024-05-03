<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <button class="block w-full px-4 py-3 text-left text-center font-bold leading-5 text-primary hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out whitespace-nowrap last:border-none">
        <slot />
    </button>
</template>
