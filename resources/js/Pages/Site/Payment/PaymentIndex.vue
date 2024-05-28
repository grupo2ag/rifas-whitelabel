<script>
import App from '@/Pages/App.vue'
import {defineAsyncComponent} from "vue";

import LoadingScreen from "@/Components/LoadingScreen/LoadingScreen.vue";
import Button from "@/Components/Button/Button.vue";
import QRCode from "@/Components/QRCode/QRCode.vue";
import Icon from "@/Components/Icon/Icon.vue";
const Reserved = defineAsyncComponent(() => import('@/Pages/Site/Payment/Components/Reserved.vue'))
const Cancel = defineAsyncComponent(() => import('@/Pages/Site/Payment/Components/Cancel.vue'))
const Approved = defineAsyncComponent(() => import('@/Pages/Site/Payment/Components/Approved.vue'))
const Waiting = defineAsyncComponent(() => import('@/Pages/Site/Payment/Components/Waiting.vue'))
import VueCountdown from '@chenfengyuan/vue-countdown';

export default {
    name: "ResponseIndex",
    components: {
        App,
        LoadingScreen,
        Button,
        QRCode,
        Icon,
        Waiting,
        Approved,
        Cancel,
        Reserved,
        VueCountdown,
    },
    props: {
        raffle: Object,
        status: String,
    },
    data() {
        return {
            status: !!this.status ? this.status : 'PROCESSING',
            loading: true,
            // expire_time: null,
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
        //console.log('aqui', this.raffle, this.status)
        let expire_date = new Date(this.raffle.expired);
        const actualDate = new Date()
        this.expire_time = expire_date - actualDate

       if(this.expire_time < 0){
            this.status = 'CANCELED'
        }



        //console.log(this.status)
    },
    created(){
        //if(typeof this.raffle.pix_id === "string" && this.raffle.pix_id.length > 0 && this.raffle.pix_id !== null){
            Echo.channel(`Processed.Pix.${this.raffle.pix_id}`).listen('PixPayment', (e) => {
                //console.log('websocket', e, this.raffle.pix_id)
                this.status = 'PAID'
            });
        //}
    },
   /* watch:{
        'expire_time': function() {
            if(this.expire_time < 0){
                this.status = 'CANCELED'
            }
        },
    }*/
}
</script>

<template>
    <App>
        <section class="pt-16 md:pb-3 md:pt-24 w-full flex flex-col">
            <div class="md:container w-full md:w-5/12 flex flex-col md:gap-2">
                <template v-if="status == 'PROCESSING' || status == 'CREATED'" >
                    <Waiting :raffle="raffle" />
                </template>

                <Approved v-else-if="status == 'PAID'" :raffle="raffle"/>

                <Cancel v-else-if="status == 'CANCELED' || status == 'REFUNDED' || status == 'CHARGEBACK'"/>

                <Reserved :raffle="raffle" v-else-if="status == 'RESERVED'"/>

                <div class="w-full flex flex-col items-start md:gap-5">
                    <div class="c-content flex w-full flex-col">
                        <div class="flex w-full items-center gap-3 mb-6">
                            <figure class="h-20 w-20 aspect-square overflow-hidden" v-if="raffle.image">
                                <img :src="raffle.image"
                                     class="w-full h-full object-cover rounded-xl" alt="">
                            </figure>
                            <div class="flex-1 flex flex-col justify-between">
                                <p class="text-neutral font-bold text-lg">{{ raffle.title }}</p>
                                <p class="text-sm text-neutral/60" v-if="raffle.subtitle">{{ raffle.subtitle }}</p>
                            </div>
                        </div>

                        <h4 class="text-lg font-bold text-neutral">
                            Detalhes da Compra
                        </h4>
                        <p class="text-sm text-neutral/70 mb-2">{{ raffle.pix_id }}</p>

<!--                            {{raffle}}-->
                        <ul class="c-details">
                            <li class="c-details__item">
                                Comprador
                                <p>{{ raffle.name }}</p>
                            </li>
                            <li class="c-details__item">
                                Telefone
                                <p>+{{ raffle.phone }}</p>
                            </li>
                            <li v-if="raffle.document" class="c-details__item">
                                CPF
                                <p> {{ raffle.document }} </p>
                            </li>
                            <li class="c-details__item">
                                E-mail
                                <p>{{ raffle.email }}</p>
                            </li>
                            <li class="c-details__item">
                                Situação
                                <p>{{ status === 'PAID' ? 'Pago' : status === 'CANCELED' ? 'Cancelado' : status === 'RESERVED' ? 'Reservado' : 'Aguardando Pagamento'}}</p>
                            </li>
                            <li class="c-details__item">
                                Títulos

                                <template v-if="(status === 'RESERVED' || raffle.type === 'manual') || (raffle.type === 'manual' || status === 'PAID')">
                                    <div class="flex flex-wrap gap-0.5 mt-1 mb-2">
                                        <template v-for="item in raffle.numbers.split(',')">
                                            <span class="w-16 border border-primary/20 bg-primary/5 text-neutral font-semibold py-1 text-sm text-center">{{item}}</span>
                                        </template>
                                    </div>
                                </template>
                                <template v-else>
                                    <p>Os títulos são liberados após o pagamento</p>
                                </template>
                            </li>
                            <li class="c-details__item">
                                Quantidade
                                <p> {{ status !== 'PAID' ? raffle.reserved :  raffle.paid }} </p>
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
