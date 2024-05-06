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
        const value = 199
        return {
            quotas: [
                {
                    quantity: 10
                },
                {
                    quantity: 20
                },
                {
                    quantity: 30
                },
                {
                    quantity: 40
                },
                {
                    quantity: 50
                },
                {
                    quantity: 60
                },
            ],
            items: [],
            selected: [],
            showModal: false,
            value: value,
            quantity: 1,
            total: value
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
        removeItem() {
            if (this.quantity > 1) {
                this.quantity--
                this.total = this.quantity * this.value
            }
        },
        addItem() {
            // if (this.quantity < 7) {
            this.quantity++
            this.total = this.quantity * this.value
            // }
        },
        addQuotas(quotas) {
            this.quantity += quotas
            this.total = this.quantity * this.value
        }
    },
}
</script>

<template>
    <div class="flex flex-col">
        <p class="text-center text-lg font-bold text-neutral">
            Compra Automática
        </p>

        <p class="text-center text-neutral/70 mb-4">
            O site escolhe números de forma aleatória para você.
        </p>

        <!--        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
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
                </div>-->

        <div class="">
            <div class="grid gap-3 grid-cols-2 mb-3"
                 :class="'md:grid-cols-' + (quotas.length > 2 ? quotas.length / 2 : 'DA')">
                <template v-for="(item, index) in quotas" :key="index">
                    <Button type="button" color="outline-light" @click="addQuotas(item.quantity)" class="flex-col">
                        <span class="text-3xl font-bold">+ {{ item.quantity }}</span>
                        <span class="text-xs">Selecionar</span>
                    </Button>
                </template>
            </div>

            <div class="px-5 py-3 w-full flex items-center justify-center gap-2 bg-base-100 mb-3 rounded-xl">
                <div class="w-6/12 md:w-3/12 mx-auto flex items-center">
                    <button type="button" class="c-btn-count"
                            @click="removeItem">
                        <Icon name="icon-minus"/>
                    </button>
                    <p class="px-5 flex-1 bg-base-100 rounded-lg text-xl font-bold text-center text-neutral">
                        {{ quantity }}
                    </p>
                    <button type="button" class="c-btn-count"
                            @click="addItem">
                        <Icon name="icon-plus"/>
                    </button>
                </div>
            </div>

            <div class="px-5 py-3 w-full flex items-center justify-between gap-4 bg-primary mb-3 rounded-xl">
                <p class="w-6/12 text-sm text-primary-bw">{{ quantity }} x {{ func.formatValue(value) }} </p>

                <p class="w-6/12 text-right text-sm md:text-sm text-primary-bw">
                    Total <span class="text-xl font-bold text-primary-bw">{{ func.formatValue(total) }}</span>
                </p>
            </div>

            <Button type="button" color="success" size="lg" class="w-full uppercase font-bold pulsate-fwd"
                    @click="filterItems('paid')">
                <Icon name="icon-check-circle" class="h-6 mr-2 stroke-success-bw"/> QUERO PARTICIPAR
            </button>
        </div>
    </div>
</template>

<style src="./style.scss" lang="scss" scoped/>
