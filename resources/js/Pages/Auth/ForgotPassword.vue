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
                                    <v-card-text >
                                        <v-row justify="center" align="center">
                                            <p class="h-6">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                                        </v-row>
                                        <error-alert/>
                                    </v-card-text>
                                    <v-card-text>
                                        <v-text-field
                                            label="Email"
                                            name="email"
                                            id="email" type="email"
                                            v-model="form.email"
                                            required
                                            autofocus
                                            prepend-icon="mdi-mail"
                                        ></v-text-field>
                                        <a :href="route('login')">
                                            Have password?
                                        </a>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn :disabled="form.processing" block type="submit" color="primary">
                                            Email Password Reset Link
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
<!--    <jet-authentication-card>-->
<!--        <template #logo>-->
<!--            <jet-authentication-card-logo />-->
<!--        </template>-->

<!--        <div class="mb-4 text-sm text-gray-600">-->
<!--            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.-->
<!--        </div>-->

<!--        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">-->
<!--            {{ status }}-->
<!--        </div>-->

<!--        <jet-validation-errors class="mb-4" />-->

<!--        <form @submit.prevent="submit">-->
<!--            <div>-->
<!--                <jet-label for="email" value="Email" />-->
<!--                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />-->
<!--            </div>-->

<!--            <div class="flex items-center justify-end mt-4">-->
<!--                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                    Email Password Reset Link-->
<!--                </jet-button>-->
<!--            </div>-->
<!--        </form>-->
<!--    </jet-authentication-card>-->
</template>

<script>
    import ErrorAlert from "../../Components/Alerts/ErrorAlert";

    export default {
        components: {
            ErrorAlert,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    }
</script>
