<script>
import {Button, Progress, Tooltip, Tabs, TabPanel} from 'daisyui-vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { FreeMode, Navigation, Thumbs } from 'swiper/modules';

import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

export default {
    components: {
        Button,
        Progress,
        Tooltip,
        Tabs,
        TabPanel,
        Swiper, SwiperSlide
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
    setup() {
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
}
</script>

<template>

    <section class="">
        <div class="container">
            <div class="w-8/12">

                <swiper
                    :style="{
      '--swiper-navigation-color': '#fff',
      '--swiper-pagination-color': '#fff',
    }"
                    :spaceBetween="10"
                    :navigation="true"
                    :thumbs="{ swiper: thumbsSwiper.value }"
                    :modules="modules"
                    class="mySwiper2"
                >
                    <swiper-slide
                    ><img
                        src="https://swiperjs.com/demos/images/nature-1.jpg" /></swiper-slide
                    ><swiper-slide
                ><img
                    src="https://swiperjs.com/demos/images/nature-2.jpg" /></swiper-slide
                ><swiper-slide
                ><img
                    src="https://swiperjs.com/demos/images/nature-3.jpg" /></swiper-slide
                ><swiper-slide
                ><img
                    src="https://swiperjs.com/demos/images/nature-4.jpg" /></swiper-slide
                ><swiper-slide
                ><img
                    src="https://swiperjs.com/demos/images/nature-5.jpg" /></swiper-slide
                ><swiper-slide
                ><img
                    src="https://swiperjs.com/demos/images/nature-6.jpg" /></swiper-slide
                ><swiper-slide
                ><img
                    src="https://swiperjs.com/demos/images/nature-7.jpg" /></swiper-slide
                ><swiper-slide
                ><img
                    src="https://swiperjs.com/demos/images/nature-8.jpg" /></swiper-slide
                ><swiper-slide
                ><img
                    src="https://swiperjs.com/demos/images/nature-9.jpg" /></swiper-slide
                ><swiper-slide
                ><img src="https://swiperjs.com/demos/images/nature-10.jpg"
                /></swiper-slide>
                </swiper>
            </div>
        </div>
    </section>

    <div class="container mx-auto">
        <div role="tablist" class="tabs tabs-lifted">
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Tab 1" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">Tab content 1</div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Tab 2" checked />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">Tab content 2</div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Tab 3" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">Tab content 3</div>
        </div>
    </div>

    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content container flex-col lg:flex-row">
            <div class="flex-1">

                <div class=" mb-6">
                    <p class="text-secondary text-sm">Progresso da Campanha 50/100</p>
                    <Progress type="secondary" value="50" max="100"/>
                </div>


                <div class="flex gap-4 mb-6 ">
                    <Button outline="true" variant="secondary" class="flex flex-col flex-1">
                        Todos
                    </button>
                    <Button outline="true" variant="secondary" class="flex-1">Disponivel</button>
                    <Button outline="true" variant="secondary" class="flex-1">Reservado</button>
                    <Button outline="true" variant="secondary" class="flex-1">Pago</button>
                </div>



                <div class="border-y border-white/20 py-6 mt-6">
                    <p class="text-center">Escolha seus números, e depois finalize a reserva/compra</p>

                    <div class="grid grid-cols-4 md:grid-cols-10 gap-2 md:gap-4 mt-5">
                        <template v-for="(item, index) in 100" :key="index">
                            <Tooltip variant="primary" content="Luiz Meirelles" placement="top">
                                <Button outline="true" variant="secondary">{{ index }}</button>
                            </Tooltip>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="footer p-10 bg-base-200 text-base-content">

        <aside>
            <svg width="50" height="50" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd"
                 clip-rule="evenodd" class="fill-current">
                <path
                    d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z"></path>
            </svg>
            <p>ACME Industries Ltd.<br>Providing reliable tech since 1992</p>
        </aside>
        <nav>
            <h6 class="footer-title">Services</h6>
            <a class="link link-hover">Branding</a>
            <a class="link link-hover">Design</a>
            <a class="link link-hover">Marketing</a>
            <a class="link link-hover">Advertisement</a>
        </nav>
        <nav>
            <h6 class="footer-title">Company</h6>
            <a class="link link-hover">About us</a>
            <a class="link link-hover">Contact</a>
            <a class="link link-hover">Jobs</a>
            <a class="link link-hover">Press kit</a>
        </nav>
        <nav>
            <h6 class="footer-title">Legal</h6>
            <a class="link link-hover">Terms of use</a>
            <a class="link link-hover">Privacy policy</a>
            <a class="link link-hover">Cookie policy</a>
        </nav>

    </footer>
</template>


<style scoped>

</style>
