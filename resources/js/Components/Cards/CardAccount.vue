<script setup>
import * as func from '@/Helpers/functions';
</script>

<script>
import Icon from '@/Components/Icon/Icon.vue'
import Button from '@/Components/Button/Button.vue'
import Badge from '@/Components/Badge/Badge.vue'

export default {
    components: {
        Icon,
        Button,
        Badge
    },
    props: {
        data: Object
    },
    data(){
        return{
            purchase: {
                color: '',
                text: ''
            }
        }
    },
    mounted(){
        switch(this.data.purchase) {
            case 'PAID':
                this.purchase.color = 'success'
                this.purchase.text = 'Pago'
                break;
            case 'RESERVED':
                this.purchase.color = 'danger'
                this.purchase.text = 'Reservado'
                break;
            case 'CANCELED':
                this.purchase.color = 'black'
                this.purchase.text = 'Cancelado'
                break;
            case 'PROCESSING':
                this.purchase.color = 'warning'
                this.purchase.text = 'Aguardando Pagamento'
                break;
            default:
        }
        //console.log(this.data)
    }
}
</script>

<template>
    <div class="w-full p-3 border border-primary/20 bg-neutral/5 rounded-xl">
        <div class="w-full flex items-center justify-center gap-4">
            <figure class="flex-1 aspect-square overflow-hidden">
                <img :src="data.galery" class="w-full h-full object-cover rounded-xl" :alt="data.title">

                <figcaption>Sorteado</figcaption>
            </figure>

            <div class="w-9/12">
                <p class="text-neutral text-lg font-bold mb-1">{{data.title}}</p>

                <p class="text-sm text-neutral/70 mb-1">Status da transação:
                    <Badge :color="purchase.color" size="xs">
                        {{purchase.text}}
                    </Badge>
                </p>

                <p class="text-sm text-neutral/70 mb-1">Quantidade de bilhetes:
                    <strong class="text-neutral font-bold">{{data.count}}</strong>
                </p>

                <p class="text-sm text-neutral/70 mb-1">Total: <strong class="text-neutral font-bold">{{ func.formatValue(data.amount) }}</strong></p>

                <div class="flex gap-6">
                    <a v-if="data.purchase === 'PAID'" :href="route('openpay', data.id)" target="_blank" class="inline-flex text-xs flex items-center text-primary hover:opacity-60">
                        <Icon name="icon-eye" class="w-4 h-4 stroke-primary mr-1"/>Ver Comprovante
                    </a>

                    <a v-else :href="route('openpay', data.id)" target="_blank" class="inline-flex text-xs flex items-center text-primary hover:opacity-60">
                        <Icon name="icon-banknotes" class="w-4 h-4 stroke-primary mr-1"/>Realizar Pagamento
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-2 border-t border-neutral/10 pt-2">
            <p class="text-sm text-neutral mb-2">Títulos:</p>
            <ul v-if="data.raffle.type === 'manual' || data.purchase === 'PAID'" class="grid grid-cols-5 md:grid-cols-8 gap-1">
                <template v-for="item in data.numbers.split(',')">
                    <li class="border border-primary/20 bg-primary/5 text-neutral font-semibold py-1 text-sm text-center ">{{item}}</li>
                </template>
            </ul>
            <p v-else class="text-sm text-neutral">Os titulos são liberados após o pagamento</p>
        </div>
    </div>
</template>
