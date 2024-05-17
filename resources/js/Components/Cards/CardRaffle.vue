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
    // methods: {

    // },
    mounted() {
        console.log(this.data)
    }
}
</script>

<template>

    <div class="card bg-[#dedede]">
        <div class="flex flex-row mb-2">
            <div class="w-full">
                <!-- adicionar imagem dinamica -->
                <!-- <figure> -->
                    <img src="https://mundoemrevista.com.br/wp-content/uploads/2024/01/trevo-de-quatro-folhas.webp" alt="" />
                <!-- </figure> -->
            </div>
        </div>
        <div class="flex flex-row flex-wrap px-2 h-30">
            <div class="w-full mb-2">
                <div class="text-primary card-title">{{ data?.title }}</div>
            </div>
            <div class="flex w-full ">
                <div class="flex flex-row w-full">
                    <div class="flex items-center w-8/12">
                        <div class="border-4 radial-progress bg-primary text-content border-primary"
                            style="--size: 4rem;" :style="{ '--value': func.calcPercent(data?.paid, data?.quantity) }"
                            role="progressbar">{{ func.calcPercent(data?.paid, data?.quantity) }}%</div>
                    </div>
                    <div class="w-4/12">
                        <div class="flex flex-col flex-wrap">
                            <div class="flex justify-end w-full mb-1">
                                <div class="py-3 badge"
                                    :class="{ 'badge-success': data?.status?.toLowerCase() == 'ativo', 'badge-error': data?.status?.toLowerCase() != 'ativo' }">
                                    {{ data?.status }}
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-1">
                                <p class="text-base font-bold">{{ func.translateMoney(data?.price) }}</p>
                            </div>
                            <div class="flex justify-end w-full mb-1">
                                <p class="text-base font-bold">{{ func.translateDate(data?.created_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="flex flex-row flex-wrap items-end mb-4">
            <div class="justify-start w-6/12 px-3">
                <div class="border-4 radial-progress bg-primary text-content border-primary"
                            style="--size: 4rem;" :style="{'--value':func.calcPercent(data?.paid, data?.quantity)}" role="progressbar">{{ func.calcPercent(data?.paid, data?.quantity) }}%</div>
            </div>
            <div class="justify-end w-6/12 px-3 card-actions">
                <button class="text-white btn btn-xs btn-primary">+ Detalhes</button>
            </div>
        </div> -->
    </div>

</template>
