<template>
    <p class="text-primary text-sm mb-0.5">Progresso da Rifa {{ value }}/ {{ max }}</p>
    <progress :value="value" :max="max"></progress>
</template>

<script>
export default {
    name: "Progress",
    props: {
        max: String,
        value: String,
    }
}
</script>

<style lang="scss" scoped>
progress {
    @apply w-full h-2 block;
}

progress::-webkit-progress-bar {
    @apply bg-base-100 rounded-md;
}

progress::-webkit-progress-value {
    @apply bg-primary rounded-md;
}

progress::-moz-progress-bar {
    @apply bg-base-100 rounded-md;
}
</style>
