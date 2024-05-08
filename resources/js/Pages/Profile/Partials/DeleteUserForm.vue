<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection>
        <template #content>
            <div class="flex items-center">
                <div class="flex flex-row flex-wrap">
                    <div class="w-full">
                        <div class="text-sm ">
                            Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos permanentemente.
                            Antes
                            excluir sua conta, baixe quaisquer dados ou informações que você deseja reter.
                        </div>
                    </div>
                    <div class="flex justify-end w-full">
                        <div class="mt-5">
                            <DangerButton @click="confirmUserDeletion">
                                Delete Account
                            </DangerButton>
                        </div>
                    </div>
                </div>


                <!-- Delete Account Confirmation Modal -->
                <DialogModal :show="confirmingUserDeletion" @close="closeModal">
                    <template #title>
                        Delete Account
                    </template>

                    <template #content>
                        Are you sure you want to delete your account? Once your account is deleted, all of its resources
                        and data will be permanently deleted. Please enter your password to confirm you would like to
                        permanently delete your account.

                        <div class="mt-4">
                            <TextInput ref="passwordInput" v-model="form.password" type="password"
                                class="block w-3/4 mt-1" placeholder="Password" autocomplete="current-password"
                                @keyup.enter="deleteUser" />

                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>
                    </template>

                    <template #footer>
                        <SecondaryButton @click="closeModal">
                            Cancel
                        </SecondaryButton>

                        <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing" @click="deleteUser">
                            Delete Account
                        </DangerButton>
                    </template>
                </DialogModal>
            </div>
        </template>
    </ActionSection>
</template>
