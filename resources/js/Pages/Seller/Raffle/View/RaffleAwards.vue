<script>
import Button from "@/Components/Button/Button.vue";

export default {
    components: {Button},
    props: {
        awards: Object
    },
    data() {
        return {
            loading: false,
        };
    },
    methods: {
        onAwarded(id) {
            this.$swal.fire({
                title: "Informe o numero sorteado",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Procurar Ganhador",
                showLoaderOnConfirm: true,
                preConfirm: async (login) => {
                    try {
                        const response = await fetch(route('raffles.RaffleAward'));
                        if (!response.ok) {
                            return this.$swal.showValidationMessage(`${JSON.stringify(await response.json())}`);
                        }
                        return response.json();
                    } catch (error) {
                        this.$swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !this.$swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$swal.fire({
                        title: `${result.value.login}'s avatar`,
                        imageUrl: result.value.avatar_url
                    });
                }
            });
        }
    },
    // mounted() {
    //     console.log(this.data);
    // }
}
</script>
<template>
    <div class="flex flex-row flex-wrap w-full py-2 mt-4 rounded-lg bg-base-100">
        <div class="flex flex-wrap w-full my-2">
            <div class="flex justify-start w-full px-4 mb-2 xl:w-8/12 text-neutral/70 card-title">
                Premios
            </div>
        </div>
        <div class="flex-row items-center hidden w-full py-2 m-2 rounded-lg lg:flex bg-base-200">
            <div class="flex justify-center w-1/12 text-neutral/70">Premio</div>
            <div class="flex justify-center w-2/12 text-neutral/70">Numero Premiado</div>
            <div class="flex justify-center w-2/12 text-neutral/70">Ganhador</div>
            <div class="flex justify-center w-2/12 text-neutral/70">G.Telefone</div>
            <div class="flex justify-center w-2/12 text-neutral/70">G.CPF</div>
            <div class="flex justify-center w-2/12 text-neutral/70">DEFINIR GANHADOR</div>
        </div>
        <div v-if="awards && awards?.length > 0" class="w-full pr-3">
            <div v-for="award in awards" :key="award.id"
                class="flex flex-row flex-wrap w-full py-2 m-2 rounded-lg lg:items-center bg-content animate-fade-down animate-duration-1000 ">
                <div class="flex justify-center w-full p-2 px-2 mx-2 mb-2 break-all rounded-lg lg:m-0 lg:w-1/12">
                    {{ award?.description }}</div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                   {{ award?.number_award }}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    {{ award?.name }}
                </div>
                <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center text-neutral/70 lg:w-2/12">
                    {{ award?.winner_phone }}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-1/12">
                    {{ award?.cpf }}
                </div>
                <div>
                    <Button type="button" @click="onAwarded(award?.id)" color="primary" class="mt-2"></Button>
                </div>
            </div>
        </div>
        <div v-else class="flex flex-row flex-wrap items-center justify-center w-full py-8 mb-4 rounded-lg bg-base-100">
            <span class="text-base text-xl font-medium title-font text-neutral/70">Nenhum premio encontrada</span>
        </div>
    </div>
</template>
