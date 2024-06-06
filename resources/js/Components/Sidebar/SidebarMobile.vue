<script setup>
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink/NavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink/NavLink.vue';
import {
    Squares2X2Icon,
    ArrowTrendingUpIcon,
    ViewfinderCircleIcon,
    Square2StackIcon,
    ArrowLeftStartOnRectangleIcon,
    UserCircleIcon,
    DocumentTextIcon,
    VideoCameraIcon,
    NewspaperIcon,
    UserIcon,
    ChevronDownIcon,
    InboxStackIcon,
    ShieldExclamationIcon,
    CircleStackIcon,
    ShieldCheckIcon,
    UserGroupIcon,
    UsersIcon,
    CurrencyDollarIcon,
    TicketIcon
} from '@heroicons/vue/24/outline'

import { Link } from '@inertiajs/inertia-vue3';

import IconsSvg from "@/Components/IconsSvg/IconsSvg.vue";

const props = defineProps({
    typeuser: Object,
    user: Object
})

</script>

<script>
export default {
    data() {
        return {
            isActive: false,
            isActiveDropdown: false,
            config: {
                logo: '/images/logo.svg',
            }
        }
    },
    methods: {
        toggleHumburger() {
            this.isActive = !this.isActive;
        },
        toggleDropdown(element) {
            this.$refs[element].classList.toggle('active')
        },
    }
}
</script>

<template>
    <header class="w-full fixed top-0 left-0 bg-primary flex items-center py-3 z-[99] md:hidden">
        <div class="w-full px-5 flex items-center justify-between gap-4 ">
            <div class="w-3/12">
                <button type="button" class="o-hamburguer" v-bind:class="[isActive ? 'active' : '']"
                    @click="toggleHumburger">
                    <span></span>
                </button>
            </div>

            <div class="w-6/12 flex justify-center">
                <Link :href="route('dashboard')">
                    <IconsSvg name="logo-pay8" class="h-7 md:h-10 fill-white"/>
                </Link>
            </div>

            <div class="w-3/12 flex justify-end">
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button type="button"
                                class="flex items-center justify-center gap-2 text-sm font-bold leading-4 duration-200 rounded-full text-primary-bw hover:bg-bgadm-light">

                            <img :src="user?.profile_photo_url" :alt="user?.name"
                                 class="object-cover w-10 h-10 rounded-full">

                            <ChevronDownIcon class="w-4 h-4 mr-1 stroke-black dark:stroke-white" />
                        </button>
                    </template>

                    <template #content>
                        <div class="mx-2 py-1.5 px-1.5 flex items-center bg-root rounded-xl gap-2">
                            <img :src="user?.profile_photo_url" :alt="user?.name"
                                 class="object-cover w-8 h-8 rounded-full">

                            <span class="text-neutral">{{ user?.name }}</span>
                        </div>
                        <div class="flex flex-row">
                            <div class="w-full p-2">
                                <a href="profile">
                                    <div class="flex flex-row">
                                        <UserCircleIcon class="w-5 h-5 mr-2 stroke-primary" />
                                        Minha Conta
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <div class="w-full p-2">
                                <Link :href="route('logout')" method="post" as="button" class="w-full">
                                    <div class="flex flex-row">
                                        <ArrowLeftStartOnRectangleIcon
                                            class="w-5 h-5 mr-2 stroke-primary" />
                                        Sair
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>
    </header>

    <div class="c-backdrop" :class="isActive ? '' : 'hidden'"
        @click="toggleHumburger"></div>

    <nav class="mobile-sidebar bg-primary" :class="isActive ? 'active' : ''">
        <div class="flex-1 h-full flex justify-between flex-col overflow-auto">
            <div class="flex-1 flex flex-col ">
                <div class="flex flex-col" id="Admin">
                    <div class="border-b border-primary-bw/40">
                        <NavLink :href="route('dashboard')">
                            <Squares2X2Icon class="w-6 h-6 text-primary-bw" />
                            Dashboard
                        </NavLink>
                    </div>

                    <div class="border-b border-primary-bw/40">
                        <NavLink :href="route('raffles.raffleIndex')" :active="false" >
                            <TicketIcon class="w-6 h-6 text-primary-bw" />
                            Rifas
                        </NavLink>
                    </div>

                    <div class="border-b border-primary-bw/40">
                        <NavLink :href="route('paymentMethods')" :active="false">
                            <CurrencyDollarIcon class="w-6 h-6 text-primary-bw" />
                            Meios de Pagamento
                        </NavLink>
                    </div>

                    <div class="border-b border-primary-bw/40">
                        <NavLink :href="route('affiliate.affiliateIndex')" :active="false">
                            <UsersIcon class="w-6 h-6 text-primary-bw" />
                            Afiliados
                        </NavLink>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<style src="./style.scss" lang="scss" scoped/>

<style>
:root {
    --popper-theme-background-color: #333333;
    --popper-theme-background-color-hover: #333333;
    --popper-theme-text-color: #ffffff;
    --popper-theme-border-width: 0px;
    --popper-theme-border-style: solid;
    --popper-theme-border-radius: 5px;
    --popper-theme-padding: 8px;
}

.popper {
    white-space: nowrap;
}
</style>
