<script>
import App from '@/Pages/App.vue'
import Icon from '@/Components/Icon/Icon.vue'
import Tab from '@/Components/Tabs/Tab.vue'
import Button from '@/Components/Button/Button.vue'
import Badge from '@/Components/Badge/Badge.vue'
import Modal from '@/Components/Modal/Modal.vue'
import Progress from '@/Components/Progress/Progress.vue'
import PaymentExposed from '@/Pages/Site/Raffle/PaymentExposed/PaymentExposed.vue'
import PaymentRandom from '@/Pages/Site/Raffle/PaymentRandom/PaymentRandom.vue'
import {Tooltip, TabPanel} from 'daisyui-vue';
import {Swiper, SwiperSlide} from 'swiper/vue';
import {FreeMode, Navigation, Thumbs} from 'swiper/modules';
import {useMediaQuery} from '@vueuse/core'

import { format } from "date-fns";

import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

export default {
    components: {
        App,
        Icon,
        Tab,
        Badge,
        PaymentExposed,
        PaymentRandom,
        Button,
        Modal,
        Progress,
        Tooltip,
        TabPanel,
        Swiper, SwiperSlide
    },
    props: {
      raffle: Array
    },
    data() {
        return {
            format,
            thumbsSwiper: null,
            setThumbsSwiper: null,
            activeHeight: false,
            url: window.location.href,
            modules: [FreeMode, Navigation, Thumbs],
            galery: this.raffle?.galery,
            direction: 'vertical',
            isLargeScreen: useMediaQuery('(min-width: 768px)'),
            purchaseType: this.raffle.type == 'automatico' ? 2 : 1,
            showModal: true
        }
    },
    methods: {
        setThumbsSwiper(swiper) {
            this.thumbsSwiper = swiper;
        },
        goto(hash, position) {
            var element = document.getElementById(hash);
            var headerOffset = position;

            var elementPosition = element.offsetTop;
            var offsetPosition = elementPosition - headerOffset;
            document.documentElement.scrollTop = offsetPosition;
            document.body.scrollTop = offsetPosition; // For Safari
        },
        descricaoActive() {
            this.activeHeight = !this.activeHeight;
        },
        closeModal() {
            this.showModal = false;
            document.body.classList.toggle('active');
        },
        openModal(id) {
            this.showModal = true;
        },
    },
    mounted() {
        //console.log(this.raffle);
        /*console.log(this.destaques, this.ativas, this.finalizadas)*/
    }
}
</script>

<template>
    <App>
        <section class="pt-16 md:pt-24 md:pb-3">
            <div class="md:container">
                <div class="c-content flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-7/12 flex flex-col items-start">
                        <h1 class="text-3xl text-neutral font-bold uppercase mb-1 md:hidden">{{ raffle.title }}</h1>

                        <Badge color="primary" size="sm" class="mb-4 md:hidden">Corra</Badge>

                        <div class="w-full flex flex-col gap-6">
                            <div class="w-full flex flex-col md:flex-row gap-3 md:gap-4">
                                <div class="w-full md:w-10/12 order-1 md:order-2">
                                    <swiper
                                        :style="{
                                          '--swiper-navigation-color': '#fff',
                                          '--swiper-pagination-color': '#fff',
                                        }"
                                        :spaceBetween="10"
                                        :navigation="true"
                                        :thumbs="{ swiper: thumbsSwiper }"
                                        :modules="modules"
                                        class="mySwiper2 md:h-[500px]">
                                        <swiper-slide v-for="(item, index) in galery" :key="index">
                                            <img :src="item.img" class="aspect-square"/>
                                        </swiper-slide>
                                    </swiper>
                                </div>
                                <div class="w-full md:w-2/12 order-2 md:order-1">
                                    <swiper
                                        @swiper="setThumbsSwiper"
                                        :direction="isLargeScreen ? 'vertical' : 'horizontal'"
                                        :spaceBetween="10"
                                        :slidesPerView="5"
                                        :freeMode="true"
                                        :watchSlidesProgress="true"
                                        :modules="modules"
                                        class="mySwiper md:h-[500px]">
                                        <swiper-slide v-for="(item, index) in galery" :key="index">
                                            <img :src="item.img" class="aspect-square"/>
                                        </swiper-slide>
                                    </swiper>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-5/12 ">
                        <div class="flex flex-col items-start gap-3 relative">
                            <div class="flex flex-col items-start">
                                <h1 class="text-2xl md:text-3xl font-bold text-neutral uppercase mb-1 hidden md:block">{{ raffle.title }}</h1>

                                <Badge color="primary" size="sm" class="mb-2 hidden md:block">Corra</Badge>

                                <p class="text-neutral/70">
                                    {{ raffle?.subtitle }}
                                </p>
                            </div>

                            <div class="flex justify-between items-end">
                                <p class="text-sm text-neutral">
                                    Por apenas<br> <span class="text-3xl font-bold">{{ parseFloat( (raffle.price/100) ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) }}</span>
                                </p>
                            </div>

                            <div class="w-full">
                                <Progress :value="raffle.percent" max="100"/>
                            </div>

                            <Button type="button" color="primary" class="pulsate-fwd w-full"  @click="goto('purchase', 75)">
                                {{ raffle.status === 'Ativo' ? 'Adquira Já' : 'Finalizada' }}
                            </Button>

                            <ul class="w-full flex flex-col md:flex-row gap-3">
                                <li class="w-full md:w-auto text-sm text-neutral flex-1">
                                    Data prevista do sorteio:
                                    <p class="text-base font-bold">{{ !!raffle.expected_date ? format(new Date(raffle.expected_date), "dd/MM/yyy") : 'A Definir' }}</p>
                                </li>

                            <!--<li class="w-full md:w-auto text-sm text-neutral flex-1">
                                    Sorteio será realizado:
                                    <p class="text-base font-bold">Loteria Federal</p>
                                </li>-->
                            </ul>

                            <div class="w-full">
                                <p class="text-neutral text-sm mb-1">Compartilhe:</p>

                                <div class="w-full flex gap-1">
                                    <a :href="'https://api.whatsapp.com/send?text=' + url "
                                       target="_blank" aria-label="Whatsapp"
                                       class="bg-[#21bd5b] hover:bg-[#1da851] transition ease-in-out duration-300 text-xs text-white font-black py-2 px-3 rounded-md flex items-center">
                                        <Icon name="icon-whatsapp"
                                              class="h-4 w-4 object-contain fill-white"/>
                                    </a>
                                    <a :href="'https://telegram.me/share/url?url=' + url"
                                       target="_blank" aria-label="telegram"
                                       class="bg-[#0088cc] hover:bg-[#467dab] transition ease-in-out duration-300 text-xs text-white font-black py-2 px-3 rounded-md flex items-center">
                                        <Icon name="icon-telegram"
                                              class="h-4 w-4 object-contain fill-white"/>
                                    </a>
                                    <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + url + '/' + url"
                                       target="_blank" aria-label="facebook"
                                       class="bg-[#4267B2] hover:bg-[#185ab1] transition ease-in-out duration-300 text-xs text-white font-black md:py-2 px-3 rounded-md  flex items-center">
                                        <Icon name="icon-facebook-fill"
                                              class="h-4 w-4 object-contain fill-white"/>
                                    </a>
                                    <a :href="'https://twitter.com/intent/tweet?url=' + url + '/' + url + '&text='"
                                       target="_blank" aria-label="twitter"
                                       class="bg-[#202020] hover:bg-[#000000] transition ease-in-out duration-300 text-xs text-white font-black md:py-2 px-3 rounded-md flex items-center">
                                        <Icon name="icon-x"
                                              class="h-4 w-4 object-contain fill-white"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="purchase" class="md:py-3">
            <div class="md:container">
                <div class="c-content flex-col lg:flex-row">
                    <PaymentExposed v-if="purchaseType === 1"/>
                    <PaymentRandom :raffle="raffle" v-else/>
                </div>
            </div>
        </section>

        <section class="md:py-3">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold text-neutral mb-2">Promoçoes</p>

                    <ul v-for="(item, index) in raffle.raffle_promotions" :key="index">
                        <li class="text-neutral/70 font-bold">Comprando acima de {{item.quantity_numbers}}, o valor por cota é {{ parseFloat( (item.amount/100) ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) }}</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="md:py-3">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold text-neutral mb-2">Prêmios</p>

                    <ul v-for="(item, index) in raffle.raffle_awards" :key="index">
                        <li class="text-neutral/70 font-bold">{{item.order}} {{item.description}}</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="md:py-3">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold text-neutral mb-2">Ranking Compradores</p>

                    <ul v-for="(item, index) in raffle.buyers" :key="index">
                        <li class="text-neutral/70 font-bold">{{index+1}} {{item.total}}-{{item.name}}</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="md:py-3">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold text-neutral mb-2">Cotas Premiadas</p>

                    <ul v-for="(item, index) in raffle.raffle_premium_numbers" :key="index">
                        <li class="text-neutral/70 font-bold">{{index+1}} {{item.number_premium}} {{item.winner_name}}</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="md:py-3">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold mb-2 text-neutral">Regulamento</p>
                    <div id="regulation" class="c-regulation__content" :class="activeHeight ? 'active' : ''">
                        {{ raffle.description }}
                    </div>

                    <button v-if="!activeHeight" type="button"
                            class="text-sm flex items-center gap-1 mt-5 py-1 text-primary" @click="descricaoActive()">
                        Ver regulamento completo
                        <Icon name="icon-carret-down" class="w-3 h-3 stroke-content mt-[1px] fill-primary"/>
                    </button>
                </div>
            </div>
        </section>
    </App>
</template>

<style lang="scss" scoped>
.c-regulation__content {
    @apply relative h-[380px] text-neutral/70 overflow-hidden;
    transition: all 1s ease-out;

    &:before {
        content: '';
        width: 100%;
        height: 70px;
        position: absolute;
        bottom: -2px;
        left: 0;
        z-index: 9;
        //background: linear-gradient(180deg, var(--b1) 0%, var(--b1) 100%);

        @apply bg-gradient-to-b from-base-100/0 to-content
    }

    &.active {
        @apply h-auto;
        transition: all 1s ease-out;

        &:before {
            display: none;
        }
    }
}
</style>
