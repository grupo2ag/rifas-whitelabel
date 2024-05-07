<!-- <script setup>
import CardCampaign from '../Cards/CardCampaign.vue';
</script>

<template>
    <div class="justify-center w-4/5 p-4 space-x-4 carousel carousel-center bg-root rounded-box">
        <div class="flex flex-row items-center">
            <div class="w-auto px-2">
                <a href="#slide3" class="btn btn-circle">❮</a>
            </div>
            <div class="w-auto">
                <div class="w-full carousel-item">
                    <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                </div>
            </div>
            <div class="w-auto px-2">
                <a href="#slide1" class="btn btn-circle">❯</a>
            </div>
        </div>
    </div>
</template> -->

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button/Button.vue';
import Icon from '@/Components/Icon/Icon.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, Navigation, Autoplay, Keyboard } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';
import CardCampaign from '../Cards/CardCampaign.vue';

export default {
    components: {
        Link,
        Icon,
        Button,
        Swiper,
        SwiperSlide,
        CardCampaign,
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
    <section class="c-hero" id="hero">
        <div class="container flex">
            <div class="w-full">
                <swiper ref="swiper" :keyboard="true" :slidesPerView="1" :spaceBetween="5" loop="true" :autoplay="{
                delay: 4500,
                disableOnInteraction: false,
            }"  :breakpoints="{

                    '768': {
                        slidesPerView: 1,
                    },
                    '1024': {
                        slidesPerView: 1,

                    },
                }" :pagination="{
                    clickable: true,
                }" :navigation="{ nextEl: '.custom-next-button', prevEl: '.custom-prev-button' }" :allowTouchMove="false"
                    :grabCursor="false" :centeredSlides="true" :modules="modules" class="swiper-hero">

                    <swiper-slide class="flex justify-center" v-for="(item, key) in slide" :key="key">
                        <div class="w-6/12 h-full overflow-hidden md:rounded-2xl border-base-200 ">
                            <div class="aspect-[2/3] md:aspect-[4/1.8]">
                                <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                                    <!--
                                <img :src="item.image"
                                    class="hidden object-cover w-full h-full pointer-events-none md:block"
                                    :alt="item.name">
                                <img :src="item.imageMobile"
                                    class="object-cover w-full h-full pointer-events-none md:hidden" :alt="item.name">
                                -->
                            </div>
                        </div>
                    </swiper-slide>

                    <div class="swipper-navigation">
                        <div class=" w-full mx-auto flex justify-between">
                            <button type="button" class="swiper-nav-button custom-prev-button bg-base-100" @click="goPrev">
                                <Icon name="icon-carret-left" class="w-4 h-4 mr-0.5 fill-primary" />
                            </button>

                            <button type="button" class="swiper-nav-button custom-next-button bg-base-100" @click="goNext">
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
