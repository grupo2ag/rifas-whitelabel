<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import {
    TicketIcon,
PlusCircleIcon
} from '@heroicons/vue/24/outline';
import IconsSvg from "@/Components/IconsSvg/IconsSvg.vue";
</script>

<script>
export default {
    name: "AffiliateIndex",
    props: {
        data: Object
    },
    data() {
        return {
            showModal: false
        }
    }
}
</script>

<template>

    <Head title="Afiliados"></Head>
    <AuthenticatedLayout :user="$page.props.auth.user">
        <template #header>
            <h2 class="flex items-center font-semibold text-content lg:text-xl">
                <TicketIcon class="w-5 h-5 mr-2 text-content lg:w-6 lg:h-6" />
                Afiliados
            </h2>
        </template>
        <div class="container sm:max-w-full !w-full">
            <div class="card bg-content animate-fade-up">
                <div class="flex flex-row">
                    <div class="flex justify-start w-full">
                        <div class="px-4 text-neutral card-title">
                            Afiliados Cadastrados
                        </div>
                    </div>
                    <div class="flex justify-end w-full px-4 py-4 animate-fade-left">
                        <Link :href="route('affiliate.affiliateCreated')" class="text-black border-none btn bg-primary">
                            <div class="flex flex-row items-center text-primary-bw">
                                <PlusCircleIcon class="w-6 mr-2 text-primary-bw"/>
                                Criar Afiliado
                            </div>
                        </Link>
                    </div>
                </div>
                <div v-if="!data || data?.length == 0" class="flex items-center justify-center w-full h-full py-40">
                    <span class="text-base text-xl font-medium title-font">Ainda não há afiliados</span>
                </div>
                <div v-else class="flex flex-row flex-wrap px-2 mb-4">
                    <div class="hidden w-full h-10 mb-4 rounded-lg bg-base-100 xl:grid">
                        <div class="flex flex-row p-2">
                            <div class="flex justify-start w-4/12 ml-4 text-primary-bw">Nome</div>
                            <div class="flex justify-start w-4/12 ml-4 text-primary-bw">Link</div>
                            <div class="flex justify-center w-1/12 text-primary-bw">Telefone</div>
                            <div class="flex justify-center w-2/12 text-primary-bw">Email</div>
                            <div class="flex justify-center w-1/12 text-primary-bw">Documento</div>
                            <div class="flex justify-center w-2/12 text-primary-bw">Chave Pix</div>
                            <div class="flex justify-center w-1/12 text-primary-bw"></div>
                        </div>
                    </div>
                    <div v-for="affiliate in data?.data" :key="affiliate?.id" class="w-full mb-4 animate-fade-down">
                        <div class="flex flex-row flex-wrap">
                            <div class="flex items-center w-full mb-2 sm:w-full md:w-full xl:px-4 xl:w-4/12 animate-fade-left">
                                <div class="flex justify-start w-full h-auto mb-1 md:h-auto xl:h-auto">
                                    <p class="text-base font-bold text-primary-bw">{{ affiliate?.name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full mb-2 sm:w-full md:w-full xl:px-4 xl:w-4/12 animate-fade-left">
                                <div class="flex justify-start w-full h-auto mb-1 md:h-auto xl:h-auto">
                                    <p class="text-base font-bold text-primary-bw">{{ affiliate?.link }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full mb-2 sm:w-full md:w-full xl:px-4 xl:w-4/12 animate-fade-left">
                                <div class="flex justify-start w-full h-auto mb-1 md:h-auto xl:h-auto">
                                    <p class="text-base font-bold text-primary-bw">{{ affiliate?.phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full mb-2 sm:w-full md:w-full xl:px-4 xl:w-4/12 animate-fade-left">
                                <div class="flex justify-start w-full h-auto mb-1 md:h-auto xl:h-auto">
                                    <p class="text-base font-bold text-primary-bw">{{ affiliate?.email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full mb-2 sm:w-full md:w-full xl:px-4 xl:w-4/12 animate-fade-left">
                                <div class="flex justify-start w-full h-auto mb-1 md:h-auto xl:h-auto">
                                    <p class="text-base font-bold text-primary-bw">{{ affiliate?.document }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full mb-2 sm:w-full md:w-full xl:px-4 xl:w-4/12 animate-fade-left">
                                <div class="flex justify-start w-full h-auto mb-1 md:h-auto xl:h-auto">
                                    <p class="text-base font-bold text-primary-bw">{{ affiliate?.pix_key }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row w-full px-2" :class='{ "hidden": data?.last_page == 1 }'>
                        <div class="flex justify-end w-full">
                            <Pagination :data="data" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
