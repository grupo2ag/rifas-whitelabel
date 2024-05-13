<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '../../../../Layouts/AuthenticatedLayout.vue';
import InputFile from '@/Components/Inputs/InputFile.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import {
    TicketIcon

} from '@heroicons/vue/24/outline'
</script>

<template>

    <Head title="Criar Campanhas"></Head>
    <AuthenticatedLayout :user="$page.props.auth.user">
        <template #header>
            <h2 class="flex items-center font-semibold text-white lg:text-xl">
                <TicketIcon class="w-5 h-5 mr-2 text-white lg:w-6 lg:h-6" />
                Criar Campanha
            </h2>
        </template>
        <div class="container">
            <div class="flex flex-row p-6 rounded-lg bg-content">
                <div class="flex flex-row flex-wrap w-full">
                    <div class="w-3/12 pr-2 sm:w-1/12">
                        <div class="flex flex-col">
                            <div
                                class="w-full sm:h-[6rem] h-[3rem] bg-white mb-2 rounded-lg flex items-center indicator">
                                <span class="py-3 indicator-item badge bg-primary">x</span>
                                <InputFile />
                            </div>
                            <div class="w-full sm:h-[6rem] h-[3rem] bg-white mb-2 rounded-lg flex items-center">
                                <InputFile />
                            </div>
                            <div class="w-full sm:h-[6rem] h-[3rem] bg-white mb-2 rounded-lg flex items-center">
                                <InputFile />
                            </div>
                            <div class="w-full sm:h-[6rem] h-[3rem] bg-white mb-2 rounded-lg flex items-center">
                                <InputFile />
                            </div>
                            <div class="w-full sm:h-[6rem] h-[3rem] bg-white mb-2 rounded-lg flex items-center">
                                <InputFile />
                            </div>
                        </div>
                    </div>
                    <div class="w-9/12 px-2 sm:w-5/12">
                        <div class="flex flex-col">
                            <div
                                class="w-full sm:h-[32rem] h-[17rem] bg-white rounded-lg flex justify-center items-center">
                                <InputFile />
                            </div>
                        </div>
                    </div>
                    <div class="w-full sm:w-6/12">
                        <div class="flex flex-row w-full ">
                            <div class="flex flex-wrap justify-start w-6/12 mx-2 mb-4 rounded-lg">
                                <InputLabel value="Título" />
                                <TextInput class="w-full" />
                            </div>
                            <div class="flex flex-wrap justify-start w-3/12 mx-2 mb-4 rounded-lg">
                                <InputLabel value="Valor" />
                                <TextInput class="w-full" />
                            </div>
                            <div class="flex flex-wrap justify-start w-3/12 mx-2 mb-4 rounded-lg">
                                <InputLabel value="Data do Sorteio" />
                                <TextInput class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-row w-full mb-4">
                            <div class="flex justify-center w-full h-20 mx-2 bg-white rounded-lg">Descrição</div>
                        </div>
                        <div class="flex flex-row flex-wrap justify-center w-full ">
                            <div class="flex justify-center w-3/12 h-10 mx-2 mb-4 bg-white rounded-lg">Numeros de 0 - 9
                            </div>
                            <div class="flex justify-center w-3/12 h-10 mx-2 mb-4 bg-white rounded-lg">Numeros de 0 - 99
                            </div>
                            <div class="flex justify-center w-3/12 h-10 mx-2 mb-4 bg-white rounded-lg">Numeros de 0 -
                                999</div>
                            <div class="flex justify-center w-3/12 h-10 mx-2 mb-4 bg-white rounded-lg">Numeros de 0 -
                                9999</div>
                            <div class="flex justify-center w-3/12 h-10 mx-2 mb-4 bg-white rounded-lg">Numeros de 0 -
                                99999
                            </div>
                            <div class="flex justify-center w-3/12 h-10 mx-2 mb-4 bg-white rounded-lg">Numeros de 0 -
                                999999
                            </div>
                        </div>
                        <div class="flex flex-row w-full mb-4">
                            <div class="flex justify-center w-4/12 h-10 mx-2 mb-4 bg-white rounded-lg">1 premio</div>
                            <div class="flex justify-center w-4/12 h-10 mx-2 mb-4 bg-white rounded-lg">2 premio</div>
                            <div class="flex justify-center w-4/12 h-10 mx-2 mb-4 bg-white rounded-lg">3 premio</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
