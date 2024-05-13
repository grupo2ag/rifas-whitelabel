<script setup>
import StatsRaffleSale from '@/Components/Stats/StatsRaffleSale.vue';
import {
    UserIcon,
    CurrencyDollarIcon,
    PhoneIcon,
    EnvelopeIcon,
    CalendarDaysIcon
} from '@heroicons/vue/24/outline';
</script>

<script>
export default {

}
</script>
<template>
    <div class="flex flex-row flex-wrap justify-center mb-4">
        <div class="w-full px-2 mb-2 lg:w-4/12">
            <StatsRaffleSale :title="'1 Lugar'" :value="'R$ 75,000'" :textBottom="'↗︎ Exemplo de um texto de rodape'"
                :userName="'DD'">
                <template #cup>
                    <div class="p-2 mb-2 rounded-full bg-neutral timeline-middle text-yellow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 lg:w-6 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </div>
                </template>
            </StatsRaffleSale>
        </div>
        <div class="w-full px-2 mb-2 lg:w-4/12">
            <StatsRaffleSale :title="'2 Lugar'" :value="'R$ 75,000'" :textBottom="'↗︎ Exemplo de um texto de rodape'"
                :userName="'DD'">
                <template #cup>
                    <div class="p-2 mb-2 rounded-full timeline-middle bg-neutral text-gray">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 lg:w-6 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </div>
                </template>
            </StatsRaffleSale>
        </div>
        <div class="w-full px-2 mb-2 lg:w-4/12">
            <StatsRaffleSale :title="'3 Lugar'" :value="'R$ 75,000'" :textBottom="'↗︎ Exemplo de um texto de rodape'"
                :userName="'DD'">
                <template #cup>
                    <div class="p-2 mb-2 rounded-full timeline-middle bg-neutral text-[#b54a07]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 lg:w-6 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </div>
                </template>
            </StatsRaffleSale>
        </div>
    </div>
    <div class="flex flex-row flex-wrap w-full py-2 rounded-lg bg-base-100">
        <div class="flex justify-start w-full">
            <div class="px-4 text-neutral card-title">
                Minhas Vendas
            </div>
        </div>
        <div class="flex-row items-center hidden w-full py-2 m-2 rounded-lg lg:flex bg-content">
            <div class="flex justify-center w-1/12">Id</div>
            <div class="flex justify-center w-3/12">Nome</div>
            <div class="flex justify-center w-2/12">Valor</div>
            <div class="flex justify-center w-2/12">Telefone</div>
            <div class="flex justify-center w-3/12">Email</div>
            <div class="flex justify-center w-1/12">Data</div>
        </div>

        <!-- loop -->
        <div v-for="i in 15" :key="i" class="flex flex-row flex-wrap w-full py-2 m-2 rounded-lg lg:items-center bg-base-300">
            <div class="flex justify-center w-full p-2 px-2 mx-2 mb-2 rounded-lg lg:m-0 lg:w-1/12 bg-primary lg:bg-base-300 lg:text-primary text-primary-bw">{{ i }}</div>
            <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center lg:w-3/12"><UserIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-primary"/>Donald Duck</div>
            <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center lg:w-2/12"><CurrencyDollarIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-primary"/>R$ 3,00</div>
            <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center lg:w-2/12"><PhoneIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-primary"/>(18) 99777-7777</div>
            <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center lg:w-3/12"><EnvelopeIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-primary"/>donaldpato@duck.com</div>
            <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center lg:w-1/12"><CalendarDaysIcon class="flex w-6 mr-1 lg:m-0 lg:hidden text-primary"/>12/02/2024</div>
        </div>
        <!--  -->
        <div class="flex flex-row w-full px-2">
            <div class="flex justify-end w-full">
                <!-- Paginantion -->
                <div class="join">
                    <button class="join-item btn">«</button>
                    <button class="join-item btn ">1</button>
                    <button class="join-item btn btn-active">2</button>
                    <button class="join-item btn ">3</button>
                    <button class="join-item btn btn-disabled">...</button>
                    <button class="join-item btn ">10</button>
                    <button class="join-item btn">»</button>
                </div>
            </div>
        </div>
    </div>

</template>
