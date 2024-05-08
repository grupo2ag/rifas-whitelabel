<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">

        <template #form>
            <div class="flex flex-row flex-wrap">
                <div class="flex w-full mb-4">
                    <div class="text-primary card-title">Alterar Senha</div>
                </div>
                <div class="w-full px-2 mb-2 xl:w-4/12">
                    <InputLabel for="current_password" value="Senha Atual" />
                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        type="password" class="block w-full mt-1" autocomplete="current-password" />
                    <InputError :message="form.errors.current_password" class="mt-2" />
                </div>
                <div class="w-full px-2 mb-2 xl:w-4/12">
                    <InputLabel for="password" value="Nova Senha" />
                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="block w-full mt-1" autocomplete="new-password" />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>
                <div class="w-full px-2 mb-2 xl:w-4/12">
                    <InputLabel for="password_confirmation" value="Confirmar Nova Senha" />
                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="block w-full mt-1" autocomplete="new-password" />
                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                </div>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Pronto
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Salvar
            </PrimaryButton>
        </template>
    </FormSection>
</template>
