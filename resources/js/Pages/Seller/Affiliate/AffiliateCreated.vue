<script setup>
// import Welcome from '@/Components/Welcome.vue';
import { useForm } from '@inertiajs/vue3';
</script>

<script>
import * as func from '@/Helpers/functions.js'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Input from '@/Components/FormElements/Input.vue';
import Button from '@/Components/Button/Button.vue';
import Select from '@/Components/FormElements/Select.vue';
import CurrencyInput from '@/Components/FormElements/CurrencyInput.vue';
import SwitchCheckbox from '@/Components/SwitchCheckbox/SwitchCheckbox.vue';
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
ArrowsRightLeftIcon
} from '@heroicons/vue/24/outline';

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
        affiliate: Object
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
            },
            validator: {
                name: '',
                document: '',
                phone: '',
                email: '',
                pixKey: '',
            },
            characterLenght: 0,
            characterLenghtDescription: 0,
        }
    },
    methods: {
        validateForm() {
            this.errors = {};

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

            this.validator = this.errors;
            return Object.keys(this.errors).length === 0;
        },
        submitForm() {
            if (this.validateForm()) {
                axios.post(route('affiliate.affiliateStore', this.form)).then(() => {
                    this.$swal(
                        'Pronto!',
                        'Afiliado adicionado com sucesso!',
                        'success'
                    );
                    this.form = {};
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
                            <Input :validate="validateForm" label="Descrição" v-model="form.description" type="textarea" :name="'description'"
                                :maxlength="100" v-on:keyup="(e) => characterLenghtDescription = e.target.value.length"
                                :error="validator.description || $page.props.errors.description" placeholder="Insira a descrição" />
                            <div class="relative z-30 flex justify-end w-full" :class="validator.description && '-top-6'">
                                <p class="px-2 mb-2 -mt-2 text-xs text-neutral/70">
                                    {{ characterLenghtDescription }} de 100
                                    caracteres</p>
                            </div>

                        </div>
                        <div class="w-full px-1 md:w-6/12">
                            <!-- documento -->
                            <Input v-mask="['###.###.###-##', '##.###.###/####-##']" :validate="validateForm"
                                label="*Documento" v-model="form.document" type="text" :name="'document'"
                                :maxlength="20"
                                :error="validator?.document || $page?.props?.errors?.document"
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

                <div class="mb-4 c-content">
                    <div class="flex flex-row w-full pb-2 border-b border-base-100">
                        <div class="flex items-center">
                            <ArrowsRightLeftIcon class="h-5 mr-1 stroke-neutral" />

                            <h3 class="text-base font-semibold text-neutral">Vincular Rifas</h3>
                        </div>
                    </div>
                    <div class="flex flex-row w-full">

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
