<script setup>
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Popper from "vue3-popper";

// import {
//     PhCoinVertical,
//     PhChalkboard,
//     PhPackage,
//     PhCube
// } from "@phosphor-icons/vue";
import IconsSvg from '../IconsSvg/IconsSvg.vue';

import {
    Squares2X2Icon,
    CurrencyDollarIcon,
    TruckIcon,
    TicketIcon
} from '@heroicons/vue/24/outline'
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
        <Link href="route('dashboard')" class="flex items-center justify-center mx-auto mb-4 rounded-lg">
            <IconsSvg name="logo-rifa8" class="w-4 h-4 md:w-7 md:h-7 fill-content" />
        </Link>

        <div class="mb-4 rounded">
            <Popper content="Dashboard" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink href="route('dashboard')">
                    <Squares2X2Icon class="w-6 h-6 text-content" />
                </NavLink>
            </Popper>
        </div>
        <div class="mb-4 rounded">
            <Popper content="Campanhas" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink href="route('campaign.index')" :active="false" >
                    <TicketIcon class="w-6 h-6 text-content" />
                </NavLink>
            </Popper>
        </div>
        <div class="mb-4 rounded">
            <Popper content="Meios de Pagamento" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink :active="false">
                    <CurrencyDollarIcon class="w-6 h-6 text-content" />
                </NavLink>
            </Popper>
        </div>

        <!-- <div class="mb-1">
            <Popper content="Produtos" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink :href="route('seller.product.index')" :active="route().current('seller.product.*')">
                    <PhCube weight="duotone" class=" h-7 w-7 fill-white-light" />
                </NavLink>
            </Popper>
        </div>

        <div class="mb-1">
            <Popper content="Resgate" arrow placement="right" hover openDelay="0" closeDelay="0" offset-distance="10"
                offset-skid="0">
                <NavLink :href="route('seller.cashout.index')" :active="route().current('seller.cashout.*')">
                    <CurrencyDollarIcon class="w-6 h-6 stroke-white-light" />
                </NavLink>
            </Popper>
        </div> -->
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
