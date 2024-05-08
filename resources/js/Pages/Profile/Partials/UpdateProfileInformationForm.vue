<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <FormSection @submitted="updateProfileInformation" >
        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="mb-4">
                <!-- Profile Photo File Input -->
                <div class="flex flex-row flex-wrap items-center">
                    <div class="flex w-full">
                        <div class="text-primary card-title">Meus Dados</div>
                    </div>
                    <div class="flex justify-center w-full">
                        <input id="photo" ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview">

                        <!-- <InputLabel for="photo" value="Photo" /> -->

                        <!-- Current Profile Photo -->
                        <div v-show="!photoPreview" class="mt-2">
                            <img :src="user.profile_photo_url" :alt="user.name"
                                class="object-cover w-20 h-20 rounded-full">
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div v-show="photoPreview" class="mt-2">
                            <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                                :style="'background-image: url(\'' + photoPreview + '\');'" />
                        </div>
                    </div>
                    <div class="flex justify-center w-full">
                        <SecondaryButton class="mt-2 me-2" type="button" @click.prevent="selectNewPhoto">
                            Selecionar Nova Foto
                        </SecondaryButton>

                        <SecondaryButton v-if="user.profile_photo_path" type="button" class="mt-2"
                            @click.prevent="deletePhoto">
                            Remover Foto
                        </SecondaryButton>

                        <InputError :message="form.errors.photo" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="container xl:px-40">

                <div class="mb-4 ">
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" required
                        autocomplete="name" />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-2">
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" required
                        autocomplete="username" />
                    <InputError :message="form.errors.email" class="mt-2" />

                    <div class="flex flex-row-reverse">

                        <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                            <p class="mt-2 text-sm">
                                Email não verificado.

                                <Link :href="route('verification.send')" method="post" as="button"
                                    class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    @click.prevent="sendEmailVerification">
                                Clique aqui para verifica-lo.
                                </Link>
                            </p>

                            <div v-show="verificationLinkSent" class="mt-2 text-sm font-medium text-green-600">
                                Um novo link de verificação foi enviado para seu endereço de e-mail.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Name -->
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Pronto.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Salvar
            </PrimaryButton>
        </template>
    </FormSection>
</template>
