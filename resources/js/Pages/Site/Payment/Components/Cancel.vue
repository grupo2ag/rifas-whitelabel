<script setup>
import * as func from '@/Helpers/functions';
</script>

<script>
import Button from "@/Components/Button/Button.vue";

export default {
    name: "Cancel",
    components: {
        Button,
    },
    data() {
        return {}
    },
}
</script>

<template>
    <div class="c-content flex flex-col justify-center flex-1 gap-3">
        <img src="/images/cancel.svg" class="h-56" alt="">

        <h2 class="text-2xl font-semibold text-center text-neutral mt-2">
            Compra Cancelada!
        </h2>
    </div>
</template>

