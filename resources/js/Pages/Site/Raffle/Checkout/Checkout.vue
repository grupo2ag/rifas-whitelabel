<script setup>
import * as func from '@/Helpers/functions';
</script>

<script>
import Modal from '@/Components/Modal/Modal.vue'
import * as func from '@/Helpers/functions';
import Icon from '@/Components/Icon/Icon.vue'
import Input from '@/Components/FormElements/Input.vue'
import Button from '@/Components/Button/Button.vue'
import * as yup from "yup";
import {pt} from 'yup-locale-pt';
import {Inertia} from "@inertiajs/inertia";
import {useForm} from "@inertiajs/inertia-vue3";
import {PhoneInput} from '@lbgm/phone-number-input';
import '@lbgm/phone-number-input/style';

const cpfIsValid = function (cpf) {

    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '') return false;
    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito
    let add = 0;
    for (var i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    let rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito
    add = 0;
    for (var i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;

    return true;
}

const getInitials = function (string) {
    var names = string.split(' '),
        initials = names[0].substring(0, 1).toUpperCase();

    if (names.length > 1) {
        initials += names[names.length - 1].substring(0, 1).toUpperCase();
    }
    return initials;
};

const manualNumbers = function (numbers) {
    console.log('aqui', numbers);
    let nums = [];
    numbers.forEach((number) => {
        nums.push(nums.number)
    });

    return nums;
};

export default {
    name: "Checkout",
    props: {
        open: Boolean,
        quantity: Number,
        total: Number,
        numbers: Array,
        manual: Array,
        raffle: Object
    },
    components: {
        Modal,
        Icon,
        Input,
        Button,
        PhoneInput
    },
    data() {
        return {
            //modal: this.open
            data: !!this.manual ? manualNumbers(this.manual) : [],
            formVerify: {
                cpf: '',
                processing: false,
            },
            formPurchase: {
                name: '',
                phone: '',
                confirmPhone: '',
                email: '',
                cpf: '',
                buyer: '',
                raffle_id: this.raffle.id,
                user_id: this.raffle.user_id,
                quantity: this.quantity,
                total: this.total
            },
            schemaVerify: {},
            schemaPurchase: {},
            validateVerify: {
                cpf: '',
            },
            validatePurchase: {
                name: '',
                phone: '',
                email: '',
                cpf: '',
                buyer: '',
            },
            step: 'VERIFY',
            customer: {},
        }
    },
    mounted() {
        yup.setLocale(pt);
        this.schemaPurchase = yup.object().shape({

            //name: yup.string().min(3, 'Digite ao menos 3 caracteres').required('Obrigatório'),
            buyer: yup.string(),
            name: yup.string().when("buyer", {
                is: () => this.formPurchase.buyer === '',
                then: yup.string().min(3, 'Digite ao menos 3 caracteres').required('Obrigatório'),
                otherwise: yup.string(),
            }),
            phone: yup.string().when("buyer", {
                is: () => this.formPurchase.buyer === '',
                then: yup.string().min(14, 'Telefone inválido').required('Obrigatório'),
                otherwise: yup.string(),
            }),
            phone_confirmation: yup.string().when("buyer", {
                is: () => this.formPurchase.buyer === '',
                then: yup.string().min(14, 'invalido').oneOf([yup.ref('phone'), null], 'Telefone diferente').required('Obrigatório'),
                otherwise: yup.string(),
            }),
            email: yup.string().when("buyer", {
                is: () => this.formPurchase.buyer === '',
                then: yup.string().email('Informe um E-mail válido').min(8, 'E-mail incompleto').required('Obrigatório').matches(func.emailRegex, "E-mail inválido"),
                otherwise: yup.string(),
            }),
            cpf: yup.string().when("buyer", {
                is: () => this.formPurchase.buyer === '',
                then: yup.string().min(13, 'CPF incompleto').required('Obrigatório').test('test-invalid-cpf', 'CPF Inválido', value => cpfIsValid(value))
                    .required('CPF é obrigatório'),
                otherwise: yup.string(),
            }),
        })

        this.schemaVerify = yup.object().shape({
            cpf: yup.string().min(13, 'CPF incompleto').required('Obrigatório').test('test-invalid-cpf', 'CPF Inválido', value => cpfIsValid(value))
                .required('CPF é obrigatório'),
        })
    },
    methods: {
        closeModal() {
            this.$emit('close')
        },
        onVerify() {
            //      this.validatorVerify();

            this.schemaVerify
                .validate(this.formVerify, {abortEarly: false}).then(() => {
                this.formVerify.processing = true;

                fetch(route('verify', this.formVerify.cpf)).then(
                    resp => {
                        resp.json().then((data) => {
                            if (!!data.cpf) {
                                this.customer = data;

                                this.formPurchase.name = this.customer.name
                                this.formPurchase.phone = this.customer.phone
                                this.formPurchase.email = this.customer.email
                                this.formPurchase.buyer = this.customer.buyer
                                //this.formPurchase.cpf = this.customer.cpf

                                this.step = 'CONFIRM'
                            } else {
                                this.formPurchase.cpf = this.formVerify.cpf
                                this.step = 'PURCHASE'
                            }
                        }).catch(error => {
                            console.error(error);
                        });
                        this.formVerify.processing = false;
                        //   this.clearVerify()
                    });
            }).catch((err) => {
                this.formVerify.processing = false;

                err.inner.forEach((error) => {
                    this.validateVerify = {...this.validateVerify, [error.path]: error.message};
                });
            });
        },
        onPurchase() {
            //const form = useForm(this.formPurchase);

            // this.validatorPurchase();

            this.schemaPurchase
                .validate(this.formPurchase, {abortEarly: false}).then(() => {
                this.formPurchase.processing = true;

                axios.post(route('purchase', this.formPurchase))
                    .then((res) => {
                        let resposta = res.data

                        if (!resposta.pix.order_id) {
                            this.formVerify.processing = false;
                        } else {
                            this.formVerify.processing = true;
                            console.log(resposta, resposta.pix.order_id);
                            Inertia.visit(route('pay', resposta.pix.order_id));
                        }
                        //FECHA LOADING
                    }).catch((errors) => {
                    console.log('errors', errors);
                    this.formVerify.processing = false;
                    this.errors = errors;

                    this.closeModal()

                    this.$swal({
                        html: "<p class='text-xl font-normal text-black'>" + this.errors.response.data.message + "</p>",
                        confirmButtonText: "Ok",
                        icon: 'error',
                        type: 'error',
                        allowOutsideClick: true,
                        customClass: {
                            confirmButton: 'sw-btn sw-btn--red',
                            popup: 'sw-popup',
                            title: 'sw-title',
                        }
                    })
                    //FECHA LOADING
                })

            }).catch((err) => {
                // console.log('aqui')
                this.formVerify.processing = false;

                err.inner.forEach((error) => {
                    this.validatePurchase = {...this.validatePurchase, [error.path]: error.message};
                });
            });
        },
        validatorVerify($attribute) {
            Object.keys(this.validateVerify).forEach(key => {
                if ($attribute === key) {
                    this.validateVerify[key] = ''
                }
            });

            this.schemaVerify
                .validate(this.formVerify, {abortEarly: false})
                .then(() => {
                    // this.errors.user = {};
                })
                .catch(err => {
                    //   this.errors.user = {};

                    err.inner.forEach((error) => {
                        if ($attribute === error.path) {
                            this.validateVerify = {...this.validateVerify, [error.path]: error.message};
                        }
                    });
                });
        },
        validatorPurchase($attribute) {
            Object.keys(this.validatePurchase).forEach(key => {
                if ($attribute === key) {
                    this.validatePurchase[key] = ''
                }
            });

            this.schemaPurchase
                .validate(this.formPurchase, {abortEarly: false})
                .then(() => {
                    // this.errors.user = {};
                })
                .catch(err => {
                    //   this.errors.user = {};
                    err.inner.forEach((error) => {
                        if ($attribute === error.path) {
                            this.validatePurchase = {...this.validatePurchase, [error.path]: error.message};
                        }
                    });
                });
        },
        returnVerify() {
            this.step = 'VERIFY';

            this.validatePurchase = {
                name: '',
                phone: '',
                email: '',
                cpf: '',
            }

            this.formVerify = {
                cpf: ''
            };
        }
    },
    watch: {
        'formPurchase.name': function () {
            if (!!this.formPurchase.name) this.formPurchase.name = this.formPurchase.name.toUpperCase()
        },
        'quantity': function () {
            this.formPurchase.quantity = this.quantity
        },
        'total': function () {
            this.formPurchase.total = this.total
        }
    }
}
</script>

<template>
    <Modal :show="open" @close="closeModal()">
        <template #header>
            <div class="relative">
                <Button v-if="step !== 'VERIFY'" type="button" color="outline-primary" size="sm" class="!px-2 absolute left-0"
                        @click="returnVerify">
                    <Icon name="icon-arrow-left" class="w-4 fill-primary md:mr-1"/>
                    <span class="hidden md:block">Voltar</span>
                </Button>

                <h3 class="w-full mb-2 text-2xl font-bold text-center text-neutral font-secondary ">
                    Checkout
                </h3>
            </div>
        </template>

        <template #body>
            <div class="pb-3 mb-3 border-b border-base-100">
                <template v-if="false">
                    <p class="mb-1 text-sm text-neutral/70">Deseja reservar o(s) número(s):</p>
                    <div
                        class="flex flex-wrap items-start w-full gap-1 pb-3 md:pb-0">
                        <template v-for="item in data">
                            <div class="bg-primary text-primary-bw px-3 py-1.5 flex items-center rounded-md gap-1">
                                <p class="text-sm uppercase text-primary-bw">
                                    {{ item.number }}
                                </p>
                                <button type="" @click="removeItem(item.number)" aria-label="Excluir Número">
                                    <Icon name="icon-trash" class="stroke-primary-bw h-[14px]"/>
                                </button>
                            </div>
                        </template>
                    </div>
                </template>
                <template v-else>
                    <div class="">
                        <p class="text-center text-neutral">
                            Seus números serão gerados assim que concluir a reserva.
                        </p>
                    </div>
                </template>
            </div>

            <div class="p-2.5 bg-primary flex rounded-xl gap-8">
                <div class="flex items-center justify-center p-3 rounded-lg bg-content/50">
                    <Icon name="icon-bag" class="w-6 h-6 stroke-primary-bw"/>
                </div>

                <div class="grid flex-1 grid-cols-2">
                    <div class="">
                        <p class="text-sm text-primary-bw">Quantidade</p>
                        <p class="text-2xl text-primary-bw">{{ quantity }}</p>
                    </div>

                    <div class="">
                        <p class="text-sm text-primary-bw">Valor Total</p>
                        <span class="text-2xl font-bold text-primary-bw">{{ func.formatValue(total) }}</span>
                    </div>
                </div>
            </div>

            <template v-if="step === 'VERIFY'">
                <form @submit.prevent="onVerify" class="pt-3 mt-3 border-t border-base-100">
                    <div class="w-full">
                        <Input type="tel" label="CPF" :name="formVerify.cpf" placeholder="000.000.000-00"
                               autocomplete="tel" :error="validateVerify.cpf" v-model="formVerify.cpf"
                               v-mask="'###.###.###-##'"/>
                    </div>

                    <div class="p-2 mb-3 bg-warning rounded-xl">
                        <p class="flex items-center gap-2 text-sm text-warning-bw/70">
                        <span
                            class="flex items-center justify-center w-5 h-5 rounded-full bg-warning-bw/20 text-warning-bw">!
                        </span>
                            Informe seu cpf para continuar.</p>
                    </div>

                    <p class="mb-2 text-xs text-neutral/70">
                        Reservando seu(s) número(s), você declara que leu e concorda com nossos <a
                        href="" target="_blank" class="text-blue">Termos de Uso.</a>
                    </p>

                    <Button type="submit" color="info" class="w-full font-bold uppercase"
                            :disabled="formVerify.processing" :loading="formVerify.processing">
                        Continuar
                    </Button>
                </form>
            </template>

            <template v-if="step === 'CONFIRM'">
                <form @submit.prevent="onPurchase" class="pt-3 mt-3 border-t border-base-100">

                    <div class="flex items-center w-full gap-3 p-2 my-2 mb-4 border border-base-100 rounded-xl">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                            <span class="text-lg font-bold text-primary-bw">{{ getInitials(formPurchase.name) }}</span>
                        </div>

                        <div class="">
                            <p class="font-bold text-neutral">{{ formPurchase.name }}</p>
                            <p class="text-sm text-neutral/70">{{ formPurchase.phone }}</p>
                            <p class="text-sm text-neutral/70">{{ formPurchase.email }}</p>
                        </div>
                    </div>

                    <Button type="submit" color="success" class="w-full font-bold uppercase"
                            :disabled="formPurchase.processing" :loading="formPurchase.processing">
                        Concluir Reserva
                    </Button>
                </form>
            </template>

            <template v-if="step === 'PURCHASE'">
                <form @submit.prevent="onPurchase" class="pt-3 mt-3 border-t border-base-100">
                    <div class="w-full">
                        <Input type="text" label="Nome Completo" :name="formPurchase.name" placeholder="Digite o nome"
                               autocomplete="name" :error="validatePurchase.name" v-model="formPurchase.name"
                               @validate="validatorPurchase('name')"/>
                    </div>

                    <div class="w-full">
                        <Input type="tel" label="Telefone" :name="formPurchase.phone" placeholder="(00) 00000-0000"
                               autocomplete="tel" :error="validatePurchase.phone" v-model="formPurchase.phone"
                               v-mask="['(##) #####-####', '(##) ####-####']" @validate="validatorPurchase('phone')"/>
                    </div>

                    <div class="w-full">
                        <Input type="tel" label="Confirme o Telefone" :name="formPurchase.phone_confirmation"
                               placeholder="(00) 00000-0000"
                               autocomplete="tel" :error="validatePurchase.phone_confirmation"
                               v-model="formPurchase.phone_confirmation"
                               v-mask="['(##) #####-####', '(##) ####-####']"
                               @validate="validatorPurchase('phone_confirmation')"/>
                    </div>

                    <div class="w-full">
                        <Input type="text" label="E-mail" :name="formPurchase.email" placeholder="email@email.com"
                               autocomplete="email" @validate="validatorPurchase('email')"
                               v-model="formPurchase.email" :error="validatePurchase.email"/>
                    </div>

                    <div class="w-full">
                        <Input type="text" label="CPF" :name="formPurchase.cpf" placeholder="000.000.000-00"
                               autocomplete="cpf" @validate="validatorPurchase('cpf')"
                               v-model="formPurchase.cpf" :error="validatePurchase.cpf" v-mask="'###.###.###-##'"/>
                    </div>

                    <div class="p-2 mb-3 bg-warning/20 rounded-xl">
                        <p class="flex items-center gap-2 text-sm text-warning-bw/60">
                        <span
                            class="flex items-center justify-center w-5 h-5 rounded-full bg-warning/50 text-warning-bw">
                        !
                        </span>
                            Informe seus dados corretamente.
                        </p>
                    </div>

                    <p class="mb-3 text-xs text-neutral/70">
                        Reservando seu(s) número(s), você declara que leu e concorda com nossos
                        <a href="" target="_blank" class="text-blue">Termos de Uso.</a>
                    </p>

                    <Button type="submit" color="success" class="w-full font-bold uppercase"
                            :disabled="formPurchase.processing" :loading="formPurchase.processing">
                        Concluir Reserva
                    </Button>
                </form>
            </template>
        </template>
    </Modal>
</template>

<style lang="scss" scoped>
.c-raffle {

    &__number {
        @apply py-2 px-3 border border-primary text-primary rounded-lg;

        &--reserved {
            @apply bg-warning border-warning text-warning-bw;
        }

        &--paid {
            @apply bg-success border-success text-success-bw;
        }

        &[active='true'] {
            @apply border-primary bg-primary text-white;
        }
    }
}

</style>
