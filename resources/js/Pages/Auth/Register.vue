<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import * as func from '@/Helpers/functions';
import { ArrowLeftIcon, ArrowLongLeftIcon } from '@heroicons/vue/24/outline';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    phone: '',
    document: '',
    terms: false,
});
</script>

<script>
export default {
    methods: {
        submit(form) {
            if (!this.validateForm(form)) {
                axios.post(route('registerUser'), form).then(res => {
                    this.$swal.fire({
                        title: 'Pronto!',
                        text: 'Cadastro realizado com sucesso!',
                        icon: 'success',
                        confirmButtonText: "Fazer Login",
                    }).then((resp) => {
                        if (resp.isConfirmed && resp.is) {
                            window.location.href = '/login';
                        }else {
                            window.location.href = '/login';
                        }
                    })
                }).catch(err => {
                    this.errorManage(err?.response?.data?.message, form);
                    this.$swal.fire(
                        'Ops!',
                        `Erro ao criar cadastro!`,
                        'error'
                    )
                })
            }
            // form.post(route('register'), {
            //     onFinish: () => form.reset('password', 'password_confirmation'),
            // });
        },
        validateForm(form) {
            if (form.document && form.document?.length <= 14) {
                !func.validateCPF(form.document) ? (form.errors.document = 'CPF inválido.') : (delete form?.errors?.document);
            }

            // Validação do email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (form.email && !emailPattern.test(form.email)) {
                form.errors.email = 'Email inválido.';
            } else if (form?.errors?.email) {
                delete form?.errors?.email;
            }

            if (form.password || form.password_confirmation) {
                if (form.password != form.password_confirmation) {
                    form.errors.password = 'As senhas precisam ser iguais';
                    form.errors.password_confirmation = 'As senhas precisam ser iguais';
                } else {
                    if (form?.errors?.password) delete form?.errors?.password;
                    if (form?.errors?.password_confirmation) delete form?.errors?.password_confirmation;
                }
            }

            return Object.keys(form.errors).length >= 1;
        },
        errorManage(errors, form) {
            if (errors) {
                const schema = {
                    'name': errors?.name && errors?.name[0],
                    'email': errors?.email && errors?.email[0],
                    'document': errors?.document && errors?.document[0],
                    'phone': errors?.phone && errors?.phone[0],
                    'password': errors?.password && errors?.password[0]
                }
                Object.keys(errors).map(key => {
                    if (schema[key]) {
                        form.errors[key] = this.translateErrors(schema[key], key);
                    }
                })
            }
        },
        translateErrors(error, key) {
            let msg = error;
            if (key == 'document') {
                error.includes('has already been taken') && (msg = 'Documento já cadastrado')
            }
            if (key == 'phone') {
                error.includes('has already been taken') && (msg = 'Telefone já cadastrado')
            }
            if (key == 'password') {
                error.includes('field must be') && (msg = 'A senha deve possuir no mínimo 8 carácteres, letras maiúsculas, letras minúsculas, números e carácteres especiais')
            }
            if (key == 'email') {
                error.includes('has already been taken') && (msg = 'Email já cadastrado')
            }
            return msg;
        },
        redirectToLogin() {
            window.location.href = route('login');
        }
    },
}
</script>

<template>

    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="flex flex-row w-full">
            <div class="flex justify-end w-full">
                <button @click="redirectToLogin()" class="border-none rounded-lg btn btn-sm bg-primary text-primary-bw"><ArrowLeftIcon class="w-4 "/> Voltar</button>
            </div>
        </div>
        <form @submit.prevent="submit(form)">
            <div>
                <InputLabel for="name" value="Nome" />
                <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" required autofocus
                    autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput @change="validateForm(form)" id="email" v-model="form.email" type="email"
                    class="block w-full mt-1" required autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Telefone" />
                <TextInput id="phone" v-model="form.phone" type="text" class="block w-full mt-1" required
                    autocomplete="new-phone" v-mask="['(##) #####-####', '(##) ####-####']" />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4">
                <InputLabel for="document" value="CPF" />
                <TextInput @change="validateForm(form)" id="document" v-model="form.document" type="text"
                    class="block w-full mt-1" required autocomplete="new-document" v-mask="['###.###.###-##']" />
                <InputError class="mt-2" :message="form.errors.document" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Senha" />
                <TextInput id="password" v-model="form.password" type="password" class="block w-full mt-1" required
                    autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar Senha" />
                <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                    class="block w-full mt-1" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ms-2">
                            Aceito os <a target="_blank" :href="route('terms.show')"
                                class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Termos
                                de Serviço</a> e as <a target="_blank" :href="route('policy.show')"
                                class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Políticas
                                de Privacidade</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                    class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Já é registrado?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
