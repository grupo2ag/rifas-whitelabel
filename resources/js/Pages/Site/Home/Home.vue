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
      raffles: Array
    },
    data() {
        return {
            destaques: this.filteredRafflesStatus('Ativo', true),
            ativas: this.filteredRafflesStatus('Ativo', false),
            finalizadas: this.filteredRafflesStatus('Finalizado', null),
        }
    },
    methods: {
        filteredRafflesStatus(status, highlight) {
            let tempRaffles = this.raffles

            console.log(status);

            tempRaffles = tempRaffles.filter((item) => {
                if(highlight != null){
                    return (item.status == status && item.highlight == highlight)
                }
                return (item.status == status)
            })

            return tempRaffles;
        }
    },
    mounted() {
        /*let high = this.filteredRafflesStatus('Ativo', true);
        let nohigh = this.filteredRafflesStatus('Ativo', false);
        let finish = this.filteredRafflesStatus('Finalizado', null);
        console.log(high, nohigh, finish)*/
        console.log(this.destaques, this.ativas, this.finalizadas)
    }
}

</script>

<template>
    <App>
        <HeroSection/>

        <section class="pt-10 pb-5">
            <div class="container">
                <div class="">
                    <h2 class="o-title">Próximos Sorteios</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                        <template v-for="i in 4">
                            <a href="/raffle" class="c-card__item">
                                <figure class="aspect-square overflow-hidden">
                                    <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                         class="w-full h-full object-cover rounded-xl" alt="">
                                </figure>
                                <div class="flex flex-col justify-between">
                                    <p class="text-neutral/60">VITAMINI C GUMMY</p>
                                    <p class="text-neutral font-bold text-xl">R$ 115,00</p>
                                    <Button type="button" color="primary" class="mt-2">Clique e Participe</Button>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <section id="drawn" class="py-5">
            <div class="container">
                <div class="">
                    <h2 class="o-title">Últimos Sorteios</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                        <template v-for="i in 8">
                            <a href="/raffle" class="c-card__item">
                                <figure class="aspect-square overflow-hidden">
                                    <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                         class="w-full h-full object-cover rounded-xl" alt="">
                                </figure>
                                <div class="flex flex-col justify-between">
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
