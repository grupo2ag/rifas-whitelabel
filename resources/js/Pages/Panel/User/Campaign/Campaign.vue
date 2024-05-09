<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '../../../../Layouts/AuthenticatedLayout.vue';
import CardCampaign from '../../../../Components/Cards/CardCampaign.vue';
import CardDashboard from '../../../../Components/Cards/CardDashboard.vue';
import {
    TicketIcon
} from '@heroicons/vue/24/outline'
</script>

<script>
export default {
    props: {
        data: Object
    }
}
</script>

<template>
     <Head title="Campanhas"></Head>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="flex items-center font-semibold text-white lg:text-xl">
                <TicketIcon class="w-5 h-5 mr-2 text-white lg:w-6 lg:h-6" />
               Campanhas
            </h2>
        </template>
        <div class="container">
            <div class="flex flex-row flex-wrap mb-2">
                <div class="w-full mb-2 lg:w-3/12 lg:px-2 sm:w-full sm:mb-2">
                    <CardDashboard :title="'Campanhas Criadas'" :valueCount="'1'"/>
                </div>
                <div class="w-full mb-2 lg:w-3/12 lg:px-2 sm:w-full sm:mb-2">
                    <CardDashboard :title="'Campanhas Ativas'" :valueCount="'1'"/>
                </div>
                <div class="w-full mb-2 lg:w-3/12 lg:px-2 sm:w-full sm:mb-2">
                    <CardDashboard :title="'Campanhas Finalizadas'" :valueCount="'0'"/>
                </div>
                <div class="w-full mb-2 lg:w-3/12 lg:px-2 sm:w-full sm:mb-2">
                    <CardDashboard :title="'Total Arrecadado'" :valueCount="'R$4,000.000'"/>
                </div>
            </div>
            <div class="card bg-content">
                <div class="flex flex-row">
                    <div class="flex justify-start w-full">
                        <div class="px-4 text-neutral card-title">
                            Minhas Campanhas
                        </div>
                    </div>
                    <div class="flex justify-end w-full px-4 py-4">
                        <button class="text-black btn border-none bg-[#dedede]">Criar Campanha</button>
                    </div>
                </div>
                <div class="flex flex-row flex-wrap px-2 mb-4">
                    <div class="mb-4 lg:w-3/12 lg:px-2 sm:w-6/12 sm:px-2">
                        <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                    </div>
                    <div class="mb-4 lg:w-3/12 lg:px-2 sm:w-6/12 sm:px-2">
                        <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                    </div>
                    <div class="mb-4 lg:w-3/12 lg:px-2 sm:w-6/12 sm:px-2">
                        <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                    </div>
                    <div class="mb-4 lg:w-3/12 lg:px-2 sm:w-6/12 sm:px-2">
                        <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                    </div>
                    <div class="mb-4 lg:w-3/12 lg:px-2 sm:w-6/12 sm:px-2">
                        <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                    </div>
                    <div class="mb-4 lg:w-3/12 lg:px-2 sm:w-6/12 sm:px-2">
                        <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                    </div>
                    <div class="mb-4 lg:w-3/12 lg:px-2 sm:w-6/12 sm:px-2">
                        <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                    </div>
                    <div class="mb-4 lg:w-3/12 lg:px-2 sm:w-6/12 sm:px-2">
                        <CardCampaign :description="'Tenis Lindo verde da rifa incrivelmente dahora!'" :title="'Card de Teste'"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
