

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import debounce from 'lodash/debounce';
import {
    CreditCardIcon,
    UserIcon,
    CurrencyDollarIcon,
    PhoneIcon,
    EnvelopeIcon,
    CalendarDaysIcon,
    TicketIcon,
    MagnifyingGlassIcon,
    PencilSquareIcon,
    PlusCircleIcon,
    LinkIcon,
    DocumentTextIcon,
    BanknotesIcon
} from '@heroicons/vue/24/outline';
</script>

<script>

export default {
    props: {
        id: Number | String
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
        redirectToEdit(id){
            window.location.href = route('affiliate.affiliateEdit', id);
        },
        getAffiliates() {
            this.loading = true;
            axios.get(route('raffles.raffleAffiliates', {
                id: this.id
            }))
                .then(response => {
                    this.results.data = response?.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
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
                if (val.id === index) {
                    this.collapse[i].value = !val.value
                } else this.collapse[i].value = false
            })
        }
    },
    created() {
        this.getAffiliates();
        this.debouncedSearch = debounce(this.handleSearch, 500); // 300ms debounce
    },
    // mounted() {
    //     console.log(this.data);
    // }
}
</script>
<template>
    <div class="card bg-content animate-fade-up">
                <div class="flex flex-row">
                    <div class="flex justify-start w-full">
                        <div class="px-4 text-neutral/70 card-title">
                            Afiliados Cadastrados
                        </div>
                    </div>
                    <div class="flex justify-end w-full px-4 py-4 animate-fade-left">
                        <Link :href="route('affiliate.affiliateCreated')" class="text-black border-none btn btn-sm xl:btn-md lg:btn-md bg-primary">
                            <div class="flex flex-row items-center text-primary-bw">
                                <PlusCircleIcon class="w-6 mr-2 text-primary-bw"/>
                                Criar Afiliado
                            </div>
                        </Link>
                    </div>
                </div>
                <div v-if="(!results?.data || results?.data?.length == 0) && loading == false" class="flex items-center justify-center w-full h-full py-40">
                    <span class="text-base text-xl font-medium title-font">Ainda não há afiliados</span>
                </div>
                <div v-else class="flex flex-row flex-wrap px-2 mb-4">
                    <div class="hidden w-full h-10 mb-4 rounded-lg bg-base-100 xl:grid">
                        <div class="flex flex-row flex-wrap p-2">
                            <div class="flex justify-center w-2/12 text-neutral/70">Nome</div>
                            <div class="flex justify-center w-2/12 text-neutral/70">Link</div>
                            <div class="flex justify-center w-1/12 text-neutral/70">Telefone</div>
                            <div class="flex justify-center w-2/12 text-neutral/70">Email</div>
                            <div class="flex justify-center w-1/12 text-neutral/70">Documento</div>
                            <div class="flex justify-center w-3/12 text-neutral/70">Chave Pix</div>
                            <div class="flex justify-center w-1/12 text-neutral/70"></div>
                        </div>
                    </div>
                    <div v-for="affiliate in results?.data"
                        @click="redirectToEdit(affiliate.id)"
                        :key="affiliate?.id"
                        role="button"
                        class="w-full mb-4 rounded-lg hover:bg-base-300 animate-fade-down bg-base-100">
                        <div class="flex flex-row flex-wrap">
                            <div class="flex items-center w-full py-2 sm:w-full xl:w-2/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <UserIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-2/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <LinkIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.link ?? '----'}}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-1/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                   <PhoneIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-2/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <EnvelopeIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-1/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <DocumentTextIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.document }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 md:w-3/12 xl:w-3/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <BanknotesIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.pix_key }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-1/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <button class="hidden lg:flex xl:flex btn btn-sm btn-info"><PencilSquareIcon class="w-4 text-white"/></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row w-full px-2" :class='{ "hidden": results?.data?.last_page == 1 }'>
                        <div class="flex justify-end w-full">
                            <Pagination :data="results?.data" />
                        </div>
                    </div>
                </div>
            </div>

</template>

<style scoped>
.custom-grid-20 {
    @apply grid;
    grid-template-columns: repeat(20, minmax(0, 1fr));
}

@media (min-width: 1024px) {
    .lg\:grid-cols-20 {
        grid-template-columns: repeat(20, minmax(0, 1fr));
    }
}

@media (min-width: 1280px) {
    .lg\:grid-cols-20 {
        grid-template-columns: repeat(20, minmax(0, 1fr));
    }
}
</style>
