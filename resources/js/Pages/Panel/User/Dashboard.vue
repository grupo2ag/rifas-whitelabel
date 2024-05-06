<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '../../../Layouts/AuthenticatedLayout.vue';
import CarouselDashboard from '../../../Components/Carousel/CarouselDashboard.vue';
import CardDashboard from '../../../Components/Cards/CardDashboard.vue';
import {
    Squares2X2Icon,
    CurrencyDollarIcon,
    TruckIcon
} from '@heroicons/vue/24/outline'
import TimeLineUser from '../../../Components/TimeLine/TimeLineUser.vue';
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
            <div class="flex flex-row gap-3 min-h-[35rem]">
                <div class="w-6/12 py-2 rounded-lg bg-content">
                    <CarouselDashboard />
                </div>
                <div class="flex flex-wrap justify-center w-6/12">
                    <div class="flex flex-row w-full h-1/6 ">
                        <div class="w-4/12 px-2">
                            <CardDashboard :title="'Campanhas Ativas'" :valueCount="'1'" />
                        </div>
                        <div class="w-4/12 px-2">
                            <CardDashboard :title="'Campanhas Finalizadas'" :valueCount="'0'" />
                        </div>
                        <div class="w-4/12 px-2">
                            <CardDashboard :title="'Total Arrecadado'" :valueCount="'R$4,000.000'" />
                        </div>
                    </div>
                    <div class="flex flex-row w-full pt-6 h-5/6">
                        <div class="flex w-6/12 px-2 ">
                            <div class="flex justify-center w-full rounded-lg bg-content">
                                <TimeLineUser/>
                            </div>
                        </div>
                        <div class="flex w-6/12 px-2 ">
                            <div class="flex justify-center w-full rounded-lg bg-content ">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
