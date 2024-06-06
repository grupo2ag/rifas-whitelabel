<script setup>
import Sidebar from '@/Components/Sidebar/Sidebar.vue';
import SidebarMobile from '@/Components/Sidebar/SidebarMobile.vue';
import Dropdown from '@/Components/Dropdown.vue';
import Navbar from '@/Components/Navbar/Navbar.vue';
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

const props = defineProps({
    user: Object
})

</script>
<script>
import { usePage } from "@inertiajs/inertia-vue3";
import { router } from '@inertiajs/vue3';
// import { notify } from "@kyvg/vue3-notification";

const logout = () => {
    router.post(route('logout'));
};

const myAccount = () => {
    window.location.href = "/user/profile"
}

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
        // console.log(this.$inertia.page.props)
        if (this.$inertia?.page?.props.flash?.type) {
            this.$swal({
                icon: this.$inertia.page.props.flash.type,
                title: this.$inertia.page.props.flash.message,
                toast: true,
                position: 'bottom-right',
                showConfirmButton: false,
                timer: 4500,
                timerProgressBar: true,
            });
            this.$inertia.page.props.flash.type = false;
        }
    },
    mounted() {
        // console.log(this.$inertia.page.props)
        if (this.$inertia?.page?.props?.flash?.type) {
            this.$swal({
                icon: this.$inertia.page.props.flash.type,
                title: this.$inertia.page.props.flash.message,
                toast: true,
                position: 'bottom-right',
                showConfirmButton: false,
                timer: 4500,
                timerProgressBar: true,
            });
            this.$inertia.page.props.flash.type = false;
        }
    }
}
</script>

<template>
    <div>
        <div class="min-h-screen pt-0 md:pt-0 bg-root">
            <Sidebar/>

            <SidebarMobile :user="user" class="md:hidden"/>

            <header class="px-2 md:pl-28 md:pr-8 hidden md:block">
                <div class="flex items-center justify-between pt-4 md:pt-6">
                    <div class="flex items-center justify-between w-full px-4 py-3 shadow-sm bg-primary rounded-xl">
                        <div class="hidden sm:block ">
                            <slot name="header" />
                        </div>
                        <Navbar class="sm:hidden md:hidden lg:hidden xl:hidden"></Navbar>
                        <div class="items-center md:flex">

                            <div class="relative flex items-center gap-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button type="button"
                                            class="flex items-center justify-center gap-2 text-sm font-bold leading-4 duration-200 rounded-full text-primary-bw hover:bg-bgadm-light">

                                            <img :src="user?.profile_photo_url" :alt="user?.name"
                                                class="object-cover w-10 h-10 rounded-full">

                                            {{ user?.name }}
                                            <ChevronDownIcon class="w-4 h-4 mr-1 stroke-black dark:stroke-white" />
                                        </button>
                                    </template>

                                    <template #content>
                                        <div class="flex flex-row">
                                            <div class="w-full p-2">
                                                <button @click="myAccount()">
                                                    <div class="flex flex-row">
                                                        <UserCircleIcon class="w-5 h-5 mr-2 stroke-primary" />
                                                        Minha Conta
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex flex-row">
                                            <div class="w-full p-2">
                                                <button @click="logout()">
                                                    <div class="flex flex-row">
                                                        <ArrowLeftStartOnRectangleIcon
                                                            class="w-5 h-5 mr-2 stroke-primary" />
                                                        Sair
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex justify-center my-4 md:mr-8 lg:mr-8 sm:mr-8 md:pl-28">
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
