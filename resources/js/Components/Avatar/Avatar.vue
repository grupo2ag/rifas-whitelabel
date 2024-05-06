<script setup>
defineProps({
    name: String,
});
// export default {

// }
</script>
<template>
    <div class="avatar placeholder">
        <div class="w-24 rounded-full bg-neutral text-neutral-content">
            <span class="text-3xl">{{ name }}</span>
        </div>
    </div>
</template>
