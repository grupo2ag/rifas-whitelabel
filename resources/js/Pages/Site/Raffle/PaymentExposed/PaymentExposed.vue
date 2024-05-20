<script setup>
import * as func from '@/Helpers/functions';
import Checkout from "@/Pages/Site/Raffle/Checkout/Checkout.vue";
</script>

<script>
import Button from '@/Components/Button/Button.vue'
import Icon from '@/Components/Icon/Icon.vue'
import {remove} from "@ckeditor/ckeditor5-utils";

const numbersStatus = (numbers, participants) => {
      const numeros = numbers.split(',');

      let participantsNumeros = participants.map(function (cada){
          let partNumbers =  cada.numbers.split(',');
          if(partNumbers.length){
              if(partNumbers.length) {
                  return {
                      name: cada.name,
                      status: cada.reserved ? 'reserved' : 'paid',
                      numbers: partNumbers
                  };
              }
          }

          return [];
      })

    const numerosEncontrados = [];

    numeros.forEach(number => {
        let encontrado = false;
        participantsNumeros.forEach(participant => {
            if (participant.numbers.includes(number)) {
                numerosEncontrados.push({
                    buyer: participant.name,
                    status: participant.status,
                    number: number
                });
                encontrado = true;
            }
        });
        if (!encontrado) {
            numerosEncontrados.push({
                buyer: '',
                status: 'available',
                number: number
            });
        }
    });

    return numerosEncontrados;

}

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
    name: "PaymentExposed",
    components: {
        Button,
        Icon,
    },
    props:{
        raffle: Object
    },
    data() {
        return {
            data: numbersStatus(this.raffle.r_numbers, this.raffle.participants),
            items: [],
            selected: [],
            showModal: false,
            showCheckout: false,
            value: this.raffle.price,
            total: 0,
            min: this.raffle.minimum_purchase,
            max: this.raffle.maximum_purchase
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
                    this.data.filter((item) => item.number === number ? this.selected.push(item) : '');

                    this.$refs['numb_' + number][0].setAttribute('active', true)

                    let temPromo = promotion(this.raffle, this.selected.length)
                    //console.log(temPromo, this.selected.length);
                    if(temPromo){
                        if (this.selected.length <= this.max) {
                            this.total = temPromo[2]
                            this.value = temPromo[1]
                        }else this.removeItem(number)
                    }else{
                        if (this.selected.length <= this.max) {
                            this.value = this.raffle.price
                            this.total = this.selected.length * this.value
                        }else this.removeItem(number)
                    }

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

            let temPromo = promotion(this.raffle, this.selected.length)

            if(temPromo){
                if (this.selected.length >= this.min) {
                    this.total = temPromo[2]
                    this.value = temPromo[1]
                }
            }else{
                    this.value = this.raffle.price
                    this.total = this.selected.length * this.value
            }

            //this.total = this.selected.length * this.value

            this.$refs['numb_' + number][0].setAttribute('active', false)
        },
        onReserved(){
            console.log(this.selected)
        },
        openModal() {
            this.showCheckout = true
            document.body.classList.add('active');
        },
        closeModal() {
            this.showCheckout = false
            document.body.classList.remove('active');
        },
    },
    mounted() {
        //let teste = numbersStatus(this.raffle.r_numbers, this.raffle.participants)
        //console.log(teste);
    }
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
            <div class="grid grid-cols-4 md:grid-cols-10 gap-2 md:gap-1 mt-5">
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
                            <Button @click="openModal" type="button" color="success" class="w-full uppercase font-bold pulsate-fwd">
                                <Icon name="icon-check-circle" class="h-6 mr-2 stroke-success-bw"/>
                                Reservar
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
    <Checkout :raffle="raffle" :unit="value" :quantity="selected.length" :manual="selected" :total="total" :open="showCheckout" @close="closeModal"/>
</template>

<style src="./style.scss" lang="scss" scoped/>
