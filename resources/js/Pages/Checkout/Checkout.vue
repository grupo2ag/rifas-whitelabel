<script>
import App from '@/Pages/App.vue'
import Icon from '@/Components/Icon/Icon.vue'
import Tab from '@/Components/Tabs/Tab.vue'
import {Button, Progress, Tooltip, TabPanel} from 'daisyui-vue';
import {Swiper, SwiperSlide} from 'swiper/vue';
import {FreeMode, Navigation, Thumbs} from 'swiper/modules';
import {useMediaQuery} from '@vueuse/core'

import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

export default {
    components: {
        App,
        Icon,
        Tab,
        Button,
        Progress,
        Tooltip,
        TabPanel,
        Swiper, SwiperSlide
    },
    data() {
        return {
            thumbsSwiper: null,
            setThumbsSwiper: null,
            activeHeight: false,
            url: window.location.href,
            modules: [FreeMode, Navigation, Thumbs],
            direction: 'vertical',
            galery: [
                {img: 'https://swiperjs.com/demos/images/nature-1.jpg'},
                {img: 'https://swiperjs.com/demos/images/nature-2.jpg'},
                {img: 'https://swiperjs.com/demos/images/nature-3.jpg'},
                {img: 'https://swiperjs.com/demos/images/nature-4.jpg'},
                {img: 'https://swiperjs.com/demos/images/nature-5.jpg'},
                {img: 'https://swiperjs.com/demos/images/nature-6.jpg'},

            ],
            isLargeScreen: useMediaQuery('(min-width: 768px)')

            //loading: true,
        }
    },
    mounted() {
        console.log(this.isLargeScreen)
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
    },
}
</script>

<template>
    <App>
        <section class="pt-16 md:pt-28 md:pb-4">
            <div class="container p-8 md:rounded-3xl flex flex-col md:flex-row mx-auto gap-8 bg-white">
                <div class="w-full md:w-7/12 flex flex-col items-start">
                    <h1 class="text-3xl font-bold uppercase mb-1 md:hidden">VITAMINI C GUMMY</h1>
                    <p class="text-xs px-3 py-1 bg-primary text-white rounded-md mb-4 md:hidden">Corra ultimos números</p>

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

                        <div class="w-full border-b border-black/20 hidden"></div>

                        <div class="w-full hidden">
                            <p class="text-lg font-bold text-black">Prêmios</p>
                            <div ref="regulation" class="py-4 text-black/60">
                                <ul>
                                    <li>
                                        1 - Pelúcia a escolha do ganhador
                                    </li>
                                    <li>
                                        2 - Pelúcia a escolha do ganhador
                                    </li>
                                    <li>
                                        3 - Pelúcia a escolha do ganhador
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-5/12 ">
                    <div class="flex flex-col items-start gap-3 relative">
                        <div class="flex flex-col items-start">
                            <h1 class="text-3xl font-bold uppercase mb-1 hidden md:block">VITAMINI C GUMMY</h1>
                            <p class="text-xs px-3 py-1 bg-primary text-white rounded-md mb-1.5 hidden md:block">Corra
                                ultimos números</p>

                            <p class="text-black/50 text-">
                                Gominhas de morango, de manga e de maçã-verde, com 150mg de Vit C por unidade. Pensada
                                especialmente para crianças. Sem açúcar, glúten, lactose, conservantes, corantes e
                                aromas
                                artificiais.
                            </p>
                        </div>

                        <div class="flex justify-between items-end">
                            <p class="text-sm text-black/70">
                                Por apenas<br> <span class="text-3xl text-black font-bold">R$ 115,00</span>
                            </p>
                        </div>

                        <div class="w-full">
                            <p class="text-primary text-sm">Progresso da Campanha 50/100</p>
                            <Progress type="primary" value="50" max="100"/>
                        </div>

                        <Button variant="primary" class="w-full" @click="goto('purchase', 75)">Comprar</Button>

                        <ul class="w-full flex">
                            <li class="text-sm flex-1">
                                Data do sorteio:
                                <p class="text-base font-bold">A Definir</p>
                            </li>

                            <li class="text-sm flex-1">
                                Sorteio será realizado:
                                <p class="text-base font-bold">Loteria Federal</p>
                            </li>
                        </ul>

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

                        <Button outline="true" size="sm" class="flex">
                            <Icon name="icon-whatsapp"
                                  class="h-4 w-4 object-contain"/>
                            Suporte
                        </Button>
                    </div>
                </div>
            </div>
        </section>

        <section id="purchase" class="md:py-4">
            <div class="container flex-col lg:flex-row p-8 md:rounded-3xl flex flex-col md:flex-row mx-auto gap-8 bg-white">
                <div class="flex-1">
                    <p class="text-center font-bold mb-6">Escolha seus números, e depois finalize a reserva/compra</p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <Button outline="true" variant="primary" class="flex flex-col flex-1">
                            Todos
                        </button>
                        <Button outline="true" variant="primary" class="flex-1">Disponivel</button>
                        <Button variant="warning" class="flex-1">Reservado</button>
                        <Button variant="success" class="flex-1">Pago</button>
                    </div>

                    <div class="border-t border-black/20 mt-6">

                        <div class="grid grid-cols-4 md:grid-cols-10 gap-2 md:gap-4 mt-5">
                            <template v-for="(item, index) in 100" :key="index">
                                <Tooltip variant="primary" content="Luiz Meirelles" placement="top">
                                    <Button outline="true" variant="primary">{{ index }}</button>
                                </Tooltip>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4">
            <div class="container p-8 rounded-3xl flex flex-col gap-8 bg-white">
                <div class="w-full">
                    <p class="text-lg font-bold text-black mb-4">Regulamento</p>
                    <div id="regulation" class="c-regulation__content" :class="activeHeight ? 'active' : ''">
                        <p>As leis e regras podem variar dependendo do país ou região onde a campanha será
                            realizada, então é importante verificar as normas locais antes de organizar uma
                            campanha.
                            No Brasil 🇧🇷, O SECAP (Secretaria de Avaliação, Planejamento, Energia e Loteria do
                            Ministério da Economia) é o órgão que atua na fiscalização e autorização de campanhas
                            promocionais. Regularizar uma campanha promocional exige alguns critérios que você deve
                            seguir para conseguir essa regularização. O pedido de autorização deverá ser formulado
                            por intermédio do Sistema de Controle de Promoção Comercial (SCPC). Em caso de dúvidas
                            consulte os canais de atendimento do SCPC que funcionam 24 horas por dia, nos 7 dias da
                            semana na Central de Atendimento Telefônico 0800-978 2332.</p>
                        <br>
                        <p>As leis e regras podem variar dependendo do país ou região onde a campanha será
                            realizada, então é importante verificar as normas locais antes de organizar uma
                            campanha.
                            No Brasil 🇧🇷, O SECAP (Secretaria de Avaliação, Planejamento, Energia e Loteria do
                            Ministério da Economia) é o órgão que atua na fiscalização e autorização de campanhas
                            promocionais. Regularizar uma campanha promocional exige alguns critérios que você deve
                            seguir para conseguir essa regularização. O pedido de autorização deverá ser formulado
                            por intermédio do Sistema de Controle de Promoção Comercial (SCPC). Em caso de dúvidas
                            consulte os canais de atendimento do SCPC que funcionam 24 horas por dia, nos 7 dias da
                            semana na Central de Atendimento Telefônico 0800-978 2332.</p>
                        <br>
                        <p>As leis e regras podem variar dependendo do país ou região onde a campanha será
                            realizada, então é importante verificar as normas locais antes de organizar uma
                            campanha.
                            No Brasil 🇧🇷, O SECAP (Secretaria de Avaliação, Planejamento, Energia e Loteria do
                            Ministério da Economia) é o órgão que atua na fiscalização e autorização de campanhas
                            promocionais. Regularizar uma campanha promocional exige alguns critérios que você deve
                            seguir para conseguir essa regularização. O pedido de autorização deverá ser formulado
                            por intermédio do Sistema de Controle de Promoção Comercial (SCPC). Em caso de dúvidas
                            consulte os canais de atendimento do SCPC que funcionam 24 horas por dia, nos 7 dias da
                            semana na Central de Atendimento Telefônico 0800-978 2332.</p>
                    </div>

                    <button v-if="!activeHeight" type="button"
                            class="text-sm flex items-center gap-1 mt-5 py-1 text-primary" @click="descricaoActive()">
                        Ver regulamento completo
                        <Icon name="icon-carret-down" class="w-3 h-3 stroke-white mt-[1px] fill-primary"/>
                    </button>
                </div>
            </div>
        </section>
    </App>
</template>


<style lang="scss" scoped>
.c-tab {
    &__header {
        @apply flex items-center justify-center border-b border-black/30;

        button {
            @apply flex-1 text-center;

            &.active {
                @apply border-b-2 border-primary -mb-[1px]
            }
        }
    }

    &__content {
        @apply p-4 text-base text-black/70
    }
}

.c-regulation__content {
    @apply relative h-[380px] overflow-hidden;
    transition: all 1s ease-out;

    &:before {
        content: '';
        width: 100%;
        height: 70px;
        position: absolute;
        bottom: -2px;
        left: 0;
        z-index: 9;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgb(255, 255, 255, 1) 100%);
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
