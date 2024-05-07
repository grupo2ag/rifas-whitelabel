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
    data() {
        return {
            status: 'CANCELLED',
            loading: false
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
}
</script>

<template>
    <App>
        <section class="pt-16 md:pb-3 md:pt-24 w-full flex flex-col">
            <div class="md:container flex flex-wrap md:gap-5">


                <template v-if="loading">
                    <LoadingScreen :loading="true"/>
                </template>

                <template v-else>
                    <Waiting v-if="status == 'PROCESSING' || status == 'CREATED'" :product="product" :sale="sale"/>

                    <Approved :product="product" :sale="sale" v-else-if="status == 'PAID'"/>

                    <Cancel :product="product" :sale="sale"
                             v-else-if="status == 'CANCELLED' || status == 'REFUNDED' || status == 'CHARGEBACK'"/>

                    <div class="w-full lg:w-5/12 flex flex-col items-start md:gap-5">
                        <div class="c-content flex w-full items-center gap-3">
                            <figure class="h-20 aspect-square overflow-hidden">
                                <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                     class="w-full h-full object-cover rounded-xl" alt="">
                            </figure>
                            <div class="flex flex-col justify-between">
                                <p class="text-neutral font-bold text-lg">VITAMINI C GUMMY VITAMINI C GUMMY</p>
                                <p class="text-neutral/60">VITAMINI C GUMMY</p>
                            </div>
                        </div>

                        <div class="c-content flex w-full flex-col">

                            <h4 class="text-lg font-bold text-neutral">
                                Detalhes da Compra
                            </h4>
                            <p class="text-sm text-neutral/70 mb-2">7b156d56e87847091153f2e0623e82db</p>

                            <ul class="c-details">
                                <li class="c-details__item">
                                    Comprador
                                    <p>Luiz Henrique Meirelles</p>
                                </li>
                                <li class="c-details__item">
                                    CPF
                                    <p> 388.***.***-** </p>
                                </li>
                                <li class="c-details__item">
                                    Telefone
                                    <p>(18)****-9672</p>
                                </li>
                                <li class="c-details__item">
                                    Situação
                                    <p>Aguardando Pagamento</p>
                                </li>
                                <li class="c-details__item">
                                    Titulos
                                    <p>Os titulos são liberados após o pagamento</p>
                                </li>
                                <li class="c-details__item font-bold text-neutral">
                                    <span class=""></span>Valor Total
                                    <p class="text-lg font-bold">{{ 'R$ 0,00' }}</p>
                                </li>
                            </ul>

                        </div>
                    </div>
                </template>
            </div>
        </section>
    </App>
</template>

<style src="./style.scss" lang="scss" scoped/>
