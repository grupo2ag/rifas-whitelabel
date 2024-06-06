<script setup>
import { CreditCardIcon, PhoneIcon, TicketIcon, TrophyIcon, UserIcon } from "@heroicons/vue/24/outline";
import Button from "@/Components/Button/Button.vue";
</script>

<script>
export default {
    components: {Button},
    props: {
        id: String | Number
    },
    data() {
        return {
            loading: false,
            awards: {}
        };
    },
    created() {
        this.getAwards();
    },
    methods: {
        getAwards() {
            axios.get(route('raffles.raffleAwards', {id: this.id})).then(res => {
                this.awards = res?.data;
            }).catch(err => {
                console.log(err);
            })
        },
        onAwarded(raffle, id) {
            this.$swal.fire({
                title: "Informe o numero sorteado",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Procurar Ganhador",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !this.$swal.isLoading()
            }).then(async (result) => {
               // console.log(result)
                if (result.isConfirmed) {
                    try {
                        let number = result.value;
                        const response = await fetch(route('raffles.raffleAward', [raffle, result.value]));

                        if (!response.ok) {
                            return this.$swal.fire({
                                title: "Não encontrado",
                                text: 'Verifique o numero e pesquise novamente',
                                icon: "error"
                            });
                        }else{
                            let data = await response.json()

                            if (data.msg && data.msg.length) {
                                return this.$swal.fire({
                                    title: "Não encontrado",
                                    text: data.msg,
                                    icon: "error"
                                });
                            }else{

                                this.$swal.fire({
                                    title: "Dados do participante",
                                    html: "Nome: <b>"+data.name+"</b></br>"+
                                        "Telefone: <b>"+data.phone+"</b></br>"+
                                        "Email: <b>"+data.email+"</b></br>"+
                                        "CPF: <b>"+data.document+"</b>",
                                    showCancelButton: true,
                                    confirmButtonText: "Definir Ganhador",
                                    showLoaderOnConfirm: true,
                                    allowOutsideClick: () => !this.$swal.isLoading()
                                }).then(async (resp) => {
                                    if (resp.isConfirmed) {
                                        try {
                                            const responsePart = await fetch(route('raffles.raffleAwardPart', [raffle, id, data.id, number]));
                                            let dataPart = await responsePart.json();

                                            if(dataPart){
                                                this.$swal.fire({
                                                    title: "Ganhador definido",
                                                    icon: "success"
                                                }).then(()=>{
                                                    // Inertia.reload()
                                                    this.getAwards();
                                                })
                                                this.$emit('updateAwardCheck', true);
                                            }else{
                                                this.$swal.fire({
                                                    title: "Problema ao registrar ganhador",
                                                    icon: "error"
                                                });
                                            }

                                        }catch (error) {
                                            return this.$swal.fire({
                                                title: "Problema ao registrar ganhador",
                                                text: `Request failed: ${error}`,
                                                icon: "error"
                                            });
                                            //this.$swal.showValidationMessage(`Request failed: ${error}`);
                                        }
                                    }
                                })
                            }
                        }
                    } catch (error) {
                        this.$swal.showValidationMessage(`Request failed: ${error}`);
                    }
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
            <div class="flex justify-start w-4/12 px-4 text-neutral/70">Premio</div>
            <div class="flex justify-center w-1/12 text-neutral/70">Numero Premiado</div>
            <div class="flex justify-center w-3/12 text-neutral/70">Ganhador</div>
            <div class="flex justify-center w-1/12 text-neutral/70">G.Telefone</div>
            <div class="flex justify-center w-1/12 text-neutral/70">G.CPF</div>
            <div class="flex justify-center w-2/12 text-neutral/70"></div>
        </div>
        <div v-if="awards && awards?.length > 0" class="w-full pr-3">
            <div v-for="award in awards" :key="award.id"
                class="flex flex-row flex-wrap w-full py-2 m-2 rounded-lg lg:items-center bg-content animate-fade-down animate-duration-1000 ">
                <div class="flex justify-start w-full px-2 mb-2 break-all rounded-lg text-neutral/70 lg:px-4 lg:m-0 lg:w-4/12">
                    <TrophyIcon class="flex w-5 mr-1 lg:m-0 lg:hidden text-neutral/70"/>
                    {{ award?.description  ?? '----'}}</div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-1/12">
                    <TicketIcon class="flex w-5 mr-1 lg:m-0 lg:hidden text-neutral/70" />
                   {{ award?.number_award  ?? '----'}}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-3/12">
                    <UserIcon class="flex w-5 mr-1 lg:m-0 lg:hidden text-neutral/70"/>
                    {{ award?.name  ?? '----'}}
                </div>
                <div class="flex w-full px-2 mb-1 lg:mb-0 lg:justify-center text-neutral/70 lg:w-1/12">
                    <PhoneIcon class="flex w-5 mr-1 lg:m-0 lg:hidden text-neutral/70"/>
                    {{ award?.winner_phone  ?? '----'}}
                </div>
                <div class="flex w-full px-2 mb-1 break-all lg:mb-0 lg:justify-center text-neutral/70 lg:w-1/12">
                    <CreditCardIcon class="flex w-6 lg:m-0 lg:hidden text-neutral/70" />
                    <UserIcon class="relative w-2 right-3 top-[2px] lg:m-0 lg:hidden text-neutral" />
                    {{ award?.cpf  ?? '----'}}
                </div>
                <div class="flex w-full px-2 lg:justify-end lg:w-2/12 lg:px-4">
                    <button @click="onAwarded(award?.raffle_id, award?.id)" class="mt-2 border-none rounded-lg btn btn-sm bg-primary text-primary-bw btn-block lg:btn-md">Definir Ganhador</button>
                </div>
            </div>
        </div>
        <div v-else class="flex flex-row flex-wrap items-center justify-center w-full py-8 mb-4 rounded-lg bg-base-100">
            <span class="text-base text-xl font-medium title-font text-neutral/70">Nenhum premio encontrada</span>
        </div>
    </div>
</template>
