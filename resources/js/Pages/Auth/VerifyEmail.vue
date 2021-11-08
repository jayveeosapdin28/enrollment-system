<template>
    <v-app id="inspire">
        <v-app id="inspire">
            <v-main>
                <v-container
                    class="fill-height"
                    fluid
                >
                    <v-row
                        align="center"
                        justify="center"
                    >
                        <v-col
                            cols="12"
                            sm="8"
                            md="4"
                        >
                            <v-card class="elevation-0">
                                <form @submit.prevent="submit">
                                    <v-card-text>
                                        <v-row justify="center" align="center">
                                            <v-spacer/>
                                            <v-img :width="5" :src="'/img/logo_colored.png'"/>
                                            <v-spacer/>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-text>
                                        <v-card-text >
                                            <v-row justify="center" align="center">
                                                <p class="subtitle-1">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                                                </p>
                                            </v-row>
                                            <v-row>
                                                <error-alert/>
                                                <v-alert dark type="success">
                                                    A new verification link has been sent to the email address you provided during registration.
                                                </v-alert>
                                            </v-row>
                                        </v-card-text>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn color="red" type="button" dark @click="logout">
                                            Logout
                                        </v-btn>
                                        <v-spacer/>
                                        <v-btn  :disabled="form.processing" type="submit" color="primary">
                                            Resend Verification Email
                                        </v-btn>
                                    </v-card-actions>

                                </form>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </v-app>
    </v-app>
</template>

<script>
    import ErrorAlert from "../../Components/Alerts/ErrorAlert";
    export default {
        name: 'VerifyEmail',
        components: {ErrorAlert},
        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
            logout() {
                this.$inertia.post(route('logout'));
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    }
</script>
