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
import { Pagination, Navigation, Autoplay, Keyboard, EffectCube, EffectFlip, EffectCards, EffectCoverflow, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';
import CardRaffle from '@/Components/Cards/CardRaffle.vue'

export default {
    props: {
        data: Array
    },
    // mounted() {
    //     console.log(this.data, 'CAROUSEL')
    // },
    components: {
        Link,
        Icon,
        Button,
        Swiper,
        SwiperSlide,
        CardRaffle,
    },
    data() {
        return {
            modules: [Autoplay, Navigation, Keyboard, EffectCube, EffectFlip, EffectCards, EffectCoverflow, EffectFade],
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
        <div class="flex justify-center w-full px-4">
            <h1 class="text-base text-xl font-medium title-font">Rifas Recentes</h1>
        </div>
        <div class="container flex">
            <div class="w-full">
                <swiper :effect="'coverflow'" ref="swiper" :keyboard="true" :slidesPerView="2" :spaceBetween="5"
                    :loop="true" :autoplay="data && data?.length > 1 && {
                    delay: 4500,
                    disableOnInteraction: false,
                }" :breakpoints="{
                    '300': {
                        slidesPerView: 1,
                        coverflowEffect: {
                            rotate: 10,
                            stretch: 50,
                            depth: 50,
                            modifier: 3,
                            slideShadows: true,
                        }
                    },
                    '768': {
                        slidesPerView: 1,
                    },
                    '1024': {
                        slidesPerView: 1,
                    },
                }" :pagination="{
                    clickable: true,
                }" :coverflowEffect="{
                    rotate: 50,
                    stretch: 100,
                    depth: 200,
                    modifier: 3,
                    slideShadows: true,
                }" :navigation="{ nextEl: '.custom-next-button', prevEl: '.custom-prev-button' }"
                    :allowTouchMove="false" :grabCursor="false" :centeredSlides="true" :modules="modules"
                    class="swiper-hero">
                    <swiper-slide class="flex justify-center" v-for="(item, key) in data" :key="key">
                        <div class="w-8/12 h-full overflow-hidden md:rounded-2xl border-base-200 ">
                            <CardRaffle :data="item" />
                        </div>
                    </swiper-slide>

                    <div v-if="data?.length > 1" class="swipper-navigation">
                        <div class="flex justify-between w-full mx-auto ">
                            <button type="button" class="swiper-nav-button custom-prev-button bg-base-100"
                                @click="goPrev">
                                <Icon name="icon-carret-left" class="w-4 h-4 mr-0.5 fill-primary" />
                            </button>

                            <button type="button" class="swiper-nav-button custom-next-button bg-base-100"
                                @click="goNext">
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
