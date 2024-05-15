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
TableCellsIcon
} from '@heroicons/vue/24/outline';
import moment from 'moment';
</script>

<script>
import { object } from 'yup';
export default {
    name: "RaffleLayout",
    props: {
        openTab: Number,
        data: Object
    },
    methods: {
        setToggleTabs(tabNumber) {
            this.$emit('toggleTabs', tabNumber)
        },
        translateDate(data) {
            return moment(data).format('DD/MM/YYYY');
        },
        translateMoney(value) {
            return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }
    }
}
</script>

<template>
    <div class="flex flex-row">
        <div class="w-3/12">
            <div role="tablist" class="tabs tabs-lifted">
                <a role="tab" @click="setToggleTabs(1)" class="border-none tab"
                    v-bind:class="{ 'tab-active bg-primary text-primary-bw': openTab === 1, 'tab': openTab !== 1 }">Detalhes</a>
                <a role="tab" @click="setToggleTabs(2)" class="border-none tab"
                    v-bind:class="{ 'tab-active bg-primary text-primary-bw': openTab === 2, 'tab': openTab !== 2 }">Vendas</a>
            </div>
        </div>
    </div>
    <div class="flex flex-row flex-wrap p-4 rounded-lg bg-base-300 animate-fade ">
        <div class="w-full p-2 mb-4 rounded-lg bg-base-200">
            <div class="flex flex-row flex-wrap">
                <div class="w-4/12 lg:w-2/12 lg:h-[10rem]">
                    <img :src="data?.image?.path"
                        alt="Preview" class="object-cover w-full h-full rounded-lg">
                </div>
                <div class="flex w-8/12 lg:w-4/12">
                    <div class="flex flex-row flex-wrap px-2">
                        <div class="w-full mb-2">
                            <div class="flex flex-row">
                                <TicketIcon class="hidden w-6 mr-2 lg:grid text-primary " />
                                <p class="text-base text-xl font-bold">{{ data?.title }}</p>
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex flex-row">
                                <ChartBarIcon class="w-6 mr-2 min-w-6 text-primary" />
                                <div class="py-3 badge"
                                :class="{ 'badge-success': data?.status.toLowerCase() == 'ativo', 'badge-error': data?.status.toLowerCase() != 'ativo' }">
                                    {{ data?.status }}
                                </div>
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex flex-row">
                                <CalendarDaysIcon class="w-6 mr-2 min-w-6 text-primary" />
                                <p>{{ translateDate(data?.created_at) }}</p>
                            </div>
                        </div>
                        <div class="grid w-full mb-2 lg:hidden">
                            <div class="flex flex-row">
                                <BanknotesIcon class="w-6 mr-2 text-primary" />
                                <p>{{translateMoney(data?.price)}}/Cota</p>
                            </div>
                        </div>
                        <div class="grid w-full mb-2 lg:hidden ">
                            <div class="flex flex-row">
                                <ReceiptPercentIcon class="w-6 mr-2 text-primary" />
                                <p>{{data?.paid}}/{{data?.quantity}}</p>
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex flex-row ">
                                <LinkIcon class="hidden w-6 mr-2 lg:grid text-primary" />
                                <p class="break-all link link-primary">{{ data?.link }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex hidden w-4/12 mb-2 lg:grid">
                    <div class="flex flex-row flex-wrap px-2">
                        <div class="w-full ">
                            <div class="flex flex-row">
                                <BanknotesIcon class="w-6 mr-2 text-primary" />
                                <p>{{translateMoney(data?.price)}}/Cota</p>
                            </div>
                        </div>
                        <div class="w-full ">
                            <div class="flex flex-row">
                                <ReceiptPercentIcon class="w-6 mr-2 text-primary" />
                                <p>{{data?.paid}}/{{data?.quantity}}</p>
                            </div>
                        </div>
                        <div class="w-full ">
                            <div class="flex flex-row">
                                <TableCellsIcon class="w-6 mr-2 text-primary"/>
                                <p>{{ data?.type == 'automatico' ? 'Automático':'Manual' }}</p>
                            </div>
                        </div>
                        <div class="w-full ">
                            <div class="flex flex-row">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center w-full mt-2 lg:w-2/12">
                    <div class="flex flex-row flex-wrap w-full">
                        <div class="flex w-full mb-2">
                            <button class="text-white btn btn-info btn-block btn-sm lg:btn-md">
                                <PencilSquareIcon class="w-6" /> Editar
                            </button>
                        </div>
                        <div class="flex w-full mb-2">
                            <button class="text-white btn btn-error btn-block btn-sm lg:btn-md">
                                <TrashIcon class="w-6" /> Excluir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row w-full mb-4">
            <div class="w-full p-2 rounded-lg bg-base-100">
                <div class="flex flex-row mb-2">
                    <DocumentTextIcon class="w-6 mr-2 text-primary" />
                    <h2 class="text-base text-xl font-medium title-font">Descrição</h2>
                </div>
                <p class="mx-2">{{ data?.description }}</p>
            </div>
        </div>
        <div class="w-full">
            <slot name="body" />
        </div>
    </div>
</template>
