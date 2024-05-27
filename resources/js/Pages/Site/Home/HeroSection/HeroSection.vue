<script>
import { Link } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button/Button.vue';
import Icon from '@/Components/Icon/Icon.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, Navigation, Autoplay, Keyboard } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

export default {
    components: {
        Link,
        Icon,
        Button,
        Swiper,
        SwiperSlide,
    },
    props: {
        highlight: Object,
    },
    data() {
        return {
            slide: [
                {
                    image: './images/banner-1.webp',
                    imageMobile: './images/teste.jpg',
                    title: 'Omega',
                    link: 'pay.pay8.com.br',
                },
                {
                    image: './images/banner-2.webp',
                    imageMobile: './images/teste.jpg',
                    title: 'Omega',
                    link: 'pay.pay8.com.br',
                },
                {
                    image: './images/banner-3.webp',
                    imageMobile: './images/teste.jpg',
                    title: 'Omega',
                    link: 'pay.pay8.com.br',
                },
                {
                    image: './images/banner-4.webp',
                    imageMobile: './images/teste.jpg',
                    title: 'Omega',
                    link: 'pay.pay8.com.br',
                },
            ],
            modules: [Autoplay, Navigation, Keyboard, Pagination],
        }
    },
    methods: {
        goNext() {
            this.$emit('prev');
        },
        goPrev() {
            this.$emit('next');
        },
    }
}
</script>

<template>
    <section id="hero" class="c-hero">
        <div class="container flex">
            <div class="w-full">
                <swiper ref="swiper"
                        :keyboard="true"
                        :slidesPerView="1"
                        :preventClicks="false"
                        :spaceBetween="15"
                        loop="true" :autoplay="{
                delay: 4500,
                disableOnInteraction: false,
            }" :breakpoints="{

                '768': {
                    slidesPerView: 1,
                },
                '1024': {
                    slidesPerView: 1,

                },
            }" :pagination="{
                clickable: true,
            }" :navigation="{ nextEl: '.custom-next-button', prevEl: '.custom-prev-button' }"
                        :allowTouchMove="false" :grabCursor="false" :centeredSlides="true" :modules="modules"
                        class="swiper-hero">

                    <swiper-slide v-for="(item, key) in highlight" :key="key">
                        <div class="w-full h-full rounded-2xl border-base-200 overflow-hidden ">
                            <div class="aspect-[2/3] md:aspect-[4/1.8]" :aria-label="item.name">
                                <img :src="item.new_banner"
                                     class="w-full h-full object-cover pointer-events-none hidden md:block" :alt="item.title">
                                <img :src="item.new_banner"
                                     class="w-full h-full object-cover pointer-events-none md:hidden" :alt="item.title">
                            </div>

                            <div class="box-banner">
                                <Button type="a" :href="route('raffle', item.link)" color="primary" class="pulsate-fwd">Adiquira e concorra</Button>
                            </div>
                        </div>
                    </swiper-slide>

                    <div class="swipper-navigation">
                        <div class="px-4 md:w-[100%] mx-auto flex justify-between">
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
        </div>
    </section>
</template>

<style src="./style.scss" lang="scss" />
