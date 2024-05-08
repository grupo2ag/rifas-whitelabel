<script setup>
import { computed, useSlots } from 'vue';

defineEmits(['submitted']);

defineProps({
    heigth: String
})

const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
    <div class="w-full">
        <div >
            <form @submit.prevent="$emit('submitted')">
                <div class="px-4 py-5 sm:p-6"
                    :class="hasActions ? (heigth ? 'sm:rounded-tl-md sm:rounded-tr-md'+ ' ' +heigth : 'sm:rounded-tl-md sm:rounded-tr-md') : (heigth ? 'sm:rounded-md'+ ' ' + heigth : 'sm:rounded-md')"
                    >
                    <slot name="form" />
                </div>

                <div v-if="hasActions"
                    class="flex items-center justify-end px-4 py-3 text-end sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <slot name="actions" />
                </div>
            </form>
        </div>
    </div>
</template>
