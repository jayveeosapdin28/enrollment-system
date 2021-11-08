<template>
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
                                    <v-card-text>
                                        <v-row justify="center" align="center">
                                            <v-spacer/>
                                            <v-img :width="5" :src="'/img/logo_colored.png'"/>
                                            <v-spacer/>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-text >
                                        <v-row justify="center" align="center">
                                            <p class="subtitle-1 font-weight-bold">Login here</p>
                                        </v-row>
                                        <error-alert/>
                                    </v-card-text>
                                    <v-text-field
                                        label="Email"
                                        name="email"
                                        id="email" type="email"
                                        v-model="form.email"
                                        required
                                        autofocus
                                        prepend-icon="mdi-mail"
                                    ></v-text-field>

                                    <v-text-field
                                        label="Password"
                                        name="password"
                                        prepend-icon="mdi-lock"
                                        id="password"
                                        type="password"
                                        v-model="form.password" required
                                    ></v-text-field>
                                    <v-row class="pa-4">
                                        <a :href="route('register')">
                                            Need account?
                                        </a>
                                        <v-spacer></v-spacer>
                                        <a :href="route('password.request')">
                                            Forgot your password?
                                        </a>
                                    </v-row>
                                    <v-checkbox
                                        v-model="form.remember"
                                        label="Remember me"
                                    ></v-checkbox>
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn  :disabled="form.processing" block type="submit" color="primary">
                                        {{form.processing ?  'Please wait' : 'Login'}}
                                    </v-btn>
                                </v-card-actions>

                            </form>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import ErrorAlert from "../../Components/Alerts/ErrorAlert";

export default {
    components: {
        ErrorAlert,
    },

    props: {
        canResetPassword: Boolean,
        status: String
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form
                .transform(data => ({
                    ...data,
                    remember: this.form.remember ? 'on' : ''
                }))
                .post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
        }
    }
}
</script>
