<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CardDashboard from '@/Components/Cards/CardDashboard.vue';
import ListCard from '@/Components/List/ListCard.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import {
    TicketIcon,
    CheckIcon,
    ClockIcon
} from '@heroicons/vue/24/outline';
</script>

<script>
export default {
    name: "RaffleIndex",
    props: {
        data: Array
    },
    data() {
        return {
            showModal: false
        }
    },
    methods: {
        openModal() {
            this.showModal = true
            document.body.classList.add('active');
        },
        closeModal() {
            this.showModal = false
            document.body.classList.remove('active');
        }
    },
    mounted() {
        console.log('Dados recebidos:', this.data);
    }
}
</script>

<template>

    <Head title="Rifas"></Head>
    <AuthenticatedLayout :user="$page.props.auth.user">
        <template #header>
            <h2 class="flex items-center font-semibold text-content lg:text-xl">
                <TicketIcon class="w-5 h-5 mr-2 text-content lg:w-6 lg:h-6" />
                Rifas
            </h2>
        </template>
        <div class="container sm:max-w-full !w-full">
            <div class="flex flex-row flex-wrap justify-center mb-2">
                <div class="w-full mb-2 lg:w-4/12 lg:px-2 sm:w-full sm:mb-2">
                    <CardDashboard :title="'Rifas Criadas'" :valueCount="data?.total_raffles ?? 0">
                        <template #icon>
                            <div class="p-2 mb-2 bg-white border rounded-full border-white-light timeline-middle">
                                <TicketIcon class="w-8" />
                            </div>
                        </template>
                    </CardDashboard>
                </div>
                <div class="w-full mb-2 lg:w-4/12 lg:px-2 sm:w-full sm:mb-2">
                    <CardDashboard :title="'Rifas Ativas'" :valueCount="data?.total_raffles_active ?? 0" >
                        <template #icon>
                            <div class="p-2 mb-2 bg-white border rounded-full border-white-light timeline-middle">
                                <ClockIcon class="w-8" />
                            </div>
                        </template>
                    </CardDashboard>
                </div>
                <div class="w-full mb-2 lg:w-4/12 lg:px-2 sm:w-full sm:mb-2">
                    <CardDashboard :title="'Rifas Encerradas'" :valueCount="data?.total_raffles_finished ?? 0">
                        <template #icon>
                            <div class="p-2 mb-2 bg-white border rounded-full border-white-light timeline-middle">
                                <CheckIcon class="w-8" />
                            </div>
                        </template>
                    </CardDashboard>
                </div>
                <!-- <div class="w-full mb-2 lg:w-3/12 lg:px-2 sm:w-full sm:mb-2">
                    <CardDashboard :title="'Total Arrecadado'" :valueCount="'R$4,000.000'" />
                </div> -->
            </div>
            <div class="card bg-content">
                <div class="flex flex-row">
                    <div class="flex justify-start w-full">
                        <div class="px-4 text-neutral card-title">
                            Minhas Rifas
                        </div>
                    </div>
                    <div class="flex justify-end w-full px-4 py-4">
                        <!--                        <button :href="route('rafflecreated')" class="text-black btn border-none bg-[#dedede]">Criar Rifa</button>-->
                        <Link :href="route('raffles.raffleCreated')" class="text-black btn border-none bg-[#dedede]">
                        Criar Rifa
                        </Link>
                    </div>
                </div>
                <div class="flex flex-row flex-wrap px-2 mb-4">
                    <div class="hidden w-full h-10 mb-4 rounded-lg bg-base-100 xl:grid">
                        <div class="flex flex-row p-2">
                            <div class="flex justify-center w-1/12"></div>
                            <div class="flex justify-start w-4/12 ml-4">Nome</div>
                            <div class="flex justify-center w-1/12">Status</div>
                            <div class="flex justify-center w-2/12">Valor/Cota</div>
                            <div class="flex justify-center w-1/12">%</div>
                            <div class="flex justify-center w-2/12">Criada Em</div>
                            <div class="flex justify-center w-1/12"></div>
                        </div>
                    </div>
                    <div v-for="raffle in data?.data" :key="raffle?.id" class="w-full mb-4">
                        <ListCard :infos="raffle" />
                    </div>
                    <div class="flex flex-row w-full px-2" :class='{ "hidden": data?.last_page == 1 }'>
                        <div class="flex justify-end w-full">
                            <Pagination :data="data" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
