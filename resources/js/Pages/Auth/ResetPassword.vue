<template>
<!--    <jet-authentication-card>-->
<!--        <template #logo>-->
<!--            <jet-authentication-card-logo />-->
<!--        </template>-->

<!--        <jet-validation-errors class="mb-4" />-->

<!--        <form @submit.prevent="submit">-->
<!--            <div>-->
<!--                <jet-label for="email" value="Email" />-->
<!--                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />-->
<!--            </div>-->

<!--            <div class="mt-4">-->
<!--                <jet-label for="password" value="Password" />-->
<!--                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />-->
<!--            </div>-->

<!--            <div class="mt-4">-->
<!--                <jet-label for="password_confirmation" value="Confirm Password" />-->
<!--                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />-->
<!--            </div>-->

<!--            <div class="flex items-center justify-end mt-4">-->
<!--                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                    Reset Password-->
<!--                </jet-button>-->
<!--            </div>-->
<!--        </form>-->
<!--    </jet-authentication-card>-->
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
                                    <v-card-text >
                                        <v-card-text>
                                            <v-row justify="center" align="center">
                                                <v-spacer/>
                                                <v-img :width="5" :src="'/img/logo_colored.png'"/>
                                                <v-spacer/>
                                            </v-row>
                                        </v-card-text>
                                        <v-row justify="center" align="center">
                                            <p class="subtitle-1">Change your password here</p>
                                        </v-row>
                                        <error-alert/>
                                    </v-card-text>
                                    <v-card-text>

                                        <v-text-field
                                            label="Password"
                                            name="password"
                                            prepend-icon="mdi-lock"
                                            id="password"
                                            type="password"
                                            v-model="form.password" required
                                        ></v-text-field>

                                        <v-text-field
                                            label="Confirm Password"
                                            name="password_confirmation"
                                            prepend-icon="mdi-lock"
                                            id="password_confirmation"
                                            type="password"
                                            v-model="form.password_confirmation" required
                                        ></v-text-field>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn  :disabled="form.processing" block type="submit" color="primary">Change Password</v-btn>
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
        components: {
            ErrorAlert

        },

        props: {
            email: String,
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    email: this.email,
                    password: '',
                    password_confirmation: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.update'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
