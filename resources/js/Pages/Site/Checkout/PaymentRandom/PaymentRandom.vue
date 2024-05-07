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
            items: [],
            selected: [],
            showModal: false,
            value: 199,
            total: 0,
            quantity: 1
        }
    },
    methods: {
        filterItems(status) {
            if (status === 'all') {
                document.querySelectorAll(".c-raffle__number").forEach(function(el) {
                    el.style.display = 'block';
                });
            } else {
                document.querySelectorAll(".c-raffle__number").forEach(function(el) {
                    el.style.display = 'none';
                });

                document.querySelectorAll(".c-raffle__number--" + status).forEach(function(el) {
                    el.style.display = 'block';
                });
            }
        },
        removeItem(){
            if (this.quantity > 1) {
                this.quantity--
            }
        },
        addItem(){
            if (this.quantity < 7) {
                this.quantity++
            }
        }
    },
}
</script>

<template>
    <div class="flex flex-col">
        <p class="text-center font-bold text-neutral mb-6">Compra Automática<br>
            O site escolhe números aleatórios para você.</p>

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

        <div class="pt-6 border-t border-black/20">

            <div class="flex items-center gap-4 ">

                <div class="w-4/12 flex items-center gap-2">
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

                <Button type="button" color="success" class=""
                        @click="filterItems('paid')">
                    Pago
                </button>
            </div>
        </div>
    </div>
</template>

<style src="./style.scss" lang="scss" scoped/>
