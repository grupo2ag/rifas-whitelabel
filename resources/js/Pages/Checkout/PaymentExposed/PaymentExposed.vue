<script>
import {Button, Progress, Tooltip, TabPanel} from 'daisyui-vue';

export default {
    name: "PaymentExposed",
    components: {
        Button,
        Tooltip
    },
    data() {
        return {
            data: [
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: 'paid',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
                {
                    number: 1,
                    status: '',
                    buyer: 'Luiz Meirelles',
                },
            ],
            items: [],
            selected: [],
            showModal: true,
        }
    },
    mounted() {
        //this.items = this.data
    },
    methods: {
        filterItems(status) {
            if (status === 'all') {
                this.items = this.data
            } else {
               /* this.items = this.data.filter((item) => {
                    return item.status === status;
                });*/

                this.data.filter((el) => el.status.includes(status))

                console.log(this.data)
            }
        },
        addItem(pos, status) {
            let active = this.$refs['numb_' + pos][0].getAttribute('active')

            if (status === '') {
                if (active !== 'true') {
                    this.selected.push(this.items[pos]);
                    this.$refs['numb_' + pos][0].setAttribute('active', true)
                } else {
                    this.selected.splice(pos);
                    this.$refs['numb_' + pos][0].setAttribute('active', false)
                }
            }
        }
    }
}
</script>

<template>
    <div class="flex flex-col">
        <p class="text-center font-bold mb-6">Escolha seus números, e depois finalize a reserva/compra</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <Button variant="primary" class="flex flex-col flex-1"
                    @click="filterItems('all')">
                Todos
            </button>

            <Button outline="true" variant="primary" class="flex-1"
                    @click="filterItems('')">
                Disponivel
            </button>

            <Button variant="warning" class="flex-1"
                    @click="filterItems('reserved')">
                Reservado
            </button>

            <Button variant="success" class="flex-1"
                    @click="filterItems('paid')">
                Pago
            </button>
        </div>

        <div class="border-t border-black/20">
            <div class="grid grid-cols-4 md:grid-cols-12 gap-2 md:gap-1 mt-5">
                <template v-for="(item, index) in data" :key="index">
                    <Tooltip variant="primary" content="Luiz Meirelles" placement="top">
                        <button :ref="'numb_' + index"
                                class="c-raffle__number"
                                :class="item.status === 'paid' ? 'c-raffle__number--success' : item.status === 'reserved' ? 'c-raffle__number--reserved' : ''"
                                @click="addItem(index, item.status)">
                            {{ item.number }}
                        </button>
                    </Tooltip>
                </template>
            </div>
        </div>
    </div>

    <Transition :duration="{ enter: 600, leave: 200 }" name="slide-fade">
        <div class="c-checkout " v-show="showModal">
            <div class="c-boleta__content py-4 border-t border-black/30 bg-white w-full mx-auto inner">
                <div class="container flex">
                    <div class="py-3 px-4 bg-red flex items-center justify-between">
                        <div class="flex items-start justify-center gap-1">
                            <template v-for="item in selected">
                                <p class="text-xs border border-black px-2 py-1 rounded-md  uppercase font-bold text-black">
                                    {{ item.number }}</p>
                            </template>
                        </div>
                    </div>

                    <div class="w-full">
                        <div class="container flex justify-end items-center ">
                            <div>
                                <h5 class="text-black text-base md:text-lg font-bold">
                                    R$ 100,00
                                </h5>
                                <p class="text-sm md:text-sm text-gray">form.game </p>
                            </div>

                            <button class="p-2"
                                    title="Cancelar Aposta">
                                <XMarkIcon class="w-6 h-6 stroke-gray"/>
                            </button>

                            <div class="bg-green-dark rounded-full p-2" @click="showModal = false"
                                 id="aposta_concluida" title="Cancelar Aposta">
                                <CheckIcon class="w-5 h-5 stroke-white"/>
                            </div>
                        </div>
                    </div>

                    <div class="w-full px-4">
                        <form action="" class="w-full">
                            <Button variant="success" class="w-full">
                                Comprar
                            </Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style src="./style.scss" lang="scss" scoped/>
