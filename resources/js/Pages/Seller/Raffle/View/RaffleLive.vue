<script setup>
import debounce from 'lodash/debounce';
import {
    UserIcon,
    CurrencyDollarIcon,
    PhoneIcon,
    EnvelopeIcon,
    CalendarDaysIcon,
    TicketIcon,
    MagnifyingGlassIcon
} from '@heroicons/vue/24/outline';
</script>

<script>

export default {
    props: {
        id: Number | String
    },
    data() {
        return {
            dataNumbers: {},
            collapse: [],
            displayedNumbers: [],
            pageSize: 100, // Quantos números carregar por vez
            currentIndex: 0, // Índice atual para controlar a páginação
            displayedNumbersPaid: [],
            currentIndexPaid: 0,
            displayedNumbersReserved: [],
            currentIndexReserved: 0,
            array_raffle: [],
            array_reserved: [],
            array_paid: [],
            // numbers: this.adjust(),
            searchQuery: '',
            loading: false,
        };
    },
    computed: {
        allNumbersLoaded() {
            if (this.dataNumbers?.raffle) {
                return this.currentIndex <= this.array_raffle.length;
            }
        },
        allNumbersReservedLoaded() {
            if (this.dataNumbers?.reserved) {
                return this.currentIndexReserved <= this.array_reserved.length;
            }
        },
        allNumbersPaidLoaded() {
            if (this.dataNumbers?.paid)
                return this.currentIndexPaid <= this.array_paid.length;
        }
    },
    methods: {
        /*async search() {
            this.loading = true;
               await axios.get(route('raffles.raffleParticipants', {
                    query: this.searchQuery,
                    page: this.currentPage,
                    idRaffle: this?.dataNumbers?.raffle?.id
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
        loadMore() {
            const nextIndex = this.currentIndex + this.pageSize;
            const moreNumbers = this.array_raffle.slice(this.currentIndex, nextIndex);
            this.displayedNumbers.push(...moreNumbers);
            this.currentIndex = nextIndex;
        },
        loadMorePaid() {
            const nextIndex = this.currentIndexPaid + this.pageSize;
            const moreNumbers = this.array_paid.slice(this.currentIndexPaid, nextIndex);
            this.displayedNumbersPaid.push(...moreNumbers);
            this.currentIndexPaid = nextIndex;
        },
        loadMoreReserved() {
            const nextIndex = this.currentIndexReserved + this.pageSize;
            const moreNumbers = this.array_reserved.slice(this.currentIndexReserved, nextIndex);
            this.displayedNumbersReserved.push(...moreNumbers);
            this.currentIndexReserved = nextIndex;
        },

        getNumbers() {
            this.loading = true;
            axios.get(route('raffles.raffleLive', { 'id': this?.id ?? 3 }))
                .then(response => {
                    this.dataNumbers = response?.data?.data;
                    this.array_raffle = this.translateToArray(response?.data?.data?.raffle ?? []);
                    this.array_paid = this.translateToArray(response?.data?.data?.paid ?? []);
                    this.array_reserved = this.translateToArray(response?.data?.data?.reserved ?? []);
                    this.loadMore();
                    this.loadMorePaid();
                    this.loadMoreReserved();
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Erro na busca:', error);
                    this.loading = false;
                });
        },
        search() {
            if (this.searchQuery.length) {
                var buscaRaffle = this.array_raffle.filter((item) => {
                    return item.startsWith(this.searchQuery);
                })
                if (buscaRaffle.length) {
                    this.$swal(
                        'Disponível!',
                        `O número ${this.searchQuery} está disponível.`,
                        'info'
                    )
                }

                var buscaReserved = this.array_reserved.filter((item) => {
                    return item.startsWith(this.searchQuery);
                })
                if (buscaReserved.length) {
                    this.$swal(
                        'Reservado!',
                        `O número ${this.searchQuery} está reservado!`,
                        'warning'
                    )
                }

                var buscaPaid = this.array_paid.filter((item) => {
                    return item.startsWith(this.searchQuery);
                })
                if (buscaPaid.length) {
                    this.$swal(
                        'Pago!',
                        `O número ${this.searchQuery} está pago!`,
                        'success'
                    )
                }
            }
        },
        // adjust() {
        //     let array_raffle = this?.dataNumbers?.raffle ? this.dataNumbers?.raffle.split(',') : [];
        //     let array_reserved = this?.dataNumbers?.reserved ? this.dataNumbers?.reserved.split(',') : [];
        //     let array_paid = this?.dataNumbers?.paid ? this.dataNumbers?.paid.split(',') : [];

        //     let all = array_raffle.concat(array_paid)
        //     all = all.concat(array_reserved)
        //     all = all.sort();

        //     return all;
        // },
        translateToArray(numbers) {
            if (numbers && typeof numbers == 'string') {
                return numbers?.split(',');
            }
            return [];
        },
        handleSearch() {
            this.search();
        },
        // encontrarDuplicados(array) {
        //     var elementosDuplicados = [];
        //     var contador = {};

        //     // Conta a ocorrência de cada elemento no array
        //     array.forEach(function (elemento) {
        //         if (contador[elemento]) {
        //             contador[elemento]++;
        //         } else {
        //             contador[elemento] = 1;
        //         }
        //     });

        //     // Verifica quais elementos têm mais de uma ocorrência
        //     for (var elemento in contador) {
        //         if (contador[elemento] > 1) {
        //             for (var i = 1; i < contador[elemento]; i++) {
        //                 elementosDuplicados.push(elemento);
        //             }
        //         }
        //     }

        //     return elementosDuplicados;
        // }
    },
    created() {
        this.getNumbers();
        this.search()
        this.debouncedSearch = debounce(this.handleSearch, 1000); // 1000ms debounce
    },
    // mounted() {
    // }
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
                        class="w-full input input-sm input-bordered join-item xl:btn-md bg-content"
                        placeholder="Buscar..." />
                    <button class="border-none rounded-r-lg join-item btn btn-sm xl:btn-md bg-primary text-primary-bw">
                        <MagnifyingGlassIcon class="w-6" />
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-row flex-wrap w-full px-4 mb-4">
            <div
                class="relative z-20 w-auto p-2 border-t border-l border-r rounded-t-lg bg-base-100 top-[1px] border-neutral/50 text-neutral-70">
                Números
                Disponíveis</div>
            <div class="z-0 w-full p-2 border rounded-b-lg rounded-r-lg border-neutral/50">
                <ul class="grid grid-cols-4 gap-2 lg:grid-cols-20">
                    <li v-for="(number, index) in displayedNumbers" :key="number"
                        :class="index % 2 == 0 ? 'animate-fade-right' : 'animate-fade-left'"
                        class="py-1 text-sm font-semibold text-center border rounded-lg border-primary/20 bg-primary/5 text-neutral">
                        {{ number }}</li>
                </ul>
                <div v-if="allNumbersLoaded" class="flex flex-row justify-end mt-2 text-sm">
                    <div class="w-auto">
                        <button class="btn btn-xs btn-success text-primary-bw " @click="loadMore">
                            Ver Mais ...
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row flex-wrap w-full px-4 mb-4">
            <div
                class="relative z-20 w-auto p-2 border-t border-l border-r rounded-t-lg bg-base-100 border-neutral/50 top-[1px] text-neutral/70">
                Números
                Vendidos</div>
            <div class="z-0 w-full p-2 border rounded-b-lg rounded-r-lg border-neutral/50">
                <div v-if="displayedNumbersPaid.length > 0">
                    <ul class="grid grid-cols-4 gap-2 lg:grid-cols-20">
                        <li v-for="(number, index) in displayedNumbersPaid" :key="number"
                            :class="index % 2 == 0 ? 'animate-fade-right' : 'animate-fade-left'"
                            class="py-1 text-sm font-semibold text-center border rounded-lg border-primary/20 bg-primary/5 text-neutral">
                            {{ number }}</li>
                    </ul>
                </div>
                <div v-else class="flex justify-center w-full py-4 text-neutral/70">
                    <h2>Não há nenhum número pago.</h2>
                </div>
                <div v-if="allNumbersPaidLoaded" class="flex flex-row justify-end mt-2 text-sm">
                    <div class="w-auto">
                        <button class="btn btn-xs btn-success text-primary-bw " @click="loadMorePaid">
                            Ver Mais ...
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row flex-wrap w-full px-4">
            <div
                class="relative z-20 w-auto p-2 border-t border-l border-r rounded-t-lg bg-base-100 border-neutral/50 top-[1px] text-neutral/70">
                Números
                Reservados</div>
            <div class="z-0 w-full p-2 border rounded-b-lg rounded-r-lg border-neutral/50">
                <div v-if="displayedNumbersReserved.length > 0">
                    <ul class="grid grid-cols-4 gap-2 lg:grid-cols-20">
                        <li v-for="(number, index) in displayedNumbersReserved" :key="number"
                            :class="index % 2 == 0 ? 'animate-fade-right' : 'animate-fade-left'"
                            class="py-1 text-sm font-semibold text-center border rounded-lg border-primary/20 bg-primary/5 text-neutral">
                            {{ number }}</li>
                    </ul>
                </div>
                <div v-else class="flex justify-center w-full py-4 text-neutral/70">
                    <h2>Não há nenhum número reservado.</h2>
                </div>
                <div v-if="allNumbersReservedLoaded" class="flex flex-row justify-end mt-2 text-sm">
                    <div class="w-auto">
                        <button class="btn btn-xs btn-success text-primary-bw " @click="loadMoreReserved">
                            Ver Mais ...
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
