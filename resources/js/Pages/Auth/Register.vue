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
                                        <v-row justify="center" align="center">
                                            <p class="subtitle-1 font-weight-bold">Register here</p>
                                        </v-row>
                                        <error-alert/>
                                    </v-card-text>
                                    <v-card-text>
                                        <v-text-field
                                            label="Name"
                                            name="name"
                                            id="name"
                                            type="text"
                                            v-model="form.name"
                                            required
                                            prepend-icon="mdi-account"
                                        ></v-text-field>
                                        <v-text-field
                                            label="Email"
                                            name="email"
                                            id="email" type="email"
                                            v-model="form.email"
                                            required
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
                                        <v-text-field
                                            label="Password"
                                            name="password"
                                            prepend-icon="mdi-lock"
                                            id="password"
                                            type="password"
                                            v-model="form.password_confirmation" required
                                        ></v-text-field>
                                        <v-row >
                                            <v-col class="">
                                                <v-checkbox
                                                    v-model="form.terms"
                                                >
                                                    <div slot="label">
                                                        I agree to the <a target="_blank">
                                                        Terms of Service
                                                    </a> and <a target="_blank">
                                                        Privacy Policy</a>
                                                    </div>
                                                </v-checkbox>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <a :href="route('login')">
                                                    Already registered?
                                                </a>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn :disabled="form.processing" block type="submit" color="primary">
                                            {{form.processing ?  'Please wait' : 'Register'}}
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
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import ErrorAlert from "../../Components/Alerts/ErrorAlert";

export default {
    components: {
        ErrorAlert,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
