<script setup>
import StatsRaffle from '@/Components/Stats/StatsRaffle.vue';
import VueApexCharts from "vue3-apexcharts";
import {
    TicketIcon,
    DocumentTextIcon
} from '@heroicons/vue/24/outline';
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
  name: "RaffleDashboard"
}
</script>

<template>
    <div class="flex flex-row flex-wrap justify-center mb-4">
        <div class="w-full px-2 mb-2 lg:w-3/12">
            <StatsRaffle :title="'Role'" :value="'75,000'" :textBottom="'↗︎ Exemplo de um texto de rodape'" />
        </div>
        <div class="w-full px-2 mb-2 lg:w-3/12">
            <StatsRaffle :title="'Role'" :value="'75,000'" :textBottom="'↗︎ Exemplo de um texto de rodape'" />
        </div>
        <div class="w-full px-2 mb-2 lg:w-3/12">
            <StatsRaffle :title="'Role'" :value="'75,000'" :textBottom="'↗︎ Exemplo de um texto de rodape'" />
        </div>
        <div class="w-full px-2 mb-2 lg:w-3/12">
            <StatsRaffle :title="'Role'" :value="'75,000'" :textBottom="'↗︎ Exemplo de um texto de rodape'" />
        </div>
    </div>
    <div class="flex gap-3 flex-row min-h-[23rem] lg:max-h-[20rem] flex-wrap lg:flex-nowrap">
        <div class="items-center justify-center w-full py-2 rounded-lg lg:w-6/12 bg-base-100">
            <VueApexCharts type="area" height="350" :options="options" :series="series"></VueApexCharts>
        </div>
        <div class="w-full lg:pl-3 lg:px-2 lg:w-6/12">
            <div class="w-full h-full rounded-lg bg-base-100 min-h-max">
                <VueApexCharts type="bar" height="350" :options="options" :series="series"></VueApexCharts>
            </div>
        </div>
    </div>
</template>
