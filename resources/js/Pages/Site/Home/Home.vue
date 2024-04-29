<script>
import App from '@/Pages/App.vue'
import HeroSection from '@/Pages/Site/Home/HeroSection/HeroSection.vue'
import { Link } from '@inertiajs/inertia-vue3';

import {Button, Progress, Tooltip, Tabs, TabPanel} from 'daisyui-vue';
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
    data() {
        return {
            music: [],
            items: [
                {
                    title: 'teste1',
                    name: '1'
                },
                {
                    title: 'teste',
                    name: '2'
                }
            ]
            //loading: true,
        }
    },
}
</script>

<template>
    <App>
        <HeroSection/>

        <section class="py-10">
            <div class="container">
                <div class="">
                    <h2 class="o-title">Próximos Sorteios</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                        <template v-for="i in 4">
                            <a href="/checkout" class="c-card__item">
                                <figure class="aspect-square overflow-hidden">
                                    <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                         class="w-full h-full object-cover rounded-xl" alt="">
                                </figure>
                                <div class="flex flex-col justify-between">
                                    <p class="text-black/60">VITAMINI C GUMMY</p>
                                    <p class="font-bold text-lg">R$ 115,00</p>
                                    <Button variant="primary" class="mt-2">Clique e Participe</Button>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-10">
            <div class="container">
                <div class="">
                    <h2 class="o-title">Últimos Sorteios</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                        <template v-for="i in 8">
                            <a href="/checkout" class="c-card__item">
                                <figure class="aspect-square overflow-hidden">
                                    <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                         class="w-full h-full object-cover rounded-xl" alt="">
                                </figure>
                                <div class="flex flex-col justify-between">
                                    <p class="text-sm">Sorteado: <span class="font-bold">N 21</span></p>
                                    <p class="text-sm">Ganhador: <span class="font-bold">Luiz Henrique Meirelles - SP</span></p>
                                    <Button variant="primary" class="mt-2">Ver Resultado</Button>
                                </div>
                            </a>
                        </template>
                    </div>
                    <div class="mt-5 w-full flex justify-center">
                        <button>ver mais</button>
                    </div>
                </div>
            </div>
        </section>
    </App>
</template>


<style lang="scss" scoped>
.c-card__item {
    @apply flex flex-col gap-4 border border-black/10 bg-white p-4 rounded-2xl;
}

.o-title {
    @apply flex text-2xl font-bold items-center gap-3 mb-2;

    &:after {
        content: '';
        @apply h-[1px] bg-black/40 flex-1 mt-1;
    }
}

</style>
