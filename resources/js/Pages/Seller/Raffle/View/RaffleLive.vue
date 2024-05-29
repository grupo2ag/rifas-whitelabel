<script setup>
import StatsRaffleSale from '@/Components/Stats/StatsRaffleSale.vue';
import moment from 'moment';
import PaginationApi from '@/Components/Pagination/PaginationApi.vue';
import { Collapse } from 'vue-collapsed'
import * as func from '@/Helpers/functions';
import debounce from 'lodash/debounce';
import {
    UserIcon,
    CurrencyDollarIcon,
    PhoneIcon,
    EnvelopeIcon,
    CalendarDaysIcon,
    TicketIcon,
    MagnifyingGlassIcon} from '@heroicons/vue/24/outline';
</script>

<script>

export default {
    props: {
        data: Object
    },
    data() {
        return {
            collapse: [],
            array_raffle: this.data?.raffle.split(','),
            array_reserved: this.data?.reserved.split(','),
            array_paid: this.data?.paid.split(','),
            numbers: this.adjust(),
            searchQuery: '',
            currentPage: 1,
            loading: false,
        };
    },
    methods: {
        /*async search() {
            this.loading = true;
               await axios.get(route('raffles.raffleParticipants', {
                    query: this.searchQuery,
                    page: this.currentPage,
                    idRaffle: this?.data?.raffle?.id
                }))
                .then(response => {
                    this.results = response?.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Erro na busca:', error);
                    this.loading = false;
                });
        },*/
        search() {
            if(this.searchQuery.length){
                var buscaRaffle = this.array_raffle.filter((item)=>{
                    return item.startsWith(this.searchQuery);
                })
                if(buscaRaffle.length){
                    alert('numero está disponivel:'+ this.searchQuery)
                }

                var buscaReserved = this.array_reserved.filter((item)=>{
                    return item.startsWith(this.searchQuery);
                })
                if(buscaReserved.length){
                    alert('numero está reservado:'+  this.searchQuery)
                }

                var buscaPaid = this.array_paid.filter((item)=>{
                    return item.startsWith(this.searchQuery);
                })
                if(buscaPaid.length){
                    alert('numero está pago:'+  this.searchQuery)
                }
            }
        },
        adjust() {
            let array_raffle = this.data?.raffle.split(',');
            let array_reserved = this.data?.reserved.split(',');
            let array_paid = this.data?.paid.split(',');

            let all = array_raffle.concat(array_paid)
            all = all.concat(array_reserved)
            all = all.sort();

            return all;
        },
        handleSearch() {
            this.search();
        },
        encontrarDuplicados(array) {
            var elementosDuplicados = [];
            var contador = {};

            // Conta a ocorrência de cada elemento no array
            array.forEach(function(elemento) {
                if (contador[elemento]) {
                    contador[elemento]++;
                } else {
                    contador[elemento] = 1;
                }
            });

            // Verifica quais elementos têm mais de uma ocorrência
            for (var elemento in contador) {
                if (contador[elemento] > 1) {
                    for (var i = 1; i < contador[elemento]; i++) {
                        elementosDuplicados.push(elemento);
                    }
                }
            }

            return elementosDuplicados;
        }
    },
    created() {
        this.search()
        this.debouncedSearch = debounce(this.handleSearch, 1000); // 300ms debounce
    },
    /*mounted() {

    }*/
}
</script>
<template>
    <div class="flex flex-row flex-wrap w-full py-2 mt-4 rounded-lg bg-base-100">
        <div class="flex flex-wrap w-full my-2">
            <div class="flex justify-start w-full px-4 mb-2 xl:w-8/12 text-neutral/70 card-title">
                Numeros da Rifa
            </div>
            <div class="flex justify-end w-full px-4 mb-2 xl:w-4/12 card-title">
                <div class="w-full join">
                    <input v-model="searchQuery" @input="debouncedSearch"
                        class="w-full input input-sm input-bordered join-item xl:btn-md bg-content" placeholder="Buscar..." />
                    <button class="border-none rounded-r-lg join-item btn btn-sm xl:btn-md bg-primary text-primary-bw">
                        <MagnifyingGlassIcon class="w-6" />
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12">
            numeros disponiveis
            <p class="grid grid-cols-12">{{this.data.raffle}}</p>
        </div>

        <div class="flex justify-end">
            numeros vendidos
            {{this.data.paid}}
        </div>

        <div class="flex justify-end">
            numeros reservados
            {{this.data.reserved}}
        </div>

    </div>
</template>
