<script setup>
// import Welcome from '@/Components/Welcome.vue';
import { useForm } from '@inertiajs/vue3';
</script>

<script>
import * as func from '@/Helpers/functions.js'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Input from '@/Components/FormElements/Input.vue';
import InputPercent from '@/Components/FormElements/InputPercent.vue';
import Button from '@/Components/Button/Button.vue';
import Select from '@/Components/FormElements/Select.vue';
import SwitchCheckbox from '@/Components/SwitchCheckbox/SwitchCheckbox.vue';
import CurrencyInput from '@/Components/FormElements/CurrencyInput.vue';
import {
    PlusCircleIcon,
    ArrowLeftIcon,
    XMarkIcon,
    DocumentTextIcon,
    PhotoIcon,
    PencilSquareIcon,
    ClockIcon,
    TrashIcon,
    StarIcon,
    InformationCircleIcon,
    TrophyIcon,
    TicketIcon,
    AdjustmentsHorizontalIcon,
    ReceiptPercentIcon,
    ArrowsRightLeftIcon,
    PlusIcon
} from '@heroicons/vue/24/outline';
import InputPercentVue from '@/Components/FormElements/InputPercent.vue';

export default {
    components: {
        AuthenticatedLayout,
        Input,
        Select,
        Button,
        SwitchCheckbox,
        CurrencyInput,
        PlusCircleIcon,
        ArrowLeftIcon,
        XMarkIcon,
        DocumentTextIcon,
        PhotoIcon,
        PencilSquareIcon,
        ClockIcon,
        TrashIcon,
        StarIcon,
        InformationCircleIcon,
        TrophyIcon,
        TicketIcon,
        AdjustmentsHorizontalIcon,
        ReceiptPercentIcon,
    },
    props: {
        affiliate: Object,
        raffles: Array
    },
    mounted() {
        console.log(this.raffles);
    },
    data() {
        return {
            form: {
                name: this?.affiliate ? this?.affiliate?.name : '',
                description: this?.affiliate ? this?.affiliate?.description : '',
                document: this?.affiliate ? this?.affiliate?.document : '',
                phone: this?.affiliate ? this?.affiliate?.phone : '',
                email: this?.affiliate ? this?.affiliate?.email : '',
                pixKey: this?.affiliate ? this?.affiliate?.pixKey : '',
                raffles: [
                    {
                        raffleId: '',
                        type: '',
                        value: 0,
                        link: ''
                    }
                ]
            },
            validator: {
                name: '',
                document: '',
                phone: '',
                email: '',
                pixKey: '',
                raffles: []
            },
            characterLenght: 0,
            characterLenghtDescription: 0,
        }
    },
    methods: {
        addRaffle() {
            console.log(this.form);
            if (this.form.raffles.length < this.raffles.length) {
                this.form.raffles.push({
                    raffleId: '',
                    type: '',
                    value: 0,
                    link: ''
                })
            }
        },
        removeRaffle(index) {
            this.form.raffles.splice(index, 1);
        },
        validateForm() {
            this.errors = {
                raffles: []
            };

            // Validação do nome
            if (!this?.form?.name) {
                this.errors.name = 'O nome é obrigatório.';
            } else if (this?.form?.name?.length > 80) {
                this.errors.name = 'O nome não pode ter mais de 80 caracteres.';
            }

            if (!this?.form?.document) {
                this.errors.document = 'O documento é obrigatório.';
            } else {
                if (this?.form?.document?.length <= 14) {
                    !func.validateCPF(this?.form?.document) && (this.errors.document = 'CPF inválido.')
                } else {
                    !func.validateCNPJ(this?.form?.document) && (this.errors.document = 'CNPJ inválido.');
                }
            }

            // Validação do email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this?.form?.email) {
                this.errors.email = 'O email é obrigatório.';
            } else if (!emailPattern.test(this?.form?.email)) {
                this.errors.email = 'Email inválido.';
            }

            // Validação do telefone
            if (!this?.form?.phone) {
                this.errors.phone = 'O telefone é obrigatório.';
            }

            if (!this?.form?.pixKey) {
                this.errors.pixKey = 'Chave Pix é obrigadtório.';
            } else if (this?.form?.pixKey?.length < 3) {
                this.errors.pixKey = 'Chave Pix inválida.';
            }

            this.form.raffles.map((vinculation, index) => {
                if (!!vinculation?.raffleId || !!vinculation?.type || !!vinculation?.value) {
                    const objErrorRaffle = {};
                    if (!vinculation?.raffleId) {
                        objErrorRaffle['raffleId'] = 'Preencha o campo'
                    }
                    if (!vinculation?.type) {
                        objErrorRaffle['type'] = 'Preencha o campo'
                    }
                    if (!vinculation?.value) {
                        objErrorRaffle['value'] = 'Preencha o campo'
                    }
                    this.errors.raffles[index] = objErrorRaffle;
                }
            });

            this.validator = this.errors;
            return Object.keys(this.errors).length === 1;
        },
        verifyVinculations() {
            const seen = new Set();
            this.form.raffles = this.form.raffles.filter(raffle => {
                if (raffle.raffleId === '') return true;
                if (seen.has(raffle.raffleId)) {
                    return false; // Remove duplicado
                } else {
                    seen.add(raffle.raffleId);
                    return true;
                }
            });
        },
        submitForm() {
            if (this.validateForm()) {
                axios.post(route('affiliate.affiliateStore', this.form)).then(() => {
                    this.$swal(
                        'Pronto!',
                        'Afiliado adicionado com sucesso!',
                        'success'
                    );
                    this.form = {
                        raffles: [
                            {
                                raffleId: '',
                                type: '',
                                value: 0,
                                link: ''
                            }
                        ]
                    };
                }).catch(() => {
                    this.$swal(
                        'Ops!',
                        'Houve um erro ao adicionar afiliado, tente novamente.',
                        'error'
                    );
                });
            }
        }
    },
}
</script>

<template>

    <Head title="Afiliados"></Head>
    <AuthenticatedLayout :user="$page.props.auth.user">
        <template #header>
            <h2 class="flex items-center font-semibold text-content lg:text-xl">
                <UsersIcon class="w-5 h-5 mr-2 text-content lg:w-6 lg:h-6" />
                Criar Afiliado
            </h2>
        </template>
        <div class="w-full py-5 md:container lg:w-6/12">
            <form @submit.prevent="onSubmit">
                <div class="mb-4 c-content" ref="geral">
                    <div class="flex items-center justify-between w-full pb-2 border-b border-base-100">
                        <div class="flex items-center">
                            <TicketIcon class="h-5 mr-1 stroke-neutral" />

                            <h3 class="text-base font-semibold text-neutral">Informações de Afiliado</h3>
                        </div>

                        <Button :href="route('affiliate.affiliateIndex')" size="sm" color="outline-light">
                            <ArrowLeftIcon class="w-4 mr-2 fill-white" /> Voltar
                        </Button>
                    </div>

                    <div class="flex flex-row flex-wrap w-full pt-3">
                        <div class="w-full px-1">
                            <Input :validate="validateForm" label="*Nome" v-model="form.name" type="text" :name="'name'"
                                :maxlength="80" v-on:keyup="(e) => characterLenght = e.target.value.length"
                                :error="validator.name || $page.props.errors.name" placeholder="Insira o nome" />
                            <div class="relative z-30 flex justify-end w-full" :class="validator.name && '-top-6'">
                                <p class="px-2 mb-2 -mt-2 text-xs text-neutral/70">
                                    {{ characterLenght }} de 80
                                    caracteres</p>
                            </div>

                        </div>
                        <div class="w-full px-1">
                            <Input :validate="validateForm" label="Descrição" v-model="form.description" type="textarea"
                                :name="'description'" :maxlength="100"
                                v-on:keyup="(e) => characterLenghtDescription = e.target.value.length"
                                :error="validator.description || $page.props.errors.description"
                                placeholder="Insira a descrição" />
                            <div class="relative z-30 flex justify-end w-full"
                                :class="validator.description && '-top-6'">
                                <p class="px-2 mb-2 -mt-2 text-xs text-neutral/70">
                                    {{ characterLenghtDescription }} de 100
                                    caracteres</p>
                            </div>

                        </div>
                        <div class="w-full px-1 md:w-6/12">
                            <!-- documento -->
                            <Input v-mask="['###.###.###-##', '##.###.###/####-##']" :validate="validateForm"
                                label="*Documento" v-model="form.document" type="text" :name="'document'"
                                :maxlength="20" :error="validator?.document || $page?.props?.errors?.document"
                                placeholder="Insira o documento" />
                        </div>
                        <div class="w-full px-1 md:w-6/12">
                            <!-- Email -->
                            <Input :validate="validateForm" label="*Email" v-model="form.email" type="text"
                                :name="'email'" :maxlength="20" :error="validator?.email"
                                placeholder="Insira o email" />
                        </div>
                        <div class="w-full px-1 md:w-6/12">
                            <!-- Telefone -->
                            <Input v-mask="['(##) #####-####', '(##) ####-####']" :validate="validateForm"
                                label="*Telefone" v-model="form.phone" type="text" :name="'phone'" :maxlength="20"
                                :error="validator?.phone || $page?.props?.errors?.phone"
                                placeholder="Insira o telefone" />
                        </div>
                        <div class="w-full px-1 md:w-full">
                            <!-- chave pix -->
                            <Input :validate="validateForm" label="*Chave Pix" v-model="form.pixKey" type="text"
                                :name="'pixKey'" :maxlength="20"
                                :error="validator?.pixKey || $page?.props?.errors?.pixKey"
                                placeholder="Insira a chave pix" />
                        </div>
                    </div>
                </div>

                <div v-if="!!raffles && raffles?.length > 0" class="mb-4 c-content">
                    <div class="flex flex-row w-full pb-2 border-b border-base-100">
                        <div class="flex flex-row items-center w-full">
                            <div class="flex justify-start w-6/12">
                                <ArrowsRightLeftIcon class="h-5 mr-1 stroke-neutral" />

                                <h3 class="text-base font-semibold text-neutral">Vincular Rifas</h3>
                            </div>
                            <div class="flex justify-end w-6/12">
                                <button class="btn btn-sm bg-primary text-primary-bw" @click="addRaffle">
                                    <PlusIcon class="w-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-for="(raffle, index) in form.raffles" :key="raffle"
                        class="flex flex-row flex-wrap w-full mb-2 animate-fade-down">
                        <div class="w-4/12 px-1">
                            <Select :label="'Rifa'" v-model="form.raffles[index].raffleId"
                                @input="form.raffles[index].link = raffles[index]?.link"
                                :error="validator?.raffles[index]?.raffleId" :name="'raffle' + index" :role="'button'">
                                <option v-for="raffle in this.raffles" :key="raffle?.id" :value="raffle?.id">
                                    {{ raffle?.title }}</option>
                            </Select>
                        </div>
                        <div class="w-3/12 px-1">
                            <Select :label="'Tipo'" :modelValue="form.raffles[index].type"
                                :error="validator?.raffles[index]?.type" :name="'type' + index" :role="'button'"
                                @input="(e) => (form.raffles[index].type = e.target.value, form.raffles[index].value = 0)">
                                <option value="percent">Porcentagem</option>
                                <option value="fixed">Fixo</option>
                            </Select>
                        </div>
                        <div v-if="form.raffles[index].type == '' || form.raffles[index].type == 'fixed'" class="w-4/12 px-1 animate-fade-left">
                            <CurrencyInput label="Valor" :name="'value' + index" v-model="form.raffles[index].value">
                            </CurrencyInput>
                        </div>
                        <div v-else class="w-4/12 px-1 animate-fade-left">
                            <InputPercent :label="'Porcentagem'" :type="'number'" :name="'value' + index" v-model="form.raffles[index].value"/>
                            <!-- <Input :maxlength="'2'" :label="'Porcentagem'" :type="'text'" :name="'value' + index" /> -->
                        </div>
                        <div class="flex items-center justify-center w-1/12">
                            <button v-if="index >= 1" @click="removeRaffle(index)" class="btn btn-sm btn-error">
                                <TrashIcon class="w-4 text-white" />
                            </button>
                        </div>
                    </div>
                </div>

                <div class="c-content">
                    <div class="flex justify-end gap-4" v-if="$page.props.message">
                        <p>{{ $page.props.message }}</p>
                    </div>
                    <div class="flex justify-end gap-4" v-else>
                        <Button :href="route('affiliate.affiliateIndex')" size="sm" color="outline-light">
                            Cancelar
                        </Button>
                        <Button type="button" @click="submitForm" color="success" :loading="loading"
                            :disabled="disabled">
                            Salvar
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss">
:root {
    --ck-border-radius: 10px;
}

.ck.ck-editor {
    @apply text-black
}

.ck-editor__editable {
    min-height: 200px;
}

.box-url {
    @apply py-3 relative cursor-not-allowed;

    &__content {
        @apply block px-3 pb-2 pt-3 text-base bg-content w-full text-neutral border border-white-dark rounded-xl focus:outline-none focus:ring-0 focus:border-blue
    }
}

.c-content {
    //@apply hidden;

    &.active {
        @apply block
    }
}


.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
