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
                            <error-alert/>
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
                                        <p class="subtitle-1" v-if="! recovery">
                                            Please confirm access to your account by entering the authentication code provided by your authenticator application.
                                        </p>

                                        <p class="subtitle-1" v-else>
                                            Please confirm access to your account by entering one of your emergency recovery codes.
                                        </p>
                                    </v-card-text>
                                    <v-card-text>
                                        <v-text-field
                                            v-if="! recovery"
                                            label="Code"
                                            name="code"
                                            id="code"
                                            v-model="form.code"
                                            autofocus
                                            prepend-icon="mdi-qrcode"
                                        ></v-text-field>
                                        <v-text-field
                                            v-else
                                            label="Recovery Code"
                                            name="recovery_code"
                                            id="recovery_code"
                                            v-model="form.recovery_code"
                                            autofocus
                                            prepend-icon="mdi-qrcode-edit"
                                        ></v-text-field>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn text color="primary" @click.prevent="toggleRecovery">
                                            <template v-if="! recovery">
                                                Use a recovery code
                                            </template>

                                            <template v-else>
                                                Use an authentication code
                                            </template>
                                        </v-btn>
                                        <v-spacer/>
                                        <v-btn  :disabled="form.processing"  type="submit" color="primary">Login</v-btn>
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
            ErrorAlert,
        },

        data() {
            return {
                recovery: false,
                form: this.$inertia.form({
                    code: '',
                    recovery_code: '',
                })
            }
        },

        methods: {
            toggleRecovery() {
                this.recovery ^= true

                this.$nextTick(() => {
                    if (this.recovery) {
                        this.$refs.recovery_code.focus()
                        this.form.code = '';
                    } else {
                        this.$refs.code.focus()
                        this.form.recovery_code = ''
                    }
                })
            },

            submit() {
                this.form.post(this.route('two-factor.login'))
            }
        }
    }
</script>
