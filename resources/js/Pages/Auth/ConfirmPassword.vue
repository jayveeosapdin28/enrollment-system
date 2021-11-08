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
                                            <p class="subtitle-1"> This is a secure area of the application. Please confirm your password before continuing.</p>
                                        </v-row>
                                        <error-alert/>
                                    </v-card-text>
                                    <v-card-text>
                                        <form @submit.prevent="submit">
                                            <v-row>
                                                <v-col>
                                                    <v-text-field
                                                        id="password"
                                                        type="password"
                                                        v-model="form.password"
                                                        required
                                                        autocomplete="current-password"
                                                        autofocus
                                                    >
                                                    </v-text-field>
                                                </v-col>
                                            </v-row>
                                        </form>
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-btn type="submit" color="primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Confirm
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
        components: {
            ErrorAlert,
        },

        data() {
            return {
                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.confirm'), {
                    onFinish: () => this.form.reset(),
                })
            }
        }
    }
</script>
