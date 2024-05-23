<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '../../../Layouts/AuthenticatedLayout.vue';
import PaymentMethodsCard from './View/PaymentMethodsCard.vue';
import * as func from '@/Helpers/functions';
import {
    Squares2X2Icon,
    CurrencyDollarIcon,
    TruckIcon
} from '@heroicons/vue/24/outline'

</script>

<script>
export default {
    name: "PaymentMethodsIndex",
    props: {
        data: Array
    },
    mounted() {
        //console.log(this.$page.props.flash.message)
    }
}
</script>

<template>

    <Head title="Métodos de Pagamento"></Head>
    <AuthenticatedLayout :user="$page.props.auth.user">
        <template #header>
            <h2 class="flex items-center font-semibold text-content lg:text-xl">
                <CurrencyDollarIcon class="w-5 h-5 mr-2 text-content lg:w-6 lg:h-6" />
                Métodos de Pagamento
            </h2>
        </template>
        <div class="container">
            <div class="flex flex-row flex-wrap w-full px-2 py-2 rounded-lg bg-content">
                <div class="flex w-full px-4 py-2">
                    <h1 class="w-full text-base text-xl font-medium title-font">{{ (!!this.$page.props.flash.message) ? this.$page.props.flash.message : 'Escolha um método de pagamento'  }}</h1>
                </div>
                <div class="flex flex-row flex-wrap w-full">
                    <div class="w-full px-2">
                        <div v-for="(paymentMethod, index) in data" :key="index" class="flex flex-row mb-4 rounded-lg animate-fade-down">
                            <PaymentMethodsCard :data="paymentMethod" :index="index"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
