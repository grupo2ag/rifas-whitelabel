<script setup>
import {
    TicketIcon,
    DocumentIcon,
    LinkIcon,
    CalendarDaysIcon,
    ChartBarIcon,
    TrashIcon,
    PencilSquareIcon,
    BanknotesIcon,
    ReceiptPercentIcon,
    DocumentTextIcon,
    FlagIcon,
    TableCellsIcon,
    EyeSlashIcon,
    EyeIcon,
    MagnifyingGlassCircleIcon,
    ArrowUpOnSquareIcon,
    PowerIcon
} from '@heroicons/vue/24/outline';
import moment from 'moment';
import * as func from '@/Helpers/functions';
</script>

<script>
import { object } from 'yup';
export default {
    name: "RaffleLayout",
    props: {
        openTab: Number,
        data: Object
    },
    data() {
        return {
            visible: this.data?.visible
        }
    },
    methods: {
        setToggleTabs(tabNumber) {
            this.$emit('toggleTabs', tabNumber)
        },
        onExclude(status) {
            this.$swal({
                title: `Deseja realmente ${status == 'Ativo' ? 'reativar' : 'encerrar' } a rifa #${this?.data?.title}?`,
                text: `${status == 'Ativo' ? 'A rifa estará novamente ativa!' : 'A rifa será encerrada!'}`,
                confirmButtonText: `${status == 'Ativo' ? 'Reativar' : 'Encerrar'}`,
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                icon: 'question',
                type: 'question',
                allowOutsideClick: true,
                customClass: {
                    confirmButton: `sw-btn ${status == 'Ativo' ? 'sw-btn--blue' : 'sw-btn--red'}`,
                    cancelButton: `sw-btn ${status == 'Ativo' ? 'sw-btn--red' : 'sw-btn--blue'}`,
                    popup: 'sw-popup',
                    title: 'sw-title',
                }
            }).then((res) => {
                if (res?.isConfirmed) {
                    axios.post(route('raffles.raffleUpdated', this.data?.id), {status: status})
                        .then(response => {
                            this.$swal(
                                'Pronto!',
                                `A Rifa #${this.data?.title} foi ${status == 'Ativo' ? 'reativada' : 'encerrada'} com sucesso!`,
                                'success'
                            )
                            this.data.status = (status == 'Finalizado' ? 'Finalizado' : 'Ativo');
                        })
                        .catch(error => {
                            this.$swal(
                                'Ops!',
                                `Ocorreu um erro ao ${status == 'Ativo' ? 'reativar' : 'encerrar'} a Rifa #${this.data?.title}`,
                                'error'
                            )
                            console.error(error?.response);
                        });
                }
            })
        },
        visibleOrInvisibleRaffle(visible) {
            this.$swal({
                title: `Deseja realmente deixar a rifa #${this?.data?.title} ${visible == 0 ? 'não visível' : 'visível'}?`,
                text: `Caso confirme, a rifa ficará ${visible == 0  ? 'não visível' : 'visível'}`,
                confirmButtonText: "Sim",
                showCancelButton: true,
                cancelButtonText: "Não",
                icon: 'question',
                type: 'question',
                allowOutsideClick: true,
                customClass: {
                    confirmButton: `sw-btn sw-btn--blue`,
                    cancelButton: `sw-btn sw-btn--red`,
                    popup: 'sw-popup',
                    title: 'sw-title',
                }
            }).then((res) => {
                if (res?.isConfirmed) {
                    axios.post(route('raffles.raffleUpdated', this.data?.id), {visible: visible})
                        .then(response => {
                            this.$swal(
                                'Pronto!',
                                `A Rifa #${this.data?.title} está ${visible == 0 ? 'não visível' : 'visível'}!`,
                                'success'
                            )
                            this.visible = (visible == 0 ? 0 : 1);
                        })
                        .catch(error => {
                            this.$swal(
                                'Ops!',
                                `Ocorreu um erro ao deixar a Rifa #${this.data?.title} ${visible == 0 ? 'não visível' : 'visível'}`,
                                'error'
                            )
                            console.error(error?.response);
                        });
                }
            })
        }
    },
    /*mounted() {
        console.log(this.data);
        var n = this.data.numbers.split(',');
        console.log(n.length, n)
    }*/
}
</script>

<template>
    <div class="flex flex-row">
        <div class="w-3/12">
            <div role="tablist" class="tabs tabs-lifted">
                <a role="tab" @click="setToggleTabs(1)" class="ml-2 border-none tab before:hidden border-gray-light"
                    v-bind:class="{ 'tab-active bg-primary text-primary-bw': openTab === 1, 'tab text-neutral/70 bg-base-100': openTab !== 1 }">Detalhes</a>
                <a role="tab" @click="setToggleTabs(2)" class="ml-2 border-none border-gray-light tab before:hidden"
                    v-bind:class="{ 'tab-active bg-primary text-primary-bw': openTab === 2, 'tab text-neutral/70 bg-base-100': openTab !== 2 }">Vendas</a>
                <a v-if="this.data.type == 'manual'" role="tab" @click="setToggleTabs(3)"
                    class="ml-2 border-none border-gray-light tab before:hidden"
                    v-bind:class="{ 'tab-active bg-primary text-primary-bw': openTab === 3, 'tab text-neutral/70 bg-base-100': openTab !== 3 }">Reservas</a>
                <a role="tab" @click="setToggleTabs(4)" class="ml-2 border-none border-gray-light tab before:hidden"
                    v-bind:class="{ 'tab-active bg-primary text-primary-bw': openTab === 4, 'tab text-neutral/70 bg-base-100': openTab !== 4 }">Afiliado</a>
            </div>
        </div>
    </div>
    <div class="flex flex-row flex-wrap p-4 rounded-lg bg-base-300 animate-fade ">
        <div class="w-full p-2 mb-4 rounded-lg bg-base-200">
            <div class="flex flex-row flex-wrap">
                <div class="w-4/12 lg:w-2/12 lg:h-[10rem] animate-fade-right">
                    <img :src="data?.image" alt="Preview" class="object-cover w-full h-full rounded-lg">
                </div>
                <div class="flex w-8/12 lg:w-4/12 animate-fade-left">
                    <div class="flex flex-row flex-wrap px-2">
                        <div class="w-full mb-2">
                            <div class="flex flex-row">
                                <TicketIcon class="hidden w-6 mr-2 lg:grid text-neutral/70 " />
                                <p class="text-xl font-bold text-neutral/70">{{ data?.title }}</p>
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex flex-row">
                                <ChartBarIcon class="w-6 mr-2 min-w-6 text-neutral/70" />
                                <div class="py-3 badge text-neutral/70"
                                    :class="{ 'badge-success': data?.status.toLowerCase() == 'ativo', 'badge-error': data?.status.toLowerCase() != 'ativo' }">
                                    {{ data?.status }}
                                </div>
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex flex-row">
                                <CalendarDaysIcon class="w-6 mr-2 min-w-6 text-neutral/70" />
                                <p class="text-neutral/70">{{ func.translateDate(data?.created_at) }}</p>
                            </div>
                        </div>
                        <div class="grid w-full mb-2 lg:hidden">
                            <div class="flex flex-row">
                                <BanknotesIcon class="w-6 mr-2 text-neutral/70" />
                                <p class="text-neutral/70">{{ func.translateMoney(data?.price) }}/Cota</p>
                            </div>
                        </div>
                        <div class="grid w-full mb-2 lg:hidden ">
                            <div class="flex flex-row">
                                <ReceiptPercentIcon class="w-6 mr-2 text-neutral/70" />
                                <p class="text-neutral/70">{{ data?.paid }}/{{ data?.quantity }}</p>
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex flex-row ">
                                <LinkIcon class="hidden w-6 mr-2 lg:grid text-neutral/70" />
                                <a target="_blank" class="break-all link link-info"
                                    :href="!data?.visible ? route('raffle', 'visualizar|raffle-' + data?.link) : route('raffle', data?.link)">{{
                        data?.link }}</a>
                            </div>
                        </div>
                        <!-- <div class="w-full mb-2">
                            <div class="flex flex-row ">
                                <LinkIcon class="hidden w-6 mr-2 lg:grid text-neutral/70" />
                                <a target="_blank" class="break-all link link-info"
                                   :href="route('raffles.raffleLive',data?.id )">Numeros Disponiveis</a>
                            </div>
                        </div> -->
                        <!-- <div class="w-full mb-2">
                            <div class="flex flex-row ">
                                <button class="btn btn-sm btn-accent text-neutral" @click="setToggleTabs(5)">
                                    <MagnifyingGlassCircleIcon class="hidden w-6 lg:grid text-neutral" />
                                    Consultar Números
                                </button>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="flex hidden w-4/12 mb-2 lg:grid animate-fade-right">
                    <div class="flex flex-row flex-wrap px-2">
                        <div class="flex items-center w-full">
                            <div class="flex flex-row">
                                <BanknotesIcon class="w-6 mr-2 text-neutral/70" />
                                <p class="text-neutral/70">{{ func.translateMoney(data?.price) }}/Cota</p>
                            </div>
                        </div>
                        <div class="flex items-center w-full">
                            <div class="flex flex-row items-center">
                                <ReceiptPercentIcon class="w-6 mr-2 text-neutral/70" />
                                <p class="text-neutral/70">{{ data?.paid }}/{{ data?.quantity }}</p>
                            </div>
                        </div>
                        <div class="flex items-center w-full">
                            <div class="flex flex-row items-center">
                                <TableCellsIcon class="w-6 mr-2 text-neutral/70" />
                                <p class="text-neutral/70">{{ data?.type == 'automatico' ? 'Automático' : 'Manual' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center w-full">
                            <div role="button" class="flex flex-row items-center" @click="visibleOrInvisibleRaffle(visible == 0 ? '1' : '0')">
                                <div class="flex flex-row items-center" v-if="visible == 0">
                                    <EyeSlashIcon class="w-6 mr-2 text-neutral/70" />
                                    <p class="text-neutral/70">Não Visível</p>
                                </div>
                                <div class="flex flex-row items-center" v-else>
                                    <EyeIcon class="w-6 mr-2 text-neutral/70" />
                                    <p class="text-neutral/70">Visível</p>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="w-full mb-2">
                            <div class="flex flex-row ">
                                <LinkIcon class="hidden w-6 mr-2 lg:grid text-neutral/70" />
                                <a target="_blank" class="break-all link link-info"
                                    :href="route('raffles.raffleExport', data?.id)">Exportar participantes</a>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="flex flex-wrap justify-center w-full mt-2 lg:w-2/12 animate-fade-left">
                    <div class="flex flex-row-reverse flex-wrap w-full">
                        <div v-if="data?.status.toLowerCase() == 'ativo'" class="flex w-3/12 px-1 mb-2 tooltip"
                            data-tip="Encerrar Rifa">
                            <button @click="onExclude(data?.status.toLowerCase() == 'ativo' ? 'Finalizado' : 'Ativo')"
                                class="text-white border-none btn bg-content btn-block btn-sm lg:btn-md hover:bg-base-300">
                                <FlagIcon class="w-5 lg:w-6 text-neutral" />
                                <!-- Encerrar -->
                            </button>
                        </div>
                        <div v-else class="flex w-3/12 px-1 mb-2 tooltip"
                            data-tip="Reativar Rifa">
                            <button @click="onExclude(data?.status.toLowerCase() == 'ativo' ? 'Finalizado' : 'Ativo')"
                                class="text-white border-none btn bg-content btn-block btn-sm lg:btn-md hover:bg-base-300">
                                <PowerIcon class="w-5 lg:w-6 text-neutral" />
                                <!-- Reativar -->
                            </button>
                        </div>
                        <div class="flex justify-start w-3/12 px-1 tooltip" data-tip="Exportar Participantes">
                            <button
                                class="border-none bg-content btn btn-sm lg:btn-md btn-block text-neutral hover:bg-base-300"
                                @click="setToggleTabs(5)">
                                <a target="_blank" :href="route('raffles.raffleExport', data?.id)">
                                    <ArrowUpOnSquareIcon class="w-5 lg:w-6 text-neutral" />
                                    <!-- Exportar participantes -->
                                </a>
                            </button>
                        </div>
                        <div class="flex justify-start w-3/12 px-1 tooltip" data-tip="Buscar Números">
                            <button
                                class="border-none bg-content btn btn-sm lg:btn-md btn-block text-neutral hover:bg-base-300"
                                @click="setToggleTabs(5)">
                                <MagnifyingGlassCircleIcon class="w-5 lg:w-6 text-neutral" />
                                <!-- <span class="hidden lg:flex">Consultar Números</span> -->
                            </button>
                        </div>
                        <div v-if="data?.status.toLowerCase() == 'ativo'"
                            class="flex justify-end w-3/12 px-1 mb-2 tooltip" data-tip="Editar">
                            <button class="border-none bg-content btn btn-block btn-sm lg:btn-md hover:bg-base-300">
                                <a :href="route('raffles.raffleEdit', data.id)" class="flex flex-row items-center">
                                    <PencilSquareIcon class="w-5 lg:w-6 text-neutral" />
                                    <!-- <span class="hidden lg:flex">Editar</span> -->
                                </a>
                            </button>
                        </div>
                    </div>
                    <!-- <div class="flex flex-row flex-wrap w-full px-1">
                        <div v-if="data?.status.toLowerCase() == 'ativo'" class="flex w-full mb-2">
                            <button @click="onExclude()" class="text-white btn bg-content btn-block btn-sm lg:btn-md">
                                <FlagIcon class="w-6" />
                                Encerrar
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- <div class="flex flex-row w-full mb-4">
            <div class="w-full p-2 rounded-lg bg-base-100">
                <div class="flex flex-row mb-2">
                    <DocumentTextIcon class="w-6 mr-2 text-primary" />
                    <h2 class="text-base text-xl font-medium title-font">Descrição</h2>
                </div>
                <p class="mx-2" v-html="data?.description"></p>
            </div>
        </div> -->
        <div class="w-full">
            <slot name="body" />
        </div>
    </div>
</template>
