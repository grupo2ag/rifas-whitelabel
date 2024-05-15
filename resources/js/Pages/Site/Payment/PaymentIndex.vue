<script>
import App from '@/Pages/App.vue'
import LoadingScreen from "@/Components/LoadingScreen/LoadingScreen.vue";
import Button from "@/Components/Button/Button.vue";
import VueCountdown from '@chenfengyuan/vue-countdown';
import QRCode from "@/Components/QRCode/QRCode.vue";
import Icon from "@/Components/Icon/Icon.vue";
import Waiting from "@/Pages/Site/Payment/Components/Waiting.vue";
import Approved from "@/Pages/Site/Payment/Components/Approved.vue";
import Cancel from "@/Pages/Site/Payment/Components/Cancel.vue";

export default {
    name: "ResponseIndex",
    components: {
        App,
        Waiting,
        Approved,
        Cancel,
        LoadingScreen,
        Button,
        VueCountdown,
        QRCode,
        Icon
    },
    props: {
        raffle: Object,
        status: String,
    },
    data() {
        return {
            status: !!this.status ? this.status : 'PROCESSING',
            loading: true
        }
    },
    methods: {
        copyText(text) {
            // this.click = 1
            this.copied = true;
            navigator.clipboard.writeText(text);

            setTimeout(() => {
                this.copied = false
            }, 4000)
        }
    },
    mounted() {
        let expire_date = new Date(this.raffle.expired);
        const actualDate = new Date()
        this.expire_time = expire_date - actualDate

        if(this.expire_time < 0){
            this.status = 'CANCELED'
        }
    },
    created(){
        Echo.channel(`Processed.Pix.${this.raffle.pix_id}`).listen('PixPayment', (e) => {
            console.log('websocket', e, this.raffle.pix_id)
            this.status = 'PAID'
        });
    }
}
</script>

<template>
    <App>
        <section class="pt-16 md:pb-3 md:pt-24 w-full flex flex-col">
            <div class="md:container flex flex-wrap md:gap-5">
                <Waiting v-if="status == 'PROCESSING' || status == 'CREATED'" :raffle="raffle" />

                <Approved v-else-if="status == 'PAID'"/>

                <Cancel v-else-if="status == 'CANCELED' || status == 'REFUNDED' || status == 'CHARGEBACK'"/>

                <div class="w-full lg:w-5/12 flex flex-col items-start md:gap-5">
                        <div class="c-content flex w-full items-center gap-3">
                            <figure class="h-20 aspect-square overflow-hidden" v-if="raffle.image">
                                <img :src="raffle.image"
                                     class="w-full h-full object-cover rounded-xl" alt="">
                            </figure>
                            <div class="flex flex-col justify-between">
                                <p class="text-neutral font-bold text-lg">{{ raffle.title }}</p>
                                <p class="text-neutral/60" v-if="raffle.subtitle">{{ raffle.subtitle }}</p>
                            </div>
                        </div>

                        <div class="c-content flex w-full flex-col">

                            <h4 class="text-lg font-bold text-neutral">
                                Detalhes da Compra
                            </h4>
                            <p class="text-sm text-neutral/70 mb-2">{{ raffle.pix_id }}</p>

                            <ul class="c-details">
                                <li class="c-details__item">
                                    Comprador
                                    <p>{{ raffle.name }}</p>
                                </li>
                                <li class="c-details__item">
                                    Telefone
                                    <p>+{{ raffle.phone }}</p>
                                </li>
                                <li class="c-details__item">
                                    CPF
                                    <p> {{ raffle.document }} </p>
                                </li>
                                <li class="c-details__item">
                                    E-mail
                                    <p>{{ raffle.email }}</p>
                                </li>
                                <li class="c-details__item">
                                    Situação
                                    <p>{{ status != 'PAID' ? 'Aguardando Pagamento' : 'Pago'}}</p>
                                </li>
                                <li class="c-details__item">
                                    Titulos
                                    <p>{{ status != 'PAID' ? 'Os titulos são liberados após o pagamento' : raffle.numbers  }}</p>
                                </li>
                                <li class="c-details__item font-bold text-neutral">
                                    <span class=""></span>Valor Total
                                    <p class="text-lg font-bold">{{ (raffle.amount/100).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) }}</p>
                                </li>
                            </ul>

                        </div>
                    </div>
            </div>
        </section>
    </App>
</template>

<style src="./style.scss" lang="scss" scoped/>
