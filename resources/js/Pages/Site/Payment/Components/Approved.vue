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
    props: {
        raffle: Object
    },
    data(){
        return{

        }
    },
    mounted() {
        console.log(this.raffle)
        setTimeout(() => {
            window.fbq('track', 'Purchase', {
                content_ids: this.raffle.id,
                content_type: 'raffle',
                currency: 'BRL',
                value: this.raffle.amount / 100,
                num_items:  this.raffle.paid
            });
        }, 3500)
    }
}
</script>

<template>
    <div class="c-content flex flex-col justify-center flex-1 gap-3">
        <img src="/images/approved.svg" class="h-48" alt="">

        <h2 class="text-2xl font-semibold text-center text-neutral">
            Pagamento Aprovado!
        </h2>
    </div>
</template>

