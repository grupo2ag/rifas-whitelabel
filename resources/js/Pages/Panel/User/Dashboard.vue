<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '../../../Layouts/AuthenticatedLayout.vue';
import CarouselDashboard from '../../../Components/Carousel/CarouselDashboard.vue';
import CardDashboard from '../../../Components/Cards/CardDashboard.vue';
import VueApexCharts from "vue3-apexcharts";
import StatsRaffleSale from '@/Components/Stats/StatsRaffleSale.vue';
import * as func from '@/Helpers/functions';
import {
    Squares2X2Icon,
    CurrencyDollarIcon,
    TruckIcon
} from '@heroicons/vue/24/outline'

</script>

<script>
export default {
    props: {
        data: Object
    },
    methods: {
        goToPaymentMethods() {
            window.location.href = '/paymentMethods';
        },
        goToCreateRaffle() {
            window.location.href = 'raffles/created'
        }
    }
    // mounted() {
    //     console.log('dados DASHBOARD: ', this.data)
    // }
}
</script>

<template>

    <Head title="Dashboard"></Head>
    <AuthenticatedLayout :user="$page.props.auth.user">
        <template #header>
            <h2 class="flex items-center font-semibold text-content lg:text-xl">
                <Squares2X2Icon class="w-5 h-5 mr-2 text-content lg:w-6 lg:h-6" />
                Dashboard
            </h2>
        </template>
        <div class="!w-full container-none px-2">
            <!-- <CarouselDashboard /> -->
            <div class="flex flex-row gap-4 lg:min-h-[35rem] mb-6 md:flex-wrap flex-wrap lg:flex-nowrap">
                <div class="w-full py-2 rounded-lg lg:w-6/12 bg-content md:w-full animate-fade-down">
                    <div v-if="!data?.raffles || data?.raffles?.data?.length == 0" class="flex items-center justify-center w-full h-full">
                        <button @click="goToCreateRaffle()" class="border-none btn bg-primary text-primary-bw">Adicione sua primeira rifa</button>
                    </div>
                    <div v-else >
                        <CarouselDashboard :data="data?.raffles?.data" />
                    </div>
                </div>
                <div class="flex flex-wrap justify-center w-full lg:w-6/12 md:w-full">
                    <div class="flex flex-row flex-wrap w-full lg:h-1/6 ">
                        <div class="w-full px-2 mb-2 lg:px-0 lg:pr-2 lg:w-4/12 md:w-6/12 animate-fade-down ">
                            <CardDashboard :title="'Rifas Ativas'"
                                :valueCount="data?.raffles?.total_raffles_active ?? 0" />
                        </div>
                        <div class="w-full px-2 mb-2 lg:w-4/12 md:w-6/12 animate-fade-down ">
                            <CardDashboard :title="'Rifas Finalizadas'"
                                :valueCount="data?.raffles?.total_raffles_finished ?? 0" />
                        </div>
                        <div class="w-full px-2 mb-2 lg:pl-2 lg:px-0 lg:w-4/12 md:w-6/12 animate-fade-down ">
                            <CardDashboard :title="'Rifas Criadas'" :valueCount="data?.raffles?.total_raffles" />
                        </div>
                    </div>
                    <div class="flex flex-row flex-wrap w-full lg:h-5/6">
                        <div class="flex w-full px-2 mb-4 lg:px-0 lg:pr-2 lg:w-6/12 md:w-6/12 lg:mb-0 md:mb-0">
                            <div class="flex justify-center w-full px-2 py-4 rounded-lg bg-content animate-fade-up">
                                <div class="flex flex-row flex-wrap w-full">
                                    <div class="flex justify-center w-full mb-2">
                                        <h1 class="text-base text-xl font-medium title-font">Ranking de Participantes</h1>
                                    </div>
                                    <div v-if="!data?.raffles?.ranking || data?.raffles?.ranking.length == 0" class="flex items-center justify-center w-full h-full">
                                            <span>Ainda não há nenhum participante.</span>
                                    </div>
                                    <div v-else class="w-full">
                                        <div v-for="(participant, index) in data?.raffles?.ranking" :key="index"
                                            class="w-full mb-2">
                                            <StatsRaffleSale :userName="participant?.name"
                                                :value="func.translateMoney(participant?.total_amount)"
                                                :textBottom="participant?.email"
                                                :shortName="func.getInitials(participant?.name)">
                                                <template #cup>
                                                    <div class="p-2 mb-2 bg-white border rounded-full border-white-light timeline-middle"
                                                        :class="func.getColorCup(index)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4 lg:w-6 lg:h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                                                        </svg>
                                                    </div>
                                                </template>
                                            </StatsRaffleSale>
                                        </div>
                                    </div>
                                </div>
                                <!-- <TimeLineUser /> -->
                            </div>
                        </div>
                        <div class="flex w-full px-2 lg:w-6/12 lg:px-0 lg:pl-2 md:w-6/12">
                            <div class="flex flex-wrap justify-center w-full p-4 rounded-lg bg-content animate-fade-up">
                                <div class="flex flex-row flex-wrap w-full mb-4 ">
                                    <div class="flex justify-center w-full">
                                        <h1 class="text-base text-xl font-medium">Meio de Pagamento</h1>
                                    </div>
                                    <div v-if="!!data?.gateway" class="flex justify-center w-full mb-2 rounded-lg">
                                        <figure class="h-full">
                                            <img class="object-cover w-full h-full rounded-lg"
                                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHEa_CL5PpEOY2FsC7VoTy74EecLP0FEIQ19xZlR3e-Q&s"
                                                alt="payment" />
                                        </figure>
                                    </div>
                                    <div v-if="!!data?.gateway" class="flex justify-center w-full">
                                        <span>{{ data?.gateway?.name }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-row justify-center w-full">
                                    <div class="flex justify-center w-full">
                                        <button
                                            class="w-full p-2 border-none rounded-lg bg-primary btn btn-sm lg:btn-md text-primary-bw btn-block"
                                            @click="goToPaymentMethods()">
                                            {{ !!data?.gateway ? 'Editar Meio de Pagamento' : 'Adicionar Meio de Pagamento' }}
                                            </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 flex-row min-h-[23rem] max-h-[30rem] flex-wrap lg:flex-nowrap px-2 lg:px-0">
                <div class="items-center justify-center w-full py-2 rounded-lg lg:w-6/12 md:w-full bg-content animate-fade-right">
                    <div class="flex flex-row flex-wrap">
                        <div class="w-full px-4">
                            <h2 class="text-base text-xl font-medium title-font">Participantes/Dia</h2>
                        </div>
                        <div class="w-full">
                            <VueApexCharts type="area" height="350"
                                :options="func.optionsOfGrafics(data?.grafics?.participantsPerDay)"
                                :series="func.seriesOfGrafics(['Participantes'], [data?.grafics?.participantsPerDay])">
                            </VueApexCharts>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-6/12 md:w-full">
                    <div class="w-full h-full py-2 rounded-lg bg-content min-h-max animate-fade-left">
                        <div class="flex flex-row flex-wrap">
                            <div class="w-full px-4">
                                <h2 class="text-base text-xl font-medium title-font">Cotas/Dia</h2>
                            </div>
                        </div>
                        <div class="w-full">
                            <VueApexCharts type="bar" height="350"
                                :options="func.optionsOfGrafics(data?.grafics?.paidPerDay, ['#3EA077', '#dc3545'])"
                                :series="func.seriesOfGrafics(['Pago', 'Expirado'], [data?.grafics?.paidPerDay, data?.grafics?.expiredPerDay])">
                            </VueApexCharts>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
