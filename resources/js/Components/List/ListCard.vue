<script setup>
import IconsSvg from "@/Components/IconsSvg/IconsSvg.vue";
import moment from 'moment';
import { Link } from '@inertiajs/inertia-vue3';
import * as func from '@/Helpers/functions';

</script>

<script>
export default {

    props: {
        infos: Object
    },
    // mounted(){
    //     console.log(this.infos, "LIST CARD")
    // }
}
</script>


<template>
    <!--    <Link :href="route('rafflesview', infos?.id)" class="p-2 rounded-lg bg-base-300 hover:bg-base-100" role="button" @click="redirectView(infos?.id)">-->
    <Link :href="route('raffles.raffleView', { id: infos?.id })"
        class="block p-2 rounded-lg bg-base-100 hover:bg-base-300">
    <div class="flex flex-row flex-wrap">
        <div class="w-full mb-1 sm:w-full md:w-full xl:w-1/12 lg:w-full sm:mb-1 md:mb-1 xl:mb-0 animate-fade-right">
            <div class="flex flex-row">
                <div class="w-full h-[8rem]">
                    <img :src="infos?.image" alt="Preview" class="object-cover w-full h-full rounded-lg">
                </div>
                <!-- <div class="grid w-2/12 sm:w-1/12 md:w-1/12 lg:w-1/12 sm:grid md:grid xl:hidden lg:grid">
                        <div class="flex flex-col">
                            <div class="flex justify-end w-full pb-1 h-3/6">
                                <button class="h-full p-0 px-2 py-2 text-white btn btn-info">
                                    <IconsSvg name="icon-edit" />
                                </button>
                            </div>
                            <div class="flex justify-end w-full pt-1 h-3/6">
                                <button type="button" class="h-full p-0 px-2 text-white btn btn-error">
                                    <IconsSvg name="icon-trash" />
                                </button>
                            </div>
                        </div>
                    </div> -->
            </div>
        </div>
        <div class="flex items-center w-full mb-2 sm:w-full md:w-full xl:px-4 xl:w-4/12 animate-fade-left">
            <div class="flex justify-start w-full h-auto mb-1 md:h-auto xl:h-auto">
                <p class="text-base font-bold text-neutral/70">{{ infos?.title }}</p>
            </div>
        </div>
        <!-- MOBILE -->
        <div class="flex w-full xl:hidden">
            <div class="flex flex-row w-full">
                <div class="flex items-center w-8/12">
                    <!-- <div class="border-4 radial-progress bg-primary text-content border-primary"
                            style="--size: 4rem;" :style="{'--value':func.calcPercent(infos?.paid, infos?.quantity)}" role="progressbar">{{ func.calcPercent(infos?.paid, infos?.quantity) }}%</div> -->
                    <div class=" xl:hidden flex-row flex-wrap items-center !w-full">
                        <div class="w-full">
                            <small class="text-neutral/70">Total Vendidos</small>
                        </div>
                        <div class="w-full">
                            <div class="flex flex-row">
                                <progress class="w-full h-4 progress progress-success"
                                    :value="func.calcPercent(infos?.paid, infos?.quantity)" max="100"></progress>
                                <small class="ml-2 text-neutral/70">{{ func.calcPercent(infos?.paid, infos?.quantity)
                                    }}%</small>
                            </div>
                        </div>
                        <div class="flex justify-center w-full">
                            <small class="text-neutral/70">
                                {{ infos?.paid + '/' + infos?.quantity }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="w-4/12">
                    <div class="flex flex-col flex-wrap">
                        <div class="flex justify-end w-full mb-1">
                            <div class="py-3 badge text-neutral/70"
                                :class="{ 'badge-success': infos?.status?.toLowerCase() == 'ativo', 'badge-error': infos?.status?.toLowerCase() != 'ativo' }">
                                {{ infos?.status }}
                            </div>
                        </div>
                        <div class="flex justify-end w-full mb-1">
                            <p class="text-base font-bold text-neutral/70">{{ func.translateMoney(infos?.price) }}</p>
                        </div>
                        <div class="flex justify-end w-full mb-1">
                            <p class="text-base font-bold text-neutral/70">{{ func.translateDate(infos?.created_at) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="flex items-center justify-end hidden w-full px-2 mb-4 animate-fade-right sm:hidden sm:justify-center sm:w-1/12 md:hidden md:justify-center md:w-1/12 xl:grid xl:justify-center xl:w-1/12">
            <div class="py-3 badge text-neutral/70"
                :class="{ 'badge-success': infos?.status?.toLowerCase() == 'ativo', 'badge-error': infos?.status?.toLowerCase() != 'ativo' }">
                {{ infos?.status }}
            </div>
        </div>
        <div class="flex items-center justify-end hidden w-full px-2 animate-fade-left sm:w-full md:justify-end md:w-full xl:justify-center xl:w-2/12 xl:grid">
            <p class="text-base font-bold text-neutral/70">{{ func.translateMoney(infos?.price) }}</p>
        </div>
        <div class="flex items-center justify-start hidden w-6/12 px-2 animate-fade-right md:justify-start md:w-full xl:justify-center xl:w-1/12 xl:grid">
            <div class="absolute border-4 text-primary-bw radial-progress bg-primary border-primary before:z-20" :class="func.calcPercent(infos?.paid, infos?.quantity) == 0 && 'before:hidden after:hidden'" style="--size: 5rem;"
                :style="{ '--value': func.calcPercent(infos?.paid, infos?.quantity)}" role="progressbar">{{
                func.calcPercent(infos?.paid, infos?.quantity) }}%</div>
            <div class="absolute z-10 ml-1 radial-progress text-gray/40 " style="--value:100; --size: 5rem;" role="progressbar"></div>
        </div>
        <div class="flex items-center justify-end hidden w-6/12 px-2 animate-fade-left sm:items-center md:items-center md:justify-end md:w-full xl:items-center xl:justify-center xl:w-2/12 xl:grid">
            <p class="text-base font-bold text-neutral/70">{{ func.translateDate(infos?.created_at) }}</p>
        </div>
        <div class="flex animate-shake animate-ease-linear animate-infinite animate-duration-[3000ms] items-center justify-end hidden w-6/12 px-2 xl:grid sm:items-center md:items-center md:justify-end md:w-full xl:items-center xl:justify-center xl:w-1/12">
            <IconsSvg name="icon-chevron-right" />
        </div>
    </div>
    </Link>
</template>
