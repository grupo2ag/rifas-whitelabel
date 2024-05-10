<script setup>
import * as func from '@/Helpers/functions';
</script>

<script>
import App from '@/Pages/App.vue'
import HeroSection from '@/Pages/Site/Home/HeroSection/HeroSection.vue'
import Button from '@/Components/Button/Button.vue';
import { Link } from '@inertiajs/inertia-vue3';

import {Progress, Tooltip, Tabs, TabPanel} from 'daisyui-vue';
import {Swiper, SwiperSlide} from 'swiper/vue';
import {FreeMode, Navigation, Thumbs} from 'swiper/modules';

import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

export default {
    components: {
        App,
        HeroSection,
        Button,
        Progress,
        Tooltip,
        Tabs,
        TabPanel,
        Swiper, SwiperSlide,
        Link
    },
    props: {
      raffles: Array,
      rafflesFinish: Array
    },
    data() {
        return {
            destaques: this.filteredRafflesStatus('Ativo', true),
            ativas: this.filteredRafflesStatus('Ativo', false),
            finalizadas: this.rafflesFinish,
        }
    },
    methods: {
        filteredRafflesStatus(status, highlight) {
            let tempRaffles = this.raffles

            tempRaffles = tempRaffles.filter((item) => {
                return (item.status == status && item.highlight == highlight)
            })

            return tempRaffles;
        }
    },
    mounted() {
        /*console.log(this.destaques, this.ativas, this.finalizadas)*/
    }
}
</script>

<template>
    <App>
        <HeroSection :highlight="destaques"/>

        <section class="pt-10 pb-5">
            <div class="container">
                <h2 class="o-title">Próximos Sorteios</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                        <template v-for="(item, index) in ativas" :key="index">
                            <a :href="route('raffle', item.link)" class="c-card__item">
                                <figure class="aspect-square overflow-hidden">
                                    <img :src="item.raffle_images[0]"
                                         class="w-full h-full object-cover rounded-xl" :alt="item.title">
                                </figure>
                                <div class="flex flex-col justify-between flex-1">
                                    <p class="text-neutral/60">{{ item.title }}</p>
                                    <p class="text-neutral font-bold text-xl">{{ func.formatValue(item.price) }}</p>
                                    <Button type="button" color="primary" class="mt-2">Clique e Participe</Button>
                                </div>
                            </a>
                        </template>
                    </div>
            </div>
        </section>

        <section v-if="finalizadas.length > 0" id="drawn" class="py-5" >
            <div class="container">
                <h2 class="o-title">Últimos Sorteios</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <template v-for="(item, index) in finalizadas" :key="index">
                        <a :href="route('raffle', item.link)" class="c-card__item">
                            <figure class="aspect-square overflow-hidden">
                                <img :src="item.raffle_images[0]"
                                     class="w-full h-full object-cover rounded-xl" :alt="item.title">
                            </figure>
                            <div class="flex flex-col justify-between">
                                <p class="text-neutral">{{ item.title}}</p>
                                <p class="text-neutral">Sorteado: <span class="font-bold">N 21</span></p>
                                <p class="text-neutral">Ganhador: <span class="font-bold">Luiz Henrique Meirelles - SP</span></p>
                                <Button type="button" color="primary" class="mt-2">Ver Resultado</Button>
                            </div>
                        </a>
                    </template>
                </div>
                <div class="mt-5 w-full flex justify-center">
                    <a type="button" class="text-neutral">ver mais</a>
                </div>
            </div>
        </section>
    </App>
</template>

<style lang="scss" scoped>
.c-card__item {
    @apply flex flex-col gap-4 border border-base-100 bg-content p-4 rounded-2xl;
}

.o-title {
    @apply flex text-2xl font-bold text-neutral items-center gap-3 mb-2;

    &:after {
        content: '';
        @apply h-[1px] flex-1 mt-1;
    }
}
</style>
