<script setup>
import StatsRaffle from '@/Components/Stats/StatsRaffle.vue';
import VueApexCharts from "vue3-apexcharts";
import moment from 'moment';
import {
    TicketIcon,
    DocumentTextIcon,
    UserIcon,
    CheckCircleIcon,
    XCircleIcon
} from '@heroicons/vue/24/outline';
defineProps({
    data: Object,
});
function options(data, colors) {
    //MOCK, TRAZER DADOS REAIS DO BANCO DE DADOS
    return {
        chart: {
            height: 350
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: getDates(data)
        },
        tooltip: {
            x: {
                format: 'dd/MM/yyyy'
            },
        },
        colors: colors ?? []
    }
}
function series(names, datas) {
    if ((!datas || !names) || (!Array.isArray(datas) || !Array.isArray(names))) return [];

    const series = [];
    for (let i = 0; i < datas.length; i++) {
        series.push(
            {
                name: names[i],
                data: getValues(datas[i])
            }
        )
    }

    return series;
}

function getDates(dates) {
    return dates.map(date => translateDate(date.date));
}
function getValues(dates) {
    return dates.map(date => date.value);
}
function translateDate(data) {
    return moment(data).format('DD/MM/YYYY');
}

</script>

<template>
    <div class="flex flex-row flex-wrap justify-center">
        <div class="w-full px-2 mb-2 lg:w-3/12">
            <StatsRaffle :title="'Participantes'" :value="data?.participants?.distinct ?? 0"
                :textBottom="'Total de participantes'">
                <template #iconTextBottom>
                    <UserIcon class="w-4 mr-1" />
                </template>
            </StatsRaffle>
        </div>
        <div class="w-full px-2 mb-2 lg:w-3/12">
            <StatsRaffle :title="'Cotas Geradas'" :value="(data?.raffle?.paid || data?.raffle?.pix_expired) ? data?.raffle?.paid + data?.raffle?.pix_expired : 0"
                :textBottom="'Total de cotas geradas'">
                <template #iconTextBottom>
                    <TicketIcon class="w-4 mr-1" />
                </template>
            </StatsRaffle>
        </div>
        <div class="w-full px-2 mb-2 lg:w-3/12">
            <StatsRaffle :title="'Cotas Pagas'" :value="data?.raffle?.paid ?? 0" :textBottom="'Total de cotas pagas'">
                <template #iconTextBottom>
                    <CheckCircleIcon class="w-4 mr-1"/>
                </template>
            </StatsRaffle>
        </div>
        <div class="w-full px-2 mb-2 lg:w-3/12">
            <StatsRaffle :title="'Cotas Expiradas'" :value="data?.raffle?.pix_expired ?? 0"
                :textBottom="'Total de cotas expiradas'">
                <template #iconTextBottom>
                    <XCircleIcon class="w-4 mr-1"/>
                </template>
            </StatsRaffle>
        </div>
    </div>
    <div v-if="data?.grafics?.paid?.length > 0 || data?.grafics?.expired?.length > 0" class="mt-4 flex gap-3 flex-row min-h-[23rem] lg:max-h-[25rem] flex-wrap lg:flex-nowrap">
        <div class="items-center justify-center w-full py-2 rounded-lg lg:w-6/12 bg-base-100 animate-fade-right">
            <div class="flex flex-row flex-wrap">
                <div class="w-full px-4">
                    <h2 class="text-base text-xl font-medium title-font">Participantes/Dia</h2>
                </div>
                <div class="w-full">
                    <VueApexCharts type="area" height="350" :options="options(data?.grafics?.participants)"
                        :series="series(['Participantes'], [data?.grafics?.participants])"></VueApexCharts>
                </div>
            </div>
        </div>
        <div class="items-center justify-center w-full py-2 rounded-lg lg:w-6/12 bg-base-100 animate-fade-left">
            <div class="w-full h-full rounded-lg bg-base-100 min-h-max">
                <div class="flex flex-row flex-wrap">
                    <div class="w-full px-4">
                        <h2 class="text-base text-xl font-medium title-font">Cotas/Dia</h2>
                    </div>
                    <div class="w-full">
                        <VueApexCharts type="bar" height="350"
                            :options="options(data?.grafics?.paid, ['#3EA077', '#117dcc'])"
                            :series="series(['Pago', 'Expirado'], [data?.grafics?.paid, data?.grafics?.reserved])">
                        </VueApexCharts>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
