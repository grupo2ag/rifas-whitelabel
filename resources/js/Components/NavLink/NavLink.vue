<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);
</script>

<template>
    <a :href="href" :class="active ? 'active' : ''" class="nav-link">
        <slot />
    </a>
</template>

<style src="./style.scss" lang="scss"/>


