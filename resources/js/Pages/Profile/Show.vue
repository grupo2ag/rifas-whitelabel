<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import EditStyleProfile from '@/Pages/Profile/Partials/EditStyleProfile.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AuthenticatedLayout :user="$page.props.auth.user">
        <!-- <AppLayout title="Profile"></AppLayout> -->
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-primary-bw">
                Profile
            </h2>
        </template>
        <div class="w-full">
            <div class="flex flex-row flex-wrap xl:flex-nowrap">
                <div class="w-full px-2 mb-4 lg:w-6/12">
                    <div class="items-center h-full rounded-lg bg-content">
                        <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                            <UpdateProfileInformationForm :user="$page.props.auth.user" />
                        </div>
                    </div>
                </div>
                <div class="w-full mb-4 lg:w-6/12">
                    <div class="flex flex-row flex-wrap px-2">
                        <div class="w-full mb-4">
                            <!-- twofactor -->
                            <div class="items-center h-full rounded-lg bg-content">
                                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                                    <TwoFactorAuthenticationForm :requires-confirmation="confirmsTwoFactorAuthentication" />
                                </div>
                            </div>
                        </div>
                        <div class="w-fulls xl:mb-0">
                            <!-- multSessions -->
                            <div class="items-center h-full rounded-lg bg-content">
                                <LogoutOtherBrowserSessionsForm :sessions="sessions" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row flex-wrap xl:flex-nowrap">
                <div class="w-full px-2 mb-4 lg:w-6/12">
                    <div class="items-center h-full rounded-lg bg-content">
                        <div v-if="$page.props.jetstream.canUpdatePassword">
                            <UpdatePasswordForm />
                        </div>
                    </div>
                </div>
                <div class="w-full px-2 mb-4 lg:w-6/12">
                    <div class="items-center h-full rounded-lg bg-content">
                            <EditStyleProfile />
                    </div>
                </div>

                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <div class="w-full px-2 mb-4 lg:w-6/12">
                        <div class="flex items-center h-full rounded-lg bg-content">
                            <DeleteUserForm class="lg:h-auto" />
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<!-- <div v-if="$page.props.jetstream.canUpdatePassword">
    <UpdatePasswordForm class="mt-10 sm:mt-0" />

    <SectionBorder />
</div> -->
