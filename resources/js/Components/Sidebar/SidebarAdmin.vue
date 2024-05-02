<script setup>
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Popper from "vue3-popper";

// import {
//     PhStorefront,
//     PhUsers,
//     PhBank,
//     PhSquaresFour,
//     PhPercent,
//     PhStack
// } from "@phosphor-icons/vue";
import IconsSvg from "@/Components/IconsSvg/IconsSvg.vue";
</script>

<script>
export default {
    name: 'SidebarOffice',
    data() {
        return {
            isOpen: false,
        }
    },
    methods: {
        onOver(element) {

            this.$refs[element].style.display = 'block';
        },
        onLeave(element) {
            this.$refs[element].style.display = 'none';
        }
    },
};
</script>

<template>
    <div class="flex flex-col">
        <Link  class="flex items-center justify-center mx-auto mb-1 rounded-lg">
        <IconsSvg name="logo-rifa8" class="w-4 h-4 md:w-7 md:h-7 fill-primary" />
        </Link>

        <div class="mb-1">
            <Popper content="Dashboard" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink  :active="route().current('')">
                    <!-- <PhSquaresFour weight="duotone" class="h-7 w-7 fill-white-light" /> -->
                </NavLink>
            </Popper>
        </div>

        <div class="mb-1">
            <Popper content="Empresa" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink >
                    <!-- <PhStorefront weight="duotone" class="h-7 w-7 fill-white-light" /> -->
                </NavLink>
            </Popper>
        </div>

        <div class="mb-1">
            <Popper content="Clientes" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink >
                    <!-- <PhUsers weight="duotone" class="h-7 w-7 fill-white-light" /> -->
                </NavLink>
            </Popper>
        </div>

        <div class="mb-1">
            <Popper content="Saques" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink >
                    <!-- <PhBank weight="duotone" class="h-7 w-7 fill-white-light" /> -->
                </NavLink>
            </Popper>
        </div>

        <div class="mb-1">
            <Popper content="Plano de Taxas" arrow placement="right" hover openDelay="0" closeDelay="0"
                offset-distance="10" offset-skid="0">
                <NavLink >
                    <!-- <PhPercent weight="duotone" class="h-7 w-7 fill-white-light" /> -->
                </NavLink>
            </Popper>
        </div>

        <div class="mb-1">
            <Popper content="Categorias" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink >
                    <!-- <PhStack weight="duotone" class="h-7 w-7 fill-white-light" /> -->
                </NavLink>
            </Popper>
        </div>

    </div>
</template>

<style src="./style.scss" lang="scss" />

<style>
:root {
    --popper-theme-background-color: #ffffff;
    --popper-theme-background-color-hover: #f3f3fa;
    --popper-theme-text-color: #545454;
    --popper-theme-border-width: 1px;
    --popper-theme-border-color: #e1e1e7;
    --popper-theme-border-style: solid;
    --popper-theme-border-radius: 5px;
    --popper-theme-padding: 10px;
}

.arrow::before {
    content: "";
    display: block;
    position: absolute;
    left: 4px;
    top: 16px;
    width: 4px;
    height: 4px;
    /* border-top: 8px solid #ffffff;
    border-bottom: 8px solid #ffffff;
    border-right: 8px solid #b7b7b7;*/
}

.popper {
    white-space: nowrap;
}

.isOpen {
    display: block;
}
</style>
