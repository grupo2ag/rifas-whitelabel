<script setup>
import * as func from '@/Helpers/functions';
</script>

<script>
import Icon from "@/Components/Icon/Icon.vue";
import QRCode from "@/Components/QRCode/QRCode.vue";
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
    name: "PixResponse",
    components:{
        Icon,
        QRCode,
        Button,
        VueCountdown
    },
    props: {
        raffle: Number
    },
    data() {
        return {
            expire_time: (this.raffle.pix_expired*60)*1000,
            copied: false,
            code: this.raffle.pix_code,
            copypaste: this.raffle.pix_code
        }
    },
    methods: {
        copyText(text) {
            this.copied = true;
            navigator.clipboard.writeText(text);

            setTimeout(() => {
                this.copied = false
            }, 4000)
        }
    },
    watch: {
        'expire_time'() {
            if(this.expire_time <= 0){
                //this.status = 'CANCELED'
                //console.log(this.expire_time, expire_date, actualDate);
            }
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
    <div class="c-content flex flex-col flex-1 gap-3">
        <img src="/images/bro.svg" class="h-48" alt="">

        <h2 class="text-xl font-semibold text-center text-neutral">
            Pedido Aguardando Pagamento
        </h2>

        <div class="flex items-center justify-center">
            <div class="overflow-hidden border rounded-md border-gray-light">
                <QRCode :value="code" width="200"/>
                <!--                                    <img class="w-full p-2" :src="code" alt="PIX QRCode" />-->
            </div>
        </div>

        <h4 class="mb-5 text-sm leading-tight text-center text-neutral">
            Você tem

            <vue-countdown class="font-black text-neutral w-12 inline-block" :time="expire_time"
                           :transform="transformSlotProps" v-slot="{ minutes, seconds }">
                {{ minutes }} : {{ seconds }}
            </vue-countdown>
            para efetuar o pagamento,<br> após esse tempo o Link de pagamento e o QrCode irão
            expirar.
        </h4>

        <div class="flex flex-col w-full mt-2">
            <p class="mb-2 text-xs font-bold text-center uppercase text-neutral">
                Clique no código para copiar
            </p>

            <div class="relative">
                <input type="text"
                       class="w-full p-3 pr-12 overflow-x-auto text-sm bg-content text-center text-neutral border rounded-xl border-neutral"
                       :value="copypaste" @click="copyText(copypaste)">
                <button type="button" @click="copyText(copypaste)"
                        class="absolute top-0 right-0 z-10 h-full px-3 py-2 pointer">
                    <Icon name="icon-duplicate" class="w-6 h-6 stroke-neutral"/>
                </button>

                <p v-if="copied" class="c-copied">Codigo Copiado!</p>
            </div>

            <Button type="button" color="primary"
                    class="justify-center w-full uppercase mt-2"
                    @click="copyText(code)">
                Copiar Código
            </Button>
        </div>
    </div>
</template>
