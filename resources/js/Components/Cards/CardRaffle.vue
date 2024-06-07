<script setup>
import moment from 'moment';
import * as func from '@/Helpers/functions';
defineProps({
    data: Object
});
</script>

<script>
export default {
    name: "CardRaffle",
    methods: {
        redirect() {
            window.location.href = `/raffles/view/${this.data?.id}`
        }
    }
}
</script>

<template>
    <!-- <Link :href="route('raffles.raffleView', { id: data?.id })"> -->
    <div class="card bg-base-100 hover:bg-base-200 overflow-hidden" role="button" @click="redirect()">
        <div class="flex flex-row mb-2">
            <div class="w-full">
                <!-- adicionar imagem dinamica -->
                <!-- <figure> -->
                <img :src="data.gallery.img" class="aspect-square w-full"
                    alt="" />
                <!-- </figure> -->
            </div>
        </div>
        <div class="flex flex-row flex-wrap px-3 mb-4 h-30">
            <div class="w-full mb-2">
                <div class="sm:hidden text-neutral/70 card-title">{{ func.truncateString(data?.title, 18) }}</div>
                <div class="hidden sm:grid text-neutral/70 card-title">{{ func.truncateString(data?.title, 50) }}</div>
            </div>
            <div class="flex w-full ">
                <div class="flex flex-row w-full">
                    <div class="flex items-center w-8/12">
                        <div class="absolute border-4 sm:hidden radial-progress bg-primary text-primary-bw border-primary before:z-20"
                            :class="func.calcPercent(data?.paid, data?.quantity) == 0 && 'before:hidden after:hidden'"
                            style="--size: 4rem;" :style="{ '--value': func.calcPercent(data?.paid, data?.quantity) }"
                            role="progressbar">{{func.calcPercent(data?.paid, data?.quantity) }}%</div>
                        <div class="absolute z-10 ml-1 sm:hidden radial-progress text-gray/40 " style="--value:100; --size: 4rem;"
                            role="progressbar"></div>
                        <div class="hidden sm:flex flex-row flex-wrap items-center !w-full">
                            <div class="w-full">
                                <small class="text-base text-neutral/70">Total Vendidos</small>
                            </div>
                            <div class="w-full">
                                <div class="flex flex-row">
                                    <progress class="w-full h-6 progress progress-success"
                                        :value="func.calcPercent(data?.paid, data?.quantity)" max="100"></progress>
                                    <small class="ml-2 text-base text-neutral/70">{{ func.calcPercent(data?.paid, data?.quantity)
                                        }}%</small>
                                </div>
                            </div>
                            <div class="flex justify-center w-full">
                                <small class="text-base text-neutral/70">
                                    {{ data?.paid + '/' + data?.quantity }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="w-4/12">
                        <div class="flex flex-col flex-wrap">
                            <div class="flex justify-end w-full mb-1">
                                <div class="py-3 badge text-primary-bw"
                                    :class="{ 'badge-success': data?.status?.toLowerCase() == 'ativo', 'badge-error': data?.status?.toLowerCase() != 'ativo' }">
                                    {{ data?.status }}
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-1">
                                <p class="text-base font-bold text-neutral/70">{{ func.translateMoney(data?.price) }}</p>
                            </div>
                            <div class="flex justify-end w-full mb-1">
                                <p class="text-base font-bold text-neutral/70">{{ func.translateDate(data?.created_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="flex flex-row justify-center mb-4">
            <div class="flex w-5/12">
                <button class="border-none btn btn-block bg-primary text-primary-bw btn-sm">+ Detalhes</button>
            </div>
        </div> -->
    </div>
    <!-- </Link> -->

</template>
