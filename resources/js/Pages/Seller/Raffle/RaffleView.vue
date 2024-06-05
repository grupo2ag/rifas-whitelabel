<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RaffleLayout from '@/Layouts/RaffleLayout.vue';
import RaffleDashboard from '@/Pages/Seller/Raffle/View/RaffleDashboard.vue';
import RaffleSale from '@/Pages/Seller/Raffle/View/RaffleSale.vue';
import RaffleReserve from '@/Pages/Seller/Raffle/View/RaffleReserve.vue';
import RaffleLive from './View/RaffleLive.vue';
import RaffleAffiliate from './View/RaffleAffiliate.vue';
import {
    TicketIcon,
    DocumentTextIcon,
    ArrowLeftIcon
} from '@heroicons/vue/24/outline';
</script>
<script>
import axios from 'axios';
import RaffleAffiliateVue from './View/RaffleAffiliate.vue';

export default {
    name: "RaffleView",
    props: {
        data: Object,
        tab: String
    },
    data() {
    return {
      openTab: 1,
      results: this.data
    }
  },
  methods: {
    toggleTabs(tabNumber){
      this.openTab = tabNumber
    },
    previousPage() {
      window.location.href = route('raffles.raffleIndex')
    },

  },
  mounted() {
      const url = new URLSearchParams(window.location.search);
      if(url.has('page')) this.openTab = 2;
  }
}
</script>

<template>

    <Head title="Rifa"></Head>
    <AuthenticatedLayout :user="$page.props.auth.user">
        <template #header>
            <h2 class="flex items-center font-semibold text-primary-bw lg:text-xl">
                <TicketIcon class="w-5 h-5 mr-2 lg:w-6 lg:h-6 text-primary-bw" />
                {{`Rifa #${data?.raffle?.id}`}}
            </h2>
        </template>
        <div class="container-none !w-full px-2">
            <div class="flex flex-row mb-4">
                <button @click="previousPage" class="flex justify-center border-none text-neutral/70 btn bg-content hover:bg-base-200 btn-sm lg:btn-md"><ArrowLeftIcon class="w-5 h-5" /> Voltar</button>
            </div>
            <RaffleLayout @toggleTabs="toggleTabs" :openTab="openTab" :data="results?.raffle">
                <template #body>
                    <div class="animate-fade-right" v-bind:class="{'hidden': openTab !== 1, '': openTab === 1}">
                        <RaffleDashboard :data="results"/>
                    </div>
                    <div class="animate-fade-left" v-bind:class="{'hidden': openTab !== 2, '': openTab === 2}">
                        <RaffleSale :data="results"/>
                    </div>
                    <div class="animate-fade-left" v-bind:class="{'hidden': openTab !== 3, '': openTab === 3}">
                        <RaffleReserve :data="results"/>
                    </div>
                    <div class="animate-fade-left" v-bind:class="{'hidden': openTab !== 4, '': openTab === 4}">
                        <RaffleAffiliate :id="data?.raffle?.id"/>
                    </div>
                    <div class="animate-fade-left" v-bind:class="{'hidden': openTab !== 5, '': openTab === 5}">
                        <RaffleLive :id="data?.raffle?.id"/>
                    </div>
                </template>
            </RaffleLayout>
        </div>
    </AuthenticatedLayout>
</template>
