<script setup>
import * as func from '@/Helpers/functions';
import Badge from "@/Components/Badge/Badge.vue";
</script>

<script>
import Button from '@/Components/Button/Button.vue'
import Icon from '@/Components/Icon/Icon.vue'
import Checkout from '@/Pages/Site/Raffle/Checkout/Checkout.vue'

const promotion = (raffle, quantity) => {
    if(raffle?.raffle_promotions.length){
        let promotion = raffle.raffle_promotions;

        let discount = 0;
        let amount = 0;
        let total = 0;

        for(let i = 0; i < promotion.length; i++){
            let pm = promotion[i].quantity_numbers

            if(quantity >= pm){
                discount = promotion[i].discount;
                amount =  promotion[i].amount;
                total = amount * quantity;
            }
        }

        return total > 0 ? [discount, amount, total] : false;
    }

    return false;
}

export default {
    name: "PaymentRandom",
    components: {
        Button,
        Icon,
        Checkout,
    },
    props:{
      raffle: Object
    },
    data() {
        return {
            quotas: this.raffle?.raffle_popular_numbers.length ? this.raffle.raffle_popular_numbers :
            [
                    {'quantity_numbers': 10, 'popular': false},
                    {'quantity_numbers': 30, 'popular': false},
                    {'quantity_numbers': 50, 'popular': true},
                    {'quantity_numbers': 100, 'popular': false},
            ],
            items: [],
            selected: [],
            showModal: false,
            min: this.raffle.minimum_purchase,
            max: this.raffle.maximum_purchase,
            quantity: this.raffle.minimum_purchase,
            value: this.raffle.price,
            total: this.raffle.price*this.raffle.minimum_purchase
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
            this.quantity--
            let temPromo = promotion(this.raffle, this.quantity)
            //console.log(this.quantity, this.min, this.value, temPromo);
            if(temPromo){
                if (this.quantity >= this.min) {

                    this.total = temPromo[2]
                    this.value = temPromo[1]
                }
            }else{
                this.value = this.raffle.price
                if (this.quantity >= this.min) {

                    this.total = this.quantity * this.value
                }
            }
        },
        addItem() {
            this.quantity++
            let temPromo = promotion(this.raffle, this.quantity)

            if(temPromo){
                if (this.quantity < this.max) {
                    this.total = temPromo[2]
                    this.value = temPromo[1]
                }
            }else{
                this.value = this.raffle.price
                if (this.quantity < this.max) {
                    this.total = this.quantity * this.value
                }
            }
        },
        addQuotas(quotas) {
            this.quantity += quotas
            let temPromo = promotion(this.raffle, this.quantity)

            if(temPromo){
                if (this.quantity < this.max) {
                    this.total = temPromo[2]
                    this.value = temPromo[1]
                }else{
                    this.quantity = this.max
                }
            }else{
                this.value = this.raffle.price
                if (this.quantity < this.max) {
                    if(this.quantity > this.max) this.quantity = this.max
                    this.total = this.quantity * this.value

                }else{
                    this.quantity = this.max
                }
            }

        },
        openModal() {
            this.showModal = true
            document.body.classList.add('active');
        },
        closeModal() {
            this.showModal = false
            document.body.classList.remove('active');
        },
    },
    mounted() {
        //promotion(this.raffle,102)
        //console.log(this.raffle?.raffle_popular_numbers, this.raffle)
    }
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

        <div class="">
            <div class="grid gap-3 grid-cols-2 mb-3"
                 :class="'md:grid-cols-' + (quotas.length > 2 ? quotas.length / 2 : 'DA')">
                <template v-for="(item, index) in quotas" :key="index">
                    <Button type="button" color="outline-light" @click="addQuotas(item.quantity_numbers)" class="py-5 flex-col relative overflow-hidden">
                        <span class="text-3xl font-bold">+ {{ item.quantity_numbers }}</span>
                        <span class="text-xs">Selecionar</span>

                        <span v-if="item.popular" class="c-recomend">{{ item.popular ? 'Popular' : '' }}</span>
                    </Button>
                </template>
            </div>

            <div class="px-5 py-3 w-full flex items-center justify-center gap-2 bg-base-100 mb-2 rounded-xl">
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

            <div class="px-5 py-3 w-full flex items-center justify-center gap-2 bg-base-100 mb-3 rounded-xl">
                <p class="w-6/12 text-sm text-neutral">{{ quantity }} x {{ func.formatValue(value) }} </p>

                <p class="w-6/12 text-right text-sm md:text-sm text-neutral">
                    Total <span class="text-xl font-bold text-neutral">{{ func.formatValue(total) }}</span>
                </p>
            </div>

            <Button type="button" color="success" size="lg" class="w-full uppercase font-bold pulsate-fwd"
                    @click="openModal">
                <Icon name="icon-check-circle" class="h-6 mr-2 stroke-success-bw"/> QUERO PARTICIPAR
            </button>
        </div>

        <Checkout :raffle="raffle" :unit="value" :quantity="quantity" :total="total" :open="showModal" @close="closeModal"/>
    </div>
</template>

<style src="./style.scss" lang="scss" scoped/>
