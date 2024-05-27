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
    props: {
        participant: Object
    },
    data() {
        return {
            numbers: this.participant,
            //numbers: this.participant.data,
            paid: this.participant.filter(numb => numb.purchase === 'PAID'),
            //paid: this.participant.data.filter(numb => numb.purchase === 'PAID'),
            reserved: this.participant.filter(numb => (numb.purchase === 'RESERVED' || numb.purchase === 'PROCESSING' )),
            //reserved: this.participant.data.filter(numb => (numb.purchase === 'RESERVED' || numb.purchase === 'PROCESSING' )),
            music: [],
            currentBox: 1
        }
    },
    methods: {
        goToBox(tab) {
            this.currentBox = tab
        },
    },
    mounted() {

    }
}
</script>

<template>
    <App>
        <section class="pt-16 md:pt-24 md:pb-2">
            <div class="md:container">
                <div class="c-content flex flex-col items-center">
                    <h2 class="text-2xl text-neutral font-bold">Olá, Luiz!</h2>
                    <p class="text-neutral/60 text-center leading-tight">Fique por dentro dos sorteios, números da sorte e ganhadores</p>

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

                        <div class="w-full md:w-6/12 mx-auto flex flex-col items-center gap-3">
                            <template v-if="paid.length > 0">
                                <template v-for="(item, index) in paid" :key="index">
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

                        <div class="w-full md:w-6/12 mx-auto flex flex-col items-center gap-3">
                            <template v-if="reserved.length > 0">
                                <template v-for="(item, index) in reserved" :key="index">
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
