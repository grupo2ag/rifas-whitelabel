<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';


defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />
    <GuestLayout>
        <!-- <AuthenticationCard> -->
        <!-- <template #logo>
            <AuthenticationCardLogo />
        </template> -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" required autofocus
                    autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Senha" />
                <TextInput id="password" v-model="form.password" type="password" class="block w-full mt-1" required
                    autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4 mb-2">
                <label class="flex items-center" role="button">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="text-sm text-gray-600 ms-2">Lembrar-me</span>
                </label>
            </div>
            <div class="flex flex-col mb-4">
                <!-- <PrimaryButton class=" ms-4" :class="{ ' opacity-25': form.processing }" :disabled="form.processing">
                    Login
                </PrimaryButton> -->
                <button type="submit" class="p-2 text-white rounded bg-primary hover:bg-primary/70">Login</button>
            </div>
            <div class="flex flex-row flex-wrap">
                <div class="flex items-center justify-start w-6/12">
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="text-sm text-gray-600 underline rounded-md hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Esqueci minha senha
                    </Link>
                </div>
                <div class="flex items-center justify-end w-6/12">
                    <Link :href="route('register')"
                        class="text-sm text-gray-600 underline rounded-md hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cadastrar-se
                    </Link>
                </div>
            </div>
        </form>
        <!-- </AuthenticationCard> -->
    </GuestLayout>
</template>
