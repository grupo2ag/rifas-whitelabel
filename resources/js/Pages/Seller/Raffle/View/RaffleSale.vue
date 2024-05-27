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
            searchQuery: '',
            results: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            currentPage: 1,
            loading: false,
        };
    },
    methods: {
        async search() {
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
        },
        handleSearch() {
            this.currentPage = 1;
            this.search();
        },
        changePage(page) {
            if (page >= 1 && page <= this.results.last_page) {
                this.currentPage = page;
                this.search();
            }
        },
        handleAccordion(index) {
            this.collapse.forEach((val, i) => {
                if(val.id === index){
                    this.collapse[i].value = !val.value
                }else this.collapse[i].value = false
            })
        }
    },
    created() {
        this.search()
        this.debouncedSearch = debounce(this.handleSearch, 500); // 300ms debounce
    },
    // mounted() {
    //     console.log(this.data);
    // }
}
</script>
<template>
    <!-- <div v-if="!results?.data || results?.data?.length == 0"
        class="flex flex-row flex-wrap items-center justify-center w-full py-8 mb-4 rounded-lg bg-base-100">
        <span class="text-base text-xl font-medium title-font">Ainda não há vendas</span>
    </div> -->
    <div v-if="results?.data && results?.data?.length > 0" class="flex flex-row flex-wrap justify-center">
        <div v-for="(participant, index) in results?.data?.participants?.ranking" :key="index"
            class="w-full px-2 mb-2 lg:w-4/12">
            <StatsRaffleSale :userName="participant?.name" :value="func.translateMoney(participant?.total_value)"
                :textBottom="participant?.email" :shortName="func.getInitials(participant?.name)">
                <template #cup>
                    <div class="p-2 mb-2 bg-white border rounded-full border-white-light timeline-middle"
                        :class="func.getColorCup(index)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 lg:w-6 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </div>
                </template>
            </StatsRaffleSale>
        </div>
    </div>
    <div class="flex flex-row flex-wrap w-full py-2 mt-4 rounded-lg bg-base-100">
        <div class="flex flex-wrap w-full my-2">
            <div class="flex justify-start w-full px-4 mb-2 xl:w-8/12 text-neutral/70 card-title">
                Minhas Vendas
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
        <div class="flex-row items-center hidden w-full py-2 m-2 rounded-lg lg:flex bg-base-200">
            <div class="flex justify-center w-1/12 text-neutral/70">Id</div>
            <div class="flex justify-center w-2/12 text-neutral/70">Nome</div>
            <div class="flex justify-center w-2/12 text-neutral/70">Documento</div>
            <div class="flex justify-center w-2/12 text-neutral/70">Email</div>
            <div class="flex justify-center w-2/12 text-neutral/70">Telefone</div>
            <div class="flex justify-center w-1/12 text-neutral/70">Cotas</div>
            <div class="flex justify-center w-1/12 text-neutral/70">Valor</div>
            <div class="flex justify-center w-1/12 text-neutral/70">Data</div>
        </div>
        <div v-if="results?.data && results?.data?.length > 0" class="w-full pr-3">
            <!-- loop -->
            <div v-for="(sale, index) in results?.data" :key="sale.id" @click="handleAccordion(index)"
                class="flex flex-row flex-wrap w-full py-2 m-2 rounded-lg lg:items-center bg-content animate-fade-down animate-duration-1000 ">
                <div class="flex justify-center w-full p-2 px-2 mx-2 mb-2 break-all rounded-lg lg:m-0 lg:w-1/12 bg-primary lg:bg-base-300 lg:bg-content lg:text-neutral/70 text-primary-bw">
                    {{ sale?.id }}</div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    <UserIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />{{ func.truncateString(sale?.name, 20) }}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    <UserIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />{{ sale?.document }}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    <EnvelopeIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />{{ sale?.email }}
                </div>
                <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    <PhoneIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />{{ sale?.phone }}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-1/12">
                    <TicketIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />{{ sale?.paid }}
                </div>
                <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center text-neutral/70 lg:w-1/12">
                    <CurrencyDollarIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />
                    {{ func.translateMoney(sale?.amount) }}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-1/12">
                    <CalendarDaysIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />
                    {{ func.translateDate(sale?.created_at) }}
                </div>
                <Collapse :on-collapse="this.collapse.push({id: index, value: false})" :when="this.collapse[index].value">
                    <p class="CollapseContent">
                        <ul class="grid grid-cols-8 gap-1">
                            <template v-for="item in sale?.numbers.split(',')">
                                <li class="border border-primary/20 bg-primary/5 text-neutral font-semibold py-1 text-sm text-center ">{{item}}</li>
                            </template>
                        </ul>
                    </p>
                </Collapse>
            </div>
            <!--  -->
            <div class="flex flex-row w-full px-2"
                :class='{ "hidden": results?.data?.participants?.data?.last_page == 1 }'>
                <div class="flex justify-end w-full">
                    <PaginationApi :data="results" @pagination="changePage" />
                </div>
            </div>
        </div>
        <div v-else-if="loading" class="flex flex-row flex-wrap items-center justify-center w-full px-4 py-8 mb-4 rounded-lg bg-base-100">
            <div v-for="skn in [...Array(5).keys()].map(i => i + 1)" :key="skn" class="w-full mb-2 rounded-lg skeleton h-14 shrink-0"></div>
        </div>
        <div v-else class="flex flex-row flex-wrap items-center justify-center w-full py-8 mb-4 rounded-lg bg-base-100">
            <span class="text-base text-xl font-medium title-font text-neutral/70">Nenhuma venda encontrada</span>
        </div>
    </div>
</template>
