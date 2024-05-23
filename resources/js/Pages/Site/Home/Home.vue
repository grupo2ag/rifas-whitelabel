<script>
import App from '@/Pages/App.vue'
import HeroSection from '@/Pages/Site/Home/HeroSection/HeroSection.vue'
import Button from '@/Components/Button/Button.vue';
import {ref} from 'vue';
import * as func from '@/Helpers/functions';

import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css";

export default {
    components: {
        App,
        HeroSection,
        Button,
        InfiniteLoading
    },
    props: {
        raffles: Object,
        rafflesFinish: Object
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
    },
    setup(props) {
       console.log(props.rafflesFinish)
        /* console.log('aqui')*/

      // let finish = ref(props.rafflesFinish);

        const finish = ref([]);

        finish.value.push(...props.rafflesFinish.data)

        // console.log(finish)

        let page = 2;
        const load = async $state => {
            console.log("loading...");
            try {
                const response = await fetch("http://127.0.0.1:8000?page=2").then(r => r);

                // const json = response.body;
                console.log(response);
                // const json = await response;
                if (response.length < 10) $state.complete();
                else {
                    finish.value.push(...response);

                    console.log(finish);
                    $state.loaded();
                }
                page++;
            } catch (error) {
                console.log(error)
                $state.error();
            }
        };

        return {
            load,
            finish,
            page,
            func
        };
    },
}
</script>

<template>
    <App>
        <HeroSection :highlight="destaques"/>

        <section v-if="ativas.length > 0" class="pt-10 pb-5">
            <div class="container">
                <h2 class="o-title">Próximos Sorteios</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <template v-for="(item, index) in ativas" :key="index">
                        <a :href="route('raffle', item.link)" class="c-card__item">
                            <figure class="aspect-square overflow-hidden">
                                <img :src="item.raffle_images[0]?.thumb"
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

        <section v-if="finalizadas" id="drawn" class="py-5" >
            <div class="container">
                <h2 class="o-title">Últimos Sorteios</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <template v-for="(item, index) in finish" :key="index">
<!--                        <pre>{{item}}</pre>-->
                        <a :href="route('raffle', item.link)" class="c-card__item">
                            <figure>
                                <img :src="item.raffle_images[0]?.thumb"
                                     class="w-full h-full object-cover" :alt="item.title">
                            </figure>
                            <div class="flex-1 flex flex-col justify-between gap-1">
                                <p class="text-lg font-semibold text-neutral line-clamp-2" :title="item.title">{{ item.title }}</p>

                                <p class="text-neutral" v-if="item.raffle_awards[0]?.number_award">
                                    Sorteado: <span class="font-bold">N° {{item.raffle_awards[0]?.number_award}}</span>
                                </p>

                                <p class="text-neutral leading-tight" v-if="item.raffle_awards[0]?.winner_name">
                                    Ganhador:
                                    <span class="font-bold">{{item.raffle_awards[0]?.winner_name}}</span>
                                </p>

                                <Button type="button" color="primary" class="mt-2">Ver Resultado</Button>
                            </div>

                            <span class="c-closed">Encerrado</span>
                        </a>
                    </template>
                </div>
            </div>
        </section>

        <InfiniteLoading @infinite="load">
            <template #complete><span></span></template>
            <template #error><span></span></template>
        </InfiniteLoading>
    </App>
</template>

<style lang="scss" scoped>
.c-card__item {
    @apply flex flex-col gap-4 border border-base-100 bg-content p-4 rounded-2xl relative overflow-hidden;

    figure{
        @apply border border-base-100/50 aspect-square overflow-hidden rounded-xl;

        img{
            transition: .2s ease-in-out;
        }
    }

    &:hover{
        figure{
            img{
                transform: scale(1.03);
            }
        }
    }
}

.o-title {
    @apply flex text-2xl font-bold text-neutral items-center gap-3 mb-2;

    &:after {
        content: '';
        @apply h-[1px] flex-1 mt-1;
    }
}

.c-closed{
    @apply py-0.5 px-8 text-primary-bw bg-primary font-semibold absolute origin-center top-5 -left-8 -rotate-45;
}
</style>
