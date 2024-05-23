<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import {computed, reactive} from "vue";
import Label from "@/Components/InputLabel.vue";
import {ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'

const name = "PaginationApi";

const props = defineProps({
 data: Object
});

/*** LIMPA O ARRAY DE PAGINACAO DO LARAVEL ***/
const cleanLinks = computed(() => {
    const cleanLinks = props.data.links
    cleanLinks.shift();
    cleanLinks.pop();

    return cleanLinks
});

const hidePagination = computed(() => {
    return !this.data.prev_page_url && !this.data.next_page_url
});
</script>

<script>
    export default {
        methods: {
            emitPagination(page) {
                this.$emit('pagination', page)
            }
        }
    }
</script>

<template>

    <div class="flex items-center justify-between mt-4">
        <Label v-if="data.to" :value="`Registro ${data.from} - ${data.to} de ${data.total}`"></Label>

        <div class="flex items-center">

            <button v-if="data.prev_page_url" @click="emitPagination(data?.current_page - 1)"  class="flex items-center justify-center w-8 h-8 mx-1 transition-colors duration-200 transform rounded-md bg-white-dark dark:bg-bgadm-light hover:bg-white-light/70 hover:bg-white-dark/50 dark:hover:bg-bgadm-light/70">
                <ChevronLeftIcon class="w-3 h-3 stroke-black-light dark:stroke-white-light" />
            </button>

            <button v-if="data.total" v-for="page in [...Array(cleanLinks?.length).keys()].map(i => i + 1)" :key="'page'+page" @click="(page != data?.current_page) && emitPagination(page)" :class="(page == data?.current_page) ? 'flex items-center justify-center w-8 h-8 mx-1 transform bg-primary text-white text-xs font-bold rounded-md transition-colors duration-200' : 'flex items-center justify-center w-8 h-8 mx-1 text-black-light dark:text-white-light text-xs transition-colors duration-200 transform bg-white-dark dark:bg-bgadm-light rounded-md hover:bg-white-dark/50 dark:hover:bg-bgadm-light/70'">
                {{page}}
            </button>

            <button v-if="data.next_page_url" @click="emitPagination(data?.current_page + 1)" class="flex items-center justify-center w-8 h-8 mx-1 transition-colors duration-200 transform rounded-md bg-white-dark dark:bg-bgadm-light hover:bg-white-dark/50 dark:hover:bg-bgadm-light/70">
                <ChevronRightIcon class="w-3 h-3 stroke-black-light dark:stroke-white-light" />
            </button>

        </div>
    </div>

</template>
