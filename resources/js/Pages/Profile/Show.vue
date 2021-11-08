<template>
    <!--    <app-layout>-->
    <!--        <template #header>-->
    <!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">-->
    <!--                Profile-->
    <!--            </h2>-->
    <!--        </template>-->

    <!--        <div>-->
    <!--            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">-->
    <!--                <div v-if="$page.props.jetstream.canUpdateProfileInformation">-->
    <!--                    <update-profile-information-form :user="$page.props.user" />-->

    <!--                    <jet-section-border />-->
    <!--                </div>-->

    <!--                <div v-if="$page.props.jetstream.canUpdatePassword">-->
    <!--                    <update-password-form class="mt-10 sm:mt-0" />-->

    <!--                    <jet-section-border />-->
    <!--                </div>-->

    <!--                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">-->
    <!--                    <two-factor-authentication-form class="mt-10 sm:mt-0" />-->

    <!--                    <jet-section-border />-->
    <!--                </div>-->

    <!--                <logout-other-browser-sessions-form :sessions="sessions" class="mt-10 sm:mt-0" />-->

    <!--                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">-->
    <!--                    <jet-section-border />-->

    <!--                    <delete-user-form class="mt-10 sm:mt-0" />-->
    <!--                </template>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </app-layout>-->

    <main-layout :app="this">
        <v-card color="grey lighten-4">
            <update-profile-information :user="$page.props.user"/>
            <v-divider class="mx-4"/>
            <update-password/>
            <v-divider class="mx-4"/>
            <two-factor-authentication/>
            <v-divider class="mx-4"/>
            <logout-other-session :sessions="sessions"/>
        </v-card>
    </main-layout>
</template>

<script>
import DeleteUserForm from './DeleteUserForm'
import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
import UpdatePasswordForm from './UpdatePasswordForm'
import UpdateProfileInformationForm from './UpdateProfileInformationForm'
import UpdateProfileInformation from "./UpdateProfileInformationForm";
import UpdatePassword from "./UpdatePasswordForm";
import TwoFactorAuthentication from "./TwoFactorAuthenticationForm";
import LogoutOtherSession from "./LogoutOtherBrowserSessionsForm";
import MainLayout from "../../Layouts/MainLayout";

export default {
    name: 'ShowProfile',
    props: ['sessions'],

    components: {
        MainLayout,
        LogoutOtherSession,
        TwoFactorAuthentication,
        UpdatePassword,
        UpdateProfileInformation,
        DeleteUserForm,
        LogoutOtherBrowserSessionsForm,
        TwoFactorAuthenticationForm,
        UpdatePasswordForm,
        UpdateProfileInformationForm,
    },
}
</script>
