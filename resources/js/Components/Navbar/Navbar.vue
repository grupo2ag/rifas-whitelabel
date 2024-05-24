<script setup>
import Popper from "vue3-popper";
import NavLink from '@/Components/NavLink.vue';
import {
    Squares2X2Icon,
    CurrencyDollarIcon,
    TruckIcon,
    TicketIcon
} from '@heroicons/vue/24/outline';
</script>

<template>
    <ul class=" menu menu-horizontal bg-primary rounded-box flex-nowrap">
        <li class="px-1">
            <NavLink >
                <Squares2X2Icon class="w-5 h-5 text-primary-bw" />
            </NavLink>
        </li>
        <li class="px-1">
            <NavLink :active="false">
                <TicketIcon class="w-5 h-5 text-primary-bw" />
            </NavLink>
        </li>
        <li class="px-1">
            <NavLink :active="false">
                <CurrencyDollarIcon class="w-5 h-5 text-primary-bw" />
            </NavLink>
        </li>
    </ul>
</template>
