<script setup>
import * as func from '@/Helpers/functions';
</script>

<script>
import Button from '@/Components/Button/Button.vue'
import Icon from '@/Components/Icon/Icon.vue'

export default {
    name: "PaymentExposed",
    components: {
        Button,
        Icon,
    },
    data() {
        return {
            data: [
                {
                    number: 1,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 2,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 3,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 4,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 5,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 6,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 7,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 8,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 9,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 10,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 11,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 12,
                    status: 'paid',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 13,
                    status: 'paid',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 14,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 15,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 16,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 17,
                    status: 'paid',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 18,
                    status: 'paid',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 19,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 20,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 21,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 22,
                    status: 'paid',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 23,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 24,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 25,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 26,
                    status: 'paid',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 27,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 28,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 29,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 30,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 31,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 32,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 33,
                    status: 'paid',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 34,
                    status: 'paid',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 35,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 36,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 37,
                    status: 'reserved',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 38,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 39,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 40,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 41,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 42,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 43,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 44,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 45,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 46,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 47,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 48,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                },
                {
                    number: 49,
                    status: 'available',
                    buyer: 'Luiz Meirelles'
                }
            ],
            items: [],
            selected: [],
            showModal: false,
            value: 199,
            total: 0
        }
    },
    methods: {
        filterItems(status) {
            if (status === 'all') {
                document.querySelectorAll(".c-raffle__number").forEach(function (el) {
                    el.style.display = 'block';
                });
            } else {
                document.querySelectorAll(".c-raffle__number").forEach(function (el) {
                    el.style.display = 'none';
                });

                document.querySelectorAll(".c-raffle__number--" + status).forEach(function (el) {
                    el.style.display = 'block';
                });
            }
        },
        addItem(number, status) {
            let active = this.$refs['numb_' + number][0].getAttribute('active')

            if (status === 'available') {
                if (active !== 'true') {
                    this.data.filter((item) =>
                        item.number === number ? this.selected.push(item) : '');

                    this.$refs['numb_' + number][0].setAttribute('active', true)

                    this.total = this.selected.length * this.value

                    this.showModal = true
                } else {
                    this.removeItem(number)
                }
            }
        },
        removeItem(number) {
            for (let i = this.selected.length; i--;) {
                if (this.selected[i].number === number) {
                    this.selected.splice(i, 1);
                }
            }

            if (this.selected.length <= 0) {
                this.showModal = false
            }

            this.total = this.selected.length * this.value

            this.$refs['numb_' + number][0].setAttribute('active', false)
        }
    },
}
</script>

<template>
    <div class="flex flex-col">
        <p class="text-center text-lg font-bold text-neutral">
            Escolha seus números
        </p>

        <p class="text-center text-neutral/70 mb-4">
            Escolha os números desejados e, em seguida, finalize a reserva/compra.
        </p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <Button type="button" color="info" class="flex-1"
                    @click="filterItems('all')">
                Todos
            </button>

            <Button type="button" color="outline-primary" class="flex-1"
                    @click="filterItems('available')">
                Disponivel
            </button>

            <Button type="button" color="warning" class="flex-1"
                    @click="filterItems('reserved')">
                Reservado
            </button>

            <Button type="button" color="success" class="flex-1"
                    @click="filterItems('paid')">
                Pago
            </button>
        </div>

        <div class="border-t border-black/20">
            <div class="grid grid-cols-4 md:grid-cols-12 gap-2 md:gap-1 mt-5">
                <template v-for="(item, index) in data" :key="index">
                    <button type="button" :ref="'numb_' + item.number"
                            class="c-raffle__number"
                            :class="item.status === 'paid' ? 'c-raffle__number--paid' : item.status === 'reserved' ? 'c-raffle__number--reserved' : 'c-raffle__number--available'"
                            @click="addItem(item.number, item.status)">
                        {{ item.number }}
                    </button>
                </template>
            </div>
        </div>
    </div>

    <Transition :duration="{ enter: 600, leave: 200 }" name="slide-fade">
        <div class="c-checkout" v-show="showModal">
            <div class="w-full md:container inner">
                <div class="w-full px-6 flex flex-col md:flex-row items-center gap-3 md:gap-8">
                    <div
                        class="w-full md:w-auto flex-1 pb-3 md:pb-0 flex items-start flex-wrap gap-1 border-b md:border-none border-base-100">
                        <template v-for="item in selected">
                            <div class="bg-primary text-primary-bw px-3 py-1.5 flex items-center rounded-md gap-1">
                                <p class="text-xs uppercase text-primary-bw">
                                    {{ item.number }}
                                </p>
                                <button type="" @click="removeItem(item.number)" aria-label="Excluir Número">
                                    <Icon name="icon-trash" class="stroke-primary-bw h-[14px]"/>
                                </button>
                            </div>
                        </template>
                    </div>

                    <div class="w-full md:w-6/12 flex flex-col md:flex-row items-center justify-between gap-4 md:gap-8">
                        <div class="w-full md:w-6/12">
                            <p class="text-xs text-neutral/70">{{ selected.length }} número(s) selecionado(s)</p>

                            <p class="text-sm md:text-sm text-neutral">Total <span
                                class="text-2xl font-black">R$ {{ func.formatValue(this.total) }}</span></p>
                        </div>

                        <div class="w-full md:w-6/12">
                            <Button color="success" class="w-full uppercase font-bold pulsate-fwd">
                                <Icon name="icon-check-circle" class="h-6 mr-2 stroke-success-bw"/>
                                Reservar
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style src="./style.scss" lang="scss" scoped/>
