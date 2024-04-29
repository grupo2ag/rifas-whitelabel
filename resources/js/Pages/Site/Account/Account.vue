<script>
import App from '@/Pages/App.vue'
import {Link} from '@inertiajs/inertia-vue3';
import {Button, Join, Tooltip, Tabs, TabPanel} from 'daisyui-vue';

export default {
    components: {
        App,
        Link,
        Button,
        Join
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
        <section class="pt-24">
            <div class="container">
                <div class="p-8 md:rounded-3xl flex flex-col items-center mx-auto bg-white">
                    <h2 class="text-2xl font-bold">Olá, Luiz!</h2>
                    <p class="text-black/60">Fique por dentro dos sorteios, números da sorte e ganhadores</p>

                    <div class="pt-4 grid grid-cols-2 md:grid-cols-4 gap-2  flex items-center justify-center">
                        <Button outline variant="primary">Compras Aprovadas</Button>
                        <Button outline variant="primary">Compras em análise</Button>
                        <Button outline variant="primary">Minhas Reservas</Button>
                        <Button outline variant="primary">Reservas Expirada</Button>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="container">

                <div class="p-8 md:rounded-3xl bg-white">
                    <p class="text-lg font-bold text-black text-center mb-4">Compras Aprovadas</p>

                    <div class="flex flex-col items-center gap-4 ">

                        <div class="w-6/12">
                            <div class="w-full p-3 border border-black/20 rounded-xl">
                                <div class="w-full flex items-center justify-center gap-4 ">
                                    <figure class="flex-1 aspect-square overflow-hidden">
                                        <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                             class="w-full h-full object-cover rounded-xl" alt="">
                                    </figure>
                                    <div class="w-9/12 flex flex-col justify-between">
                                        <p class="font-bold">VITAMINI C GUMMY</p>
                                        <p class="text-sm">Status da transação: <span
                                            class="py-1 px-4 bg-success text-xs text-white rounded-md">Aprovado</span>
                                        </p>
                                        <p class="text-sm">Pagamento feito: 23/04/2024 às 17:17</p>
                                        <p class="text-sm">Valor: <strong>R$10,00</strong></p>
                                    </div>
                                </div>
                                <div class="mt-2 border-t border-black/20 pt-2">
                                    <p class="text-black text-sm mb-2 font-bold">Quantidade de bilhetes: 5</p>
                                    <ul class="grid grid-cols-10 gap-1">
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="w-6/12">
                            <div class="w-full p-3 border border-black/20 rounded-xl">
                                <div class="w-full flex items-center justify-center gap-4 ">
                                    <figure class="flex-1 aspect-square overflow-hidden">
                                        <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                             class="w-full h-full object-cover rounded-xl" alt="">
                                    </figure>
                                    <div class="w-9/12 flex flex-col justify-between">
                                        <p class="font-bold">VITAMINI C GUMMY</p>
                                        <p class="text-sm">Status da transação: <span
                                            class="py-1 px-4 bg-success text-xs text-white rounded-md">Aprovado</span>
                                        </p>
                                        <p class="text-sm">Pagamento feito: 23/04/2024 às 17:17</p>
                                        <p class="text-sm">Valor: <strong>R$10,00</strong></p>
                                    </div>
                                </div>
                                <div class="mt-2 border-t border-black/20 pt-2">
                                    <p class="text-black text-sm mb-2 font-bold">Quantidade de bilhetes: 5</p>
                                    <ul class="grid grid-cols-10 gap-1">
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="w-6/12">
                            <div class="w-full p-3 border border-black/20 rounded-xl">
                                <div class="w-full flex items-center justify-center gap-4 ">
                                    <figure class="flex-1 aspect-square overflow-hidden">
                                        <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                             class="w-full h-full object-cover rounded-xl" alt="">
                                    </figure>
                                    <div class="w-9/12 flex flex-col justify-between">
                                        <p class="font-bold">VITAMINI C GUMMY</p>
                                        <p class="text-sm">Status da transação: <span
                                            class="py-1 px-4 bg-success text-xs text-white rounded-md">Aprovado</span>
                                        </p>
                                        <p class="text-sm">Pagamento feito: 23/04/2024 às 17:17</p>
                                        <p class="text-sm">Valor: <strong>R$10,00</strong></p>
                                    </div>
                                </div>
                                <div class="mt-2 border-t border-black/20 pt-2">
                                    <p class="text-black text-sm mb-2 font-bold">Quantidade de bilhetes: 5</p>
                                    <ul class="grid grid-cols-10 gap-1">
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="w-6/12">
                            <div class="w-full p-3 border border-black/20 rounded-xl">
                                <div class="w-full flex items-center justify-center gap-4 ">
                                    <figure class="flex-1 aspect-square overflow-hidden">
                                        <img src="https://m.media-amazon.com/images/I/71Zfj6G7-VL._SY466_.jpg"
                                             class="w-full h-full object-cover rounded-xl" alt="">
                                    </figure>
                                    <div class="w-9/12 flex flex-col justify-between">
                                        <p class="font-bold">VITAMINI C GUMMY</p>
                                        <p class="text-sm">Status da transação: <span
                                            class="py-1 px-4 bg-success text-xs text-white rounded-md">Aprovado</span>
                                        </p>
                                        <p class="text-sm">Pagamento feito: 23/04/2024 às 17:17</p>
                                        <p class="text-sm">Valor: <strong>R$10,00</strong></p>
                                    </div>
                                </div>
                                <div class="mt-2 border-t border-black/20 pt-2">
                                    <p class="text-black text-sm mb-2 font-bold">Quantidade de rifas: 5</p>
                                    <ul class="grid grid-cols-10 gap-1">
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                        <li class="bg-success py-1 px-2 text-sm rounded-lg text-white text-center">120
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </App>
</template>


<style lang="scss" scoped>

</style>
