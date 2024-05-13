<script setup>
import IconsSvg from "@/Components/IconsSvg/IconsSvg.vue";
</script>

<script>
export default {
    methods: {
        redirectView() {
            window.location.href="/super/raffles/view"
        }
    }
}
</script>

<template>
    <div class="p-2 rounded-lg bg-base-300 hover:bg-base-100" role="button" @click="redirectView">
        <div class="flex flex-row flex-wrap">
            <div class="w-full mb-1 sm:w-full md:w-full xl:w-1/12 lg:w-full sm:mb-1 md:mb-1 xl:mb-0">
                <div class="flex flex-row">
                    <div class="w-10/12 sm:w-11/12 md:w-11/12 lg:w-11/12 h-[8rem]" >
                        <img src="https://mundoemrevista.com.br/wp-content/uploads/2024/01/trevo-de-quatro-folhas.webp"
                            alt="Preview" class="object-cover w-full h-full rounded-lg">
                    </div>
                    <div class="grid w-2/12 sm:w-1/12 md:w-1/12 lg:w-1/12 sm:grid md:grid xl:hidden lg:grid">
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
                    </div>
                </div>
            </div>
            <div class="flex items-center w-full mb-2 sm:w-full md:w-full xl:px-4 xl:w-4/12" >
                <div class="flex justify-start w-full h-auto mb-1 md:h-auto xl:h-auto">
                    <p class="text-base font-bold">Nome Rifa Nome Nome nome</p>
                </div>
            </div>
            <!-- MOBILE -->
            <div class="flex w-full xl:hidden" >
                <div class="flex flex-row w-full">
                    <div class="flex items-center w-8/12">
                        <div class="border-4 radial-progress bg-primary text-content border-primary"
                            style="--value:70; --size: 4rem;" role="progressbar">70%</div>
                    </div>
                    <div class="w-4/12">
                        <div class="flex flex-col flex-wrap">
                            <div class="flex justify-end w-full mb-1">
                                <div class="py-3 badge badge-success">
                                    Ativo
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-1">
                                <p class="text-base font-bold">R$ 4,00</p>
                            </div>
                            <div class="flex justify-end w-full mb-1">
                                <p class="text-base font-bold">12/02/2024</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div
                class="flex items-center justify-end hidden w-full px-2 mb-4 sm:hidden sm:justify-center sm:w-1/12 md:hidden md:justify-center md:w-1/12 xl:grid xl:justify-center xl:w-1/12">
                <div class="py-3 badge badge-success">
                    Ativo
                </div>
            </div>
            <div
                class="flex items-center justify-end hidden w-full px-2 sm:w-full md:justify-end md:w-full xl:justify-center xl:w-2/12 xl:grid">
                <p class="text-base font-bold">R$ 4,00</p>
            </div>
            <div
                class="flex items-center justify-start hidden w-6/12 px-2 md:justify-start md:w-full xl:justify-center xl:w-1/12 xl:grid">
                <div class="border-4 radial-progress bg-primary text-content border-primary"
                    style="--value:70; --size: 5rem;" role="progressbar">70%</div>
            </div>
            <div
                class="flex items-center justify-end hidden w-6/12 px-2 sm:items-center md:items-center md:justify-end md:w-full xl:items-center xl:justify-center xl:w-2/12 xl:grid">
                <p class="text-base font-bold">12/02/2024</p>
            </div>
            <div
                class="flex items-center justify-end hidden w-6/12 px-2 xl:grid sm:items-center md:items-center md:justify-end md:w-full xl:items-center xl:justify-center xl:w-1/12">
                <IconsSvg name="icon-chevron-right"/>
            </div>
        </div>

    </div>
</template>
