<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '../../../Layouts/AuthenticatedLayout.vue';
import CarouselDashboard from '../../../Components/Carousel/CarouselDashboard.vue';
import CardDashboard from '../../../Components/Cards/CardDashboard.vue';
import VueApexCharts from "vue3-apexcharts";
import {
    Squares2X2Icon,
    CurrencyDollarIcon,
    TruckIcon
} from '@heroicons/vue/24/outline'
import TimeLineUser from '../../../Components/TimeLine/TimeLineUser.vue';

const options = { //MOCK, TRAZER DADOS REAIS DO BANCO DE DADOS
    chart: {
        height: 350,
        type: 'area'
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        type: 'datetime',
        categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    },
}
const series = [{
    name: 'exemplo1',
    data: [30, 40, 45, 50, 49, 60, 70]
}, {
    name: 'exemplo2',
    data: [11, 32, 45, 32, 34, 52, 41]
}]


</script>

<script>
export default {
    props: {
        data: Object
    }
}
</script>

<template>

    <Head title="Dashboard"></Head>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="flex items-center font-semibold text-white lg:text-xl">
                <Squares2X2Icon class="w-5 h-5 mr-2 text-white lg:w-6 lg:h-6" />
                Dashboard
            </h2>
        </template>
        <div class="container">
            <!-- <CarouselDashboard /> -->
            <div class="flex flex-row gap-3 lg:min-h-[35rem] mb-6 md:flex-wrap flex-wrap lg:flex-nowrap">
                <div class="w-full py-2 rounded-lg lg:w-6/12 bg-content md:w-full">
                    <CarouselDashboard />
                </div>
                <div class="flex flex-wrap justify-center w-full lg:w-6/12 md:w-full">
                    <div class="flex flex-row flex-wrap w-full lg:h-1/6 ">
                        <div class="w-full px-2 mb-2 lg:w-4/12 md:w-6/12 ">
                            <CardDashboard :title="'Campanhas Ativas'" :valueCount="'1'" />
                        </div>
                        <div class="w-full px-2 mb-2 lg:w-4/12 md:w-6/12 ">
                            <CardDashboard :title="'Campanhas Finalizadas'" :valueCount="'0'" />
                        </div>
                        <div class="w-full px-2 mb-2 lg:w-4/12 md:w-6/12 ">
                            <CardDashboard :title="'Total Arrecadado'" :valueCount="'R$4,000.000'" />
                        </div>
                    </div>
                    <div class="flex flex-row flex-wrap w-full pt-6 lg:h-5/6">
                        <div class="flex w-full px-2 lg:w-6/12 md:w-6/12">
                            <div class="flex justify-center w-full rounded-lg bg-content">
                                <TimeLineUser />
                            </div>
                        </div>
                        <div class="flex w-full px-2 lg:w-6/12 md:w-6/12">
                            <div class="flex flex-wrap justify-center w-full p-4 rounded-lg bg-content">
                                <div class="flex flex-row w-full mb-4">
                                    <div class="flex justify-center w-full p-4 rounded-lg bg-base-100">
                                        <span>Imagem</span>
                                    </div>
                                </div>
                                <div class="flex flex-row justify-center w-full">
                                    <div class="flex justify-center">
                                        <button class="p-2 border-none rounded-lg bg-primary btn">Adicionar meio de
                                            pagamento</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 flex-row min-h-[23rem] max-h-[20rem] flex-wrap lg:flex-nowrap">
                <div class="items-center justify-center w-full py-2 rounded-lg lg:w-6/12 md:w-full bg-content">
                    <VueApexCharts type="area" height="350" :options="options" :series="series"></VueApexCharts>
                </div>
                <div class="w-full px-2 pl-3 lg:w-6/12 md:w-full">
                    <div class="w-full h-full rounded-lg bg-content min-h-max">
                        <VueApexCharts type="bar" height="350" :options="options" :series="series"></VueApexCharts>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
