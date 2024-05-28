<script setup>
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
            await axios.get(route('affiliate.affiliateCommissions', {
                query: this.searchQuery,
                page: this.currentPage,
                idAffiliate: this?.data?.id
            }))
                .then(response => {
                    console.log(response?.data);
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
    mounted() {
        //console.log(this.data);
    }
}
</script>
<template>
    <div class="flex flex-row flex-wrap w-full py-2 mt-4 rounded-lg bg-base-100">
        <div class="flex flex-wrap w-full my-2">
            <div class="flex justify-start w-full px-4 mb-2 xl:w-8/12 text-neutral/70 card-title">
                Minhas Comissões
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
            <div class="flex justify-center w-1/12 text-neutral/70">Rifa</div>
            <div class="flex justify-center w-2/12 text-neutral/70">Comissão (ganhos)</div>
            <div class="flex justify-center w-1/12 text-neutral/70">Total numeros vendidos</div>
            <div class="flex justify-center w-1/12 text-neutral/70">Total de vendas</div>
        </div>
        <div v-if="results && results.length > 0" class="w-full pr-3">
            <!-- loop -->
            <div v-for="(commission, index) in results" :key="commission.id" @click="handleAccordion(index)"
                 class="flex flex-row flex-wrap w-full py-2 m-2 rounded-lg lg:items-center bg-content animate-fade-down animate-duration-1000 ">
                <div class="flex justify-center w-full p-2 px-2 mx-2 mb-2 break-all rounded-lg lg:m-0 lg:w-1/12 bg-primary lg:bg-base-300 lg:bg-content lg:text-neutral/70 text-primary-bw">
                    {{ commission?.title }}</div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    <UserIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />{{ commission?.commission }}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    <UserIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />{{ commission?.quotas }}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    <EnvelopeIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-neutral/70" />{{ commission?.sales }}
                </div>
                <Collapse :on-collapse="this.collapse.push({id: index, value: false})" :when="this.collapse[index].value">
                    <p class="CollapseContent">
                        <ul class="grid grid-cols-1 gap-1">
                            <ul class="grid grid-cols-1 gap-1">
                                <li class="border border-primary/20 bg-primary/5 text-neutral font-semibold py-1 text-sm text-center">
                                    Comissão Tipo: {{ commission?.commission_type }}
                                </li>
                                <li class="border border-primary/20 bg-primary/5 text-neutral font-semibold py-1 text-sm text-center">
                                    Comissão Ganho: {{ commission?.commission_value }}
                                </li>
                                <li class="border border-primary/20 bg-primary/5 text-neutral font-semibold py-1 text-sm text-center">
                                    Link: {{ commission?.link }}
                                </li>
                                <li class="border border-primary/20 bg-primary/5 text-neutral font-semibold py-1 text-sm text-center">
                                    Valor Venda: {{ (commission?.price/100).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) }}
                                </li>
                                <li class="border border-primary/20 bg-primary/5 text-neutral font-semibold py-1 text-sm text-center">
                                    Status Rifa: {{ commission?.status }}
                                </li>
                            </ul>
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
