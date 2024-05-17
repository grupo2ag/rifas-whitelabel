<script>
import App from '@/Pages/App.vue'
import {Link} from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button/Button.vue'
import CardAccount from '@/Components/Cards/CardAccount.vue'

export default {
    components: {
        App,
        Link,
        Button,
        CardAccount
    },
    data() {
        return {
            music: [],
            data: [
                {
                    banner: 'https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg',
                    title: 'VITAMINI C GUMMY',
                    quantity: 5,
                    total: 1000,
                    numbers: '01147,01272,01756,01892,02749,02797,03921,04773,04933,05623,05775,06642,06750,07026,07949,08338,08391,08599,09373,10586,11004,14183,14915,15670,16191,16652,17754,18294,18672,18754,18819,19302,19594,20572,20591,21654,22323,22484,23659,23666,24818,25286,26110,26607,29091,30012,30115,30395,30702,30983,32710,32732,32919,33540,33636,34860,37514,37886,38445,38916,38967,40358,41163,41720,42281,42939,44365,44565,44713,45963,46679,46702,47024,48360,48840,49203,49361,49640,51481,52067,52143,52388,53983,54272,54907,55832,56308,57110,58415,58627,58912,58987,59435,59466,59804,60288,60426,60917,61105,62606,64098,64717,65159,65190,67380,67398,68658,68780,69235,69392,69644,70226,71075,72180,73269,74313,74358,74999,75001,75208,75302,75649,76234,76939,77061,78447,79336,79379,80254,80390,81586,81950,82299,82359,82389,82946,83139,83869,84044,84928,85496,85626,85868,86627,87176,87327,87407,87482,87695,88342,89414,90902,93410,93713,93715,94083,94444,94753,94862,95710,96603,97466,97921,98139,98228',
                    pix_id: '601a99d7-a0d6-4564-91ac-da89a5412895',
                    status: 'PROCESSING',
                    date: '2023-10-25 20:25:43',
                    link: 'medical',
                },
                {
                    banner: 'https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg',
                    title: 'VITAMINI C GUMMY',
                    quantity: 5,
                    total: 1000,
                    numbers: '01147,01272,01756,01892,02749,02797,03921,04773,04933,05623,05775,06642,06750,07026,07949,08338,08391,08599,09373,10586,11004,14183,14915,15670,16191,16652,17754,18294,18672,18754,18819,19302,19594,20572,20591,21654,22323,22484,23659,23666,24818,25286,26110,26607,29091,30012,30115,30395,30702,30983,32710,32732,32919,33540,33636,34860,37514,37886,38445,38916,38967,40358,41163,41720,42281,42939,44365,44565,44713,45963,46679,46702,47024,48360,48840,49203,49361,49640,51481,52067,52143,52388,53983,54272,54907,55832,56308,57110,58415,58627,58912,58987,59435,59466,59804,60288,60426,60917,61105,62606,64098,64717,65159,65190,67380,67398,68658,68780,69235,69392,69644,70226,71075,72180,73269,74313,74358,74999,75001,75208,75302,75649,76234,76939,77061,78447,79336,79379,80254,80390,81586,81950,82299,82359,82389,82946,83139,83869,84044,84928,85496,85626,85868,86627,87176,87327,87407,87482,87695,88342,89414,90902,93410,93713,93715,94083,94444,94753,94862,95710,96603,97466,97921,98139,98228',
                    pix_id: '601a99d7-a0d6-4564-91ac-da89a5412895',
                    status: 'PAID',
                    date: '2023-10-25 20:25:43',
                    link: 'medical',
                }, {
                    banner: 'https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg',
                    title: 'VITAMINI C GUMMY',
                    quantity: 5,
                    total: 1000,
                    numbers: '01147,01272,01756,01892,02749,02797,03921,04773,04933,05623,05775,06642,06750,07026,07949,08338,08391,08599,09373,10586,11004,14183,14915,15670,16191,16652,17754,18294,18672,18754,18819,19302,19594,20572,20591,21654,22323,22484,23659,23666,24818,25286,26110,26607,29091,30012,30115,30395,30702,30983,32710,32732,32919,33540,33636,34860,37514,37886,38445,38916,38967,40358,41163,41720,42281,42939,44365,44565,44713,45963,46679,46702,47024,48360,48840,49203,49361,49640,51481,52067,52143,52388,53983,54272,54907,55832,56308,57110,58415,58627,58912,58987,59435,59466,59804,60288,60426,60917,61105,62606,64098,64717,65159,65190,67380,67398,68658,68780,69235,69392,69644,70226,71075,72180,73269,74313,74358,74999,75001,75208,75302,75649,76234,76939,77061,78447,79336,79379,80254,80390,81586,81950,82299,82359,82389,82946,83139,83869,84044,84928,85496,85626,85868,86627,87176,87327,87407,87482,87695,88342,89414,90902,93410,93713,93715,94083,94444,94753,94862,95710,96603,97466,97921,98139,98228',
                    pix_id: '601a99d7-a0d6-4564-91ac-da89a5412895',
                    status: 'PAID',
                    date: '2023-10-25 20:25:43',
                    link: 'medical',
                },
            ],
            currentBox: 1
        }
    },
    methods: {
        goToBox(tab) {
            this.currentBox = tab
        },
    }
}
</script>

<template>
    <App>
        <section class="pt-16 md:pt-24 md:pb-2">
            <div class="md:container">
                <div class="c-content flex flex-col items-center">
                    <h2 class="text-2xl text-neutral font-bold">Olá, Luiz!</h2>
                    <p class="text-neutral/60">Fique por dentro dos sorteios, números da sorte e ganhadores</p>

                    <div class="pt-4 grid grid-cols-2 gap-2  flex items-center justify-center">
                        <Button type="button" :color="currentBox === 1 ? 'primary' : 'outline-primary'"
                                @click="goToBox(1)">Meus Bilhetes
                        </Button>
                        <Button type="button" :color="currentBox === 2 ? 'primary' : 'outline-primary'"
                                @click="goToBox(2)">Minhas Reservas
                        </Button>
                    </div>
                </div>
            </div>
        </section>

        <section class="md:py-2">
            <div class="md:container">
                <div class="c-content">
                    <template v-if="currentBox === 1">
                        <p class="pb-3 text-lg font-bold text-neutral text-center mb-4 border-b border-neutral/10">
                            Meus Bilhetes
                        </p>

                        <div class="w-6/12 mx-auto flex flex-col items-center gap-3">
                            <template v-if="data.length > 0">
                                <template v-for="(item, index) in data" :key="index">
                                    <CardAccount :data="item"/>
                                </template>
                            </template>

                            <template v-else>
                                <div class="w-full mt-4">
                                    <img class="mx-auto w-6/12" src="/images/img-nodata.svg" alt=""/>
                                    <h6 class="mt-3 font-medium text-neutral text-center">
                                        Sem dados para exibir.
                                    </h6>
                                    <p class="text-sm text-center text-neutral/70">No momento, não há dados para exibir
                                        nesta lista.</p>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template v-if="currentBox === 2">
                        <p class="pb-3 text-lg font-bold text-neutral text-center mb-4 border-b border-neutral/10">
                            Minhas Reservas
                        </p>

                        <div class="w-6/12 mx-auto flex flex-col items-center gap-3">
                            <template v-if="data.length === 0">
                                <template v-for="(item, index) in !data" :key="index">
                                    <CardAccount :data="item"/>
                                </template>
                            </template>

                            <template v-else>
                                <div class="w-full mt-4">
                                    <img class="mx-auto w-6/12" src="/images/img-nodata.svg" alt=""/>
                                    <h6 class="mt-3 font-medium text-neutral text-center">
                                        Sem dados para exibir.
                                    </h6>
                                    <p class="text-sm text-center text-neutral/70">No momento, não há dados para exibir
                                        nesta lista.</p>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </section>
    </App>
</template>

<style lang="scss" scoped>

</style>
