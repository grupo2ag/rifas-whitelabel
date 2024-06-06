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
import { ref } from 'vue';

import { format } from "date-fns";

import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import {Inertia} from "@inertiajs/inertia";

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
      raffle: Object
    },
    data() {
        return {
            componentKey: {},
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
            showModal: true,
            status: this.raffle.status
        }
    },
    methods: {
        /*setThumbsSwiper(swiper) {
            this.thumbsSwiper = swiper;
        },*/
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
        goNext() {
            this.$emit('prev');
        },
        goPrev() {
            this.$emit('next');
        }
    },
    mounted() {
        //console.log(this.raffle.link);
        /*console.log(this.destaques, this.ativas, this.finalizadas)*/
    },
    setup(){
        const thumbsSwiper = ref(null);

        const setThumbsSwiper = (swiper) => {
            thumbsSwiper.value = swiper;
        };

        return {
            thumbsSwiper,
            setThumbsSwiper,
            modules: [FreeMode, Navigation, Thumbs],
        };
    },
    created(){
        Echo.channel(`Raffle.Reserve.${this.raffle.link}`).listen('RaffleManual', (e) => {
            //console.log('websocket', e, this.raffle.link)
            axios.get(route('reservedVerify', this.raffle.id))
                .then((res) => {
                    //let resposta = res.data;
                    this.componentKey = res.data.raffle;
                }).catch((errors) => {
                    //console.log(errors)
                })
        });
    }
}
</script>

<template>
    <App>
        <section class="pt-16 md:pt-24 md:pb-2">
            <div class="md:container">
                <div class="c-content flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-7/12 flex flex-col items-start">
                        <h1 class="text-2xl text-neutral font-bold uppercase mb-1 leading-tight md:hidden">{{ raffle.title }}</h1>

                        <Badge color="primary" size="sm" class="mb-2 md:hidden">
                            {{ status === 'Ativo' ? 'Corra' : 'Encerrado' }}
                        </Badge>

                        <div class="w-full flex flex-col gap-6">
                            <div class="w-full flex flex-col md:flex-row gap-3 md:gap-4">
                                <div class="w-full md:w-10/12 order-1 md:order-2">
                                    <swiper
                                        :navigation="{ nextEl: '.custom-next-button', prevEl: '.custom-prev-button' }"
                                        :spaceBetween="10"
                                        :thumbs="{ swiper: thumbsSwiper }"
                                        :modules="modules"
                                        class="swiper-thumb">
                                        <swiper-slide v-for="(item, index) in galery" :key="index">
                                            <figure class="w-full overflow-hidden">
                                                <img :src="item.img" class="w-full aspect-square object-cover" :alt="raffle.title + ' Foto Ampliada ' + index"/>
                                            </figure>
                                        </swiper-slide>

                                        <div class="swipper-navigation">
                                            <div class="px-2 md:w-[100%] mx-auto flex justify-between">
                                                <button type="button" class="swiper-nav-button custom-prev-button" @click="goPrev">
                                                    <Icon name="icon-carret-left" class="w-4 h-4 mr-0.5 fill-primary" />
                                                </button>

                                                <button type="button" class="swiper-nav-button custom-next-button" @click="goNext">
                                                    <Icon name="icon-carret-right" class="w-4 h-4 ml-0.5 fill-primary" />
                                                </button>
                                            </div>
                                        </div>
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
                                        class="swiper-thumbs md:h-[500px]">
                                        <swiper-slide v-for="(item, index) in galery" :key="index">
                                            <figure class="w-full rounded-xl overflow-hidden">
                                                <img :src="item.img" class="w-full aspect-square object-cover" :alt="raffle.title + ' Foto ' + index"/>
                                            </figure>
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

                                <Badge color="primary" size="sm" class="mb-2 hidden md:block">
                                    {{ status === 'Ativo' ? 'Corra' : 'Encerrado' }}
                                </Badge>

                                <p class="text-neutral/70">
                                    {{ raffle?.subtitle }}
                                </p>
                            </div>

                            <div v-if="status === 'Ativo'" class="flex justify-between items-end">
                                <p class="text-sm text-neutral">
                                    Por apenas<br> <span class="text-3xl font-bold">{{ parseFloat( (raffle.price/100) ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) }}</span>
                                </p>
                            </div>

                            <div v-if="raffle.partial === 1 && status === 'Ativo'" class="w-full">
                                <Progress :value="raffle.percent" max="100"/>
                            </div>

                            <Button type="button" color="primary" class="pulsate-fwd w-full" @click="goto('purchase', 75)">
                                {{ status === 'Ativo' ? 'Adquira Já' : 'Ver Resultado' }}
                            </Button>

                            <ul v-if="status === 'Ativo'" class="w-full flex flex-col md:flex-row gap-3">
                                <li class="w-full md:w-auto text-sm text-neutral flex-1">
                                    Data prevista do sorteio:
                                    <p class="text-base font-bold">{{ !!raffle.expected_date ? format(new Date(raffle.expected_date), "dd/MM/yyy") : 'A Definir' }}</p>
                                </li>
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

        <section id="purchase" class="md:py-2">
            <div class="md:container">
                <div v-if="status === 'Ativo'" class="c-content flex-col lg:flex-row">
                    <PaymentExposed :updateComponent="componentKey" :raffle="raffle" v-if="purchaseType === 1"/>
                    <PaymentRandom :raffle="raffle" v-else/>
                </div>
                <div v-else class="c-content">
                    <p class="text-center text-lg font-bold text-neutral">
                        Informações do Sorteio
                    </p>

                    <p class="text-center text-neutral/70 mb-4">
                        Data do Sorteio: {{ format(new Date(raffle.expected_date), "dd/MM/yyy") }}
                    </p>

                    <ul class="grid gap-2">
                        <template v-for="(item, index) in raffle.raffle_awards" :key="index">
                            <template v-if="index === 0">
                                <li class="bg-neutral/5 rounded-xl border border-primary/10 md:hover:bg-neutral/10">
                                    <div class="flex flex-col bg-primary px-4 py-3 rounded-xl">
                                        <p class="text-lg text-primary-bw font-semibold">
                                            {{item?.order}}˚ Prêmio:
                                        </p>

                                        <p class="text-lg flex-1 text-primary-bw font-bold">
                                            {{ item?.description }}
                                        </p>
                                    </div>

                                    <div class="px-4 md:px-6 py-3">
                                        <ul class="flex flex-col md:flex-row md:items-center gap-1 md:gap-10">
                                            <li class="w-full md:w-3/12 grid-cols-1">
                                                <p class="text-sm text-neutral/70">Número Sorteado</p>
                                                <p class="font-bold text-neutral">{{item.number_award}}</p>
                                            </li>
                                            <li class="flex-1">
                                                <p class="text-sm text-neutral/70">Ganhador</p>
                                                <p class="font-bold text-neutral">{{item.winner_name}}</p>
                                            </li>
                                            <li class="w-full md:w-3/12 ">
                                                <p class="text-sm text-neutral/70">Estado</p>
                                                <p class="font-bold text-neutral">São Paulo</p>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </template>

                            <template v-else>
                                <li class="bg-neutral/5 rounded-xl border border-primary/10 md:hover:bg-neutral/10">
                                    <div class="flex flex-col border border-primary px-4 py-3 rounded-xl">
                                        <p class="text-content-bw font-semibold">
                                            {{item.order}}˚ Prêmio:
                                        </p>

                                        <p class="flex-1 text-content-bw font-bold">
                                            {{ item.description }}
                                        </p>
                                    </div>

                                    <div class="px-4 md:px-6 py-3">
                                        <ul class="flex flex-col md:flex-row md:items-center gap-1 md:gap-10">
                                            <li class="w-full md:w-3/12 grid-cols-1">
                                                <p class="text-sm text-neutral/70">Número Sorteado</p>
                                                <p class="font-bold text-neutral">{{item.number_award}}</p>
                                            </li>
                                            <li class="flex-1">
                                                <p class="text-sm text-neutral/70">Ganhador</p>
                                                <p class="font-bold text-neutral">{{item.winner_name}}</p>
                                            </li>
                                            <li class="w-full md:w-3/12 ">
                                                <p class="text-sm text-neutral/70">Estado</p>
                                                <p class="font-bold text-neutral">São Paulo</p>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </template>
                        </template>
                    </ul>
                </div>
            </div>
        </section>

        <section v-if="status === 'Ativo'" class="md:py-2">
            <div class="md:container">
                <div  class="c-content flex flex-col">
                    <p class="text-lg font-bold text-neutral mb-2">Prêmios</p>

                    <ul class="grid gap-2">
                       <template v-for="(item, index) in raffle.raffle_awards" :key="index" >
                           <template v-if="index === 0">
                               <li class="bg-neutral/5 rounded-xl border border-primary/10 md:hover:bg-neutral/10">
                                   <div class="flex flex-col bg-primary px-4 py-3 rounded-xl">
                                       <p class="text-lg text-primary-bw font-semibold">
                                           {{item.order}}˚ Prêmio:
                                       </p>

                                       <p class="text-lg flex-1 text-primary-bw font-bold">
                                           {{ item.description }}
                                       </p>
                                   </div>
                               </li>
                           </template>

                           <template v-else>
                               <li class="flex flex-col md:flex-row items-start md:items-center md:gap-1 justify-between bg-neutral/5 rounded-xl border border-primary/10 px-4 py-3 text-neutral font-bold hover:bg-neutral/10">
                                   <p>{{item.order}}˚ Prêmio: </p>
                                   <p class="flex-1"> {{item.description}}</p>
                               </li>
                           </template>
                        </template>
                    </ul>
                </div>
            </div>
        </section>

        <section v-if="status === 'Ativo' && raffle.raffle_promotions.length > 0" class="md:py-2">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold text-neutral mb-2">Promoções</p>

                    <ul v-for="(item, index) in raffle.raffle_promotions" :key="index">
                        <li class="flex flex-col md:flex-row items-center justify-between gap-2 bg-neutral/5 rounded-xl border border-primary/10 px-4 py-2 text-neutral font-bold hover:bg-neutral/10">
                            <p class="flex-1">Comprando acima de {{item.quantity_numbers}}, o valor por cota é {{ parseFloat( (item.amount/100) ).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section v-if="status === 'Ativo' && raffle.raffle_premium_numbers.length > 0" class="md:py-2">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold text-neutral mb-2">Cotas Premiadas</p>

                    <ul v-for="(item, index) in raffle.raffle_premium_numbers" :key="index">
                        <li class="text-neutral/70 font-bold">{{index+1}} {{item.number_premium}} {{item.winner_name}}</li>
                    </ul>
                </div>
            </div>
        </section>

        <section v-if="raffle.buyer_ranking > 0" class="md:py-2">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold text-neutral mb-2">Ranking Compradores</p>

                    <ul class="grid gap-2">
                        <template v-for="(item, index) in raffle.buyers" :key="index">
                            <li class="flex items-center gap-3 bg-neutral/5 rounded-xl border border-primary/10 px-3 md:px-4 py-3 text-neutral font-bold md:hover:bg-neutral/10">
                               <div class="border-r-2 border-primary pr-3">
                                   <p class="w-7 h-7 text-primary-bw flex items-center justify-center rounded-full bg-primary">{{index+1}}</p>
                               </div>

                                <div class="flex-1 flex flex-col md:flex-row items-start md:items-center">
                                    <p class="flex-1">{{item.name}}</p>
                                    <span class="px-3 md:px-4 py-1 md:py-1.5 bg-neutral/10 text-xs font-normal rounded-full">{{item.total}} Números</span>
                                </div>
                             </li>
                        </template>
                    </ul>
                </div>
            </div>
        </section>

        <section class="md:py-2">
            <div class="md:container">
                <div class="c-content flex flex-col">
                    <p class="text-lg font-bold mb-2 text-neutral">Regulamento</p>

                    <div id="regulation" v-html="raffle.description" class="c-regulation__content" :class="activeHeight ? 'active' : ''"></div>

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

.swiper-thumb {
    @apply border border-neutral/10 rounded-xl;

    .swiper-slide {
        height: auto;
        position: relative;

    }

    .swipper-navigation {
        @apply pointer-events-none w-full absolute z-10 top-[50%] translate-y-[-50%] block;
    }

    .swiper-nav-button {
        @apply bg-content/60 w-8 h-8 flex items-center justify-center pointer-events-auto rounded-full cursor-pointer hover:opacity-50 relative;
    }

    .swiper-button-disabled {
        opacity: 0.5;
    }
}

.swiper-thumbs{

    .swiper-slide{
        figure{
            @apply border border-neutral/10;
        }
    }

    .swiper-slide-thumb-active{
        figure{
            @apply border-primary;
        }
    }
}
</style>
