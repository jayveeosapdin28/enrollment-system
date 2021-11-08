<template>
<!--    <jet-form-section @submitted="updatePassword">-->
<!--        <template #title>-->
<!--            Update Password-->
<!--        </template>-->

<!--        <template #description>-->
<!--            Ensure your account is using a long, random password to stay secure.-->
<!--        </template>-->

<!--        <template #form>-->
<!--            <div class="col-span-6 sm:col-span-4">-->
<!--                <jet-label for="current_password" value="Current Password" />-->
<!--                <jet-input id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" ref="current_password" autocomplete="current-password" />-->
<!--                <jet-input-error :message="form.errors.current_password" class="mt-2" />-->
<!--            </div>-->

<!--            <div class="col-span-6 sm:col-span-4">-->
<!--                <jet-label for="password" value="New Password" />-->
<!--                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" ref="password" autocomplete="new-password" />-->
<!--                <jet-input-error :message="form.errors.password" class="mt-2" />-->
<!--            </div>-->

<!--            <div class="col-span-6 sm:col-span-4">-->
<!--                <jet-label for="password_confirmation" value="Confirm Password" />-->
<!--                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />-->
<!--                <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />-->
<!--            </div>-->
<!--        </template>-->

<!--        <template #actions>-->
<!--            <jet-action-message :on="form.recentlySuccessful" class="mr-3">-->
<!--                Saved.-->
<!--            </jet-action-message>-->

<!--            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                Save-->
<!--            </jet-button>-->
<!--        </template>-->
<!--    </jet-form-section>-->
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Update Password'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Ensure your account is using a long, random password to stay secure.</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12" class="pa-3">
            <form @submit.prevent="updatePassword">
                <v-card>
                    <v-card-text>
                        <v-form v-model="valid">
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="form.current_password"
                                            :rules="fieldRules"
                                            type="password"
                                            label="Current Password"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="form.password"
                                            :rules="fieldRules"
                                            type="password"
                                            label="Password"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="form.password_confirmation"
                                            :rules="fieldRules"
                                            type="password"
                                            label="Confirm Password"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn
                            color="success"
                            v-if="form.recentlySuccessful"
                            text
                        >
                            Saved
                        </v-btn>
                        <v-btn
                            type="submit"
                            color="primary"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        >
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </form>

        </v-col>
    </v-row>
</template>

<script>

    export default {
        name: 'UpdatePassword',
        components: {
        },

        data() {
            return {
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }),
                valid: false,
                fieldRules: [
                    v => !!v || 'This field is required',
                ],
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('user-password.update'), {
                    errorBag: 'updatePassword',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        if (this.form.errors.password) {
                            this.form.reset('password', 'password_confirmation')
                            this.$refs.password.focus()
                        }

                        if (this.form.errors.current_password) {
                            this.form.reset('current_password')
                            this.$refs.current_password.focus()
                        }
                    }
                })
            },
        },
    }
</script>
