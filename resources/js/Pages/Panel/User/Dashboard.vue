<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '../../../Layouts/AuthenticatedLayout.vue';
import CardDashboard from '../../../Components/Cards/CardDashboard.vue';
import CardCampaign from '../../../Components/Cards/CardCampaign.vue';
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
            <div class="flex flex-row">

            </div>
        </div>
    </AuthenticatedLayout>
</template>
