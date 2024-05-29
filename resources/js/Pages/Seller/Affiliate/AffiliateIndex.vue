<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import {
    TicketIcon,
PlusCircleIcon,
PencilSquareIcon,
UserIcon,
PhoneIcon,
EnvelopeIcon,
DocumentTextIcon,
BanknotesIcon,
LinkIcon
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
    },
    methods: {
        redirectToEdit(id){
            window.location.href = route('affiliate.affiliateEdit', id);s
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
                        <div class="px-4 text-neutral/70 card-title">
                            Afiliados Cadastrados
                        </div>
                    </div>
                    <div class="flex justify-end w-full px-4 py-4 animate-fade-left">
                        <Link :href="route('affiliate.affiliateCreated')" class="text-black border-none btn btn-sm xl:btn-md lg:btn-md bg-primary">
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
                        <div class="flex flex-row flex-wrap p-2">
                            <div class="flex justify-center w-2/12 text-neutral/70">Nome</div>
                            <div class="flex justify-center w-2/12 text-neutral/70">Link</div>
                            <div class="flex justify-center w-1/12 text-neutral/70">Telefone</div>
                            <div class="flex justify-center w-2/12 text-neutral/70">Email</div>
                            <div class="flex justify-center w-1/12 text-neutral/70">Documento</div>
                            <div class="flex justify-center w-3/12 text-neutral/70">Chave Pix</div>
                            <div class="flex justify-center w-1/12 text-neutral/70"></div>
                        </div>
                    </div>
                    <div v-for="affiliate in data?.data"
                        @click="redirectToEdit(affiliate.id)"
                        :key="affiliate?.id"
                        role="button"
                        class="w-full mb-4 rounded-lg hover:bg-base-300 animate-fade-down bg-base-100">
                        <div class="flex flex-row flex-wrap">
                            <div class="flex items-center w-full py-2 sm:w-full xl:w-2/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <UserIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-2/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <LinkIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.link ?? '----'}}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-1/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                   <PhoneIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-2/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <EnvelopeIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-1/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <DocumentTextIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.document }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 md:w-3/12 xl:w-3/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <BanknotesIcon class="w-4 ml-3 mr-1 xl:hidden lg:hidden"/>
                                    <p class="text-base font-bold text-neutral/70">{{ affiliate?.pix_key }}</p>
                                </div>
                            </div>
                            <div class="flex items-center w-full py-2 xl:w-1/12 animate-fade-left">
                                <div class="flex items-center w-full h-auto mb-1 lg:justify-center xl:justify-center md:h-auto xl:h-auto">
                                    <button class="hidden lg:flex xl:flex btn btn-sm btn-info"><PencilSquareIcon class="w-4 text-white"/></button>
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
