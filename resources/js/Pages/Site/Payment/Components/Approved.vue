<script setup>
import * as func from '@/Helpers/functions';
</script>

<script>
import Button from "@/Components/Button/Button.vue";

export default {
    name: "Approved",
    components: {
        Button,
    },
    data(){
        return{

        }
    },
}
</script>

<template>
    <div class="c-content flex flex-col justify-center flex-1 gap-3">
        <img src="/images/approved.svg" class="h-48" alt="">

        <h2 class="text-xl font-semibold text-center text-neutral">
            Pagamento Aprovado!
        </h2>
    </div>
</template>

