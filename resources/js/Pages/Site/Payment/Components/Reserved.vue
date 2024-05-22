<script setup>
import * as func from '@/Helpers/functions';
import Approved from "@/Pages/Site/Payment/Components/Approved.vue";
</script>

<script>
import Button from "@/Components/Button/Button.vue";
import VueCountdown from '@chenfengyuan/vue-countdown';

const transformSlotProps = (props) => {
    const formattedProps = {};

    Object.entries(props).forEach(([key, value]) => {
        formattedProps[key] = value < 10 ? `0${value}` : String(value);
    });

    return formattedProps;
}

export default {
    name: "Cancel",
    components: {
        Button,
        VueCountdown,
    },
    props: {
        raffle: Object
    },
    data() {
        return {
            expire_time: (this.raffle.expired*60)*1000,
            pixGenerate: false,
            componentKey: {}
        }
    },
    methods: {
        async gerarPix(){
            //console.log(this.raffle)
            let resp = await axios.get(route('generate', this.raffle.id))
                .then((res) => {
                    return res.data.raffle
                }).catch((errors) => {
                    //console.log(errors)
                })
            //console.log(resp);
            this.$inertia.visit(route('pay',resp.pix_id))
        }
    },
    mounted() {
        let expire_date = new Date(this.raffle.expired);
        const actualDate = new Date()
        this.expire_time = expire_date - actualDate

        if(this.expire_time < 0){
            // this.status = 'CANCELED'
        }
        //console.log(this.expire_time, expire_date, actualDate);
    }
}
</script>

<template>
    <div class="c-content flex flex-col justify-center flex-1 gap-3">

        <h2 class="text-2xl font-semibold text-center text-neutral mt-2">
            Sua Reserva!
        </h2>

        <h4 class="mb-5 text-sm leading-tight text-center text-neutral">
            Você tem

            <vue-countdown class="font-black text-neutral inline-block" :time="expire_time"
                           :transform="transformSlotProps" v-slot="{ days, hours, minutes, seconds}">
                {{ days }} dias, {{ hours }} : {{ minutes }} : {{ seconds }}
            </vue-countdown>
            <br>para efetuar o pagamento dessa reserva,<br> após esse periodo a reserva irá expirar.
            <br>
            <br>
            Pagamento com baixa automatica no sistema
        </h4>

        <Button v-if="!pixGenerate" type="button" @click="this.gerarPix()">
            PAGAR
        </Button>
    </div>
</template>

