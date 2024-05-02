<script setup>
import Sidebar from '@/Components/Sidebar/Sidebar.vue';
import Dropdown from '@/Components/Dropdown.vue';
// import DropdownLink from '@/Components/DropdownLink.vue';
// import {
//     PhUserCircle,
//     PhSignOut
// } from "@phosphor-icons/vue";
import {
    ChevronDownIcon,
    UserCircleIcon,
    ArrowLeftStartOnRectangleIcon
} from '@heroicons/vue/24/outline'
</script>
<script>
import { usePage } from "@inertiajs/inertia-vue3";
// import { notify } from "@kyvg/vue3-notification";

export default {
    data() {
        return {
            isActive: true,
        }
    },
    methods: {
        toggleHumburger() {
            this.isActive = !this.isActive;
        },
    },
    updated() {
        if (usePage()?.props?.value?.flash?.type) {
            notify({
                title: usePage().props.value.flash.type == 'success' ? 'Sucesso' : 'Erro',
                text: usePage().props.value.flash.message,
                type: usePage().props.value.flash.type,
                duration: 10000,
            });
            usePage().props.value.flash.type = false;
        }
    },
    mounted() {
        if (usePage()?.props?.value?.flash?.type) {
            notify({
                title: usePage().props.value.flash.type == 'success' ? 'Sucesso' : 'Erro',
                text: usePage().props.value.flash.message,
                type: usePage().props.value.flash.type,
                duration: 10000,
            });
            usePage().props.value.flash.type = false;
        }
    }
}
</script>


<template>
    <div>
        <div class="min-h-screen pt-[60px] md:pt-0">
            <Sidebar></Sidebar>

            <header class="md:pl-28 md:pr-8">
                <div class=" flex items-center justify-between pt-[4.4rem] md:pt-6">
                    <div class="flex items-center justify-between w-full px-4 py-3 shadow-sm bg-primary rounded-xl">
                        <slot name="header" />

                        <div class="items-center md:flex">

                            <div class="relative flex items-center gap-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button type="button"
                                            class="flex items-center justify-center gap-2 text-sm font-bold leading-4 text-white duration-200 rounded-full hover:bg-bgadm-light">
                                            <img class="w-10 h-10 rounded-full"
                                                :src="'/images/banner-1.webp'"
                                                alt="" />
                                            Nome
                                            <ChevronDownIcon class="w-4 h-4 mr-1 stroke-black dark:stroke-white" />
                                        </button>
                                    </template>

                                    <template #content>
                                        <!-- <div v-if="$page?.props?.auth?.is_admin">
                                             <DropdownLink as="button">
                                                <UserCircleIcon class="w-5 h-5 mr-2 stroke-white" />
                                                Minha Conta
                                            </DropdownLink>

                                            <DropdownLink  method="post" as="button">
                                                <ArrowLeftStartOnRectangleIcon class="w-5 h-5 mr-2 stroke-white" />
                                                Sair
                                            </DropdownLink>
                                        </div> -->

                                        <div >
                                            <DropdownLink  as="button">
                                                <UserCircleIcon class="w-5 h-5 mr-2 stroke-white" />
                                                Minha Conta
                                            </DropdownLink>

                                            <DropdownLink method="post" as="button">
                                                <ArrowLeftStartOnRectangleIcon class="w-5 h-5 mr-2 stroke-white" />
                                                Sair
                                            </DropdownLink>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="my-4 mr-8 md:pl-28">
                <slot />
            </main>
        </div>
    </div>

    <notifications position='bottom right' classes="vue-notification" />
</template>

<style lang="scss">
.vue-notification {
    margin: 0 15px 15px;
    border-radius: 10px;
    padding: 10px;
    color: #ffffff;

    .notification-title {
        font-size: 16px;
        font-weight: 700;
    }

    .notification-content {
        font-size: 14px;
        line-height: normal;
        font-weight: 500;
    }

    &.success {
        background: #1ED561;
        border-left-color: #00a233;
    }

    &.warn {
        background: #ffb648;
        border-left-color: #f48a06;
    }

    &.error {
        background: #e54d42;
        border-left-color: #b82e24;
    }
}
</style>
