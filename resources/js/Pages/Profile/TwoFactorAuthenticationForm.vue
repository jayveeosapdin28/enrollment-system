<template>
<!--    <jet-action-section>-->
<!--        <template #title>-->
<!--            Two Factor Authentication-->
<!--        </template>-->

<!--        <template #description>-->
<!--            Add additional security to your account using two factor authentication.-->
<!--        </template>-->

<!--        <template #content>-->
<!--            <h3 class="text-lg font-medium text-gray-900" v-if="twoFactorEnabled">-->
<!--                You have enabled two factor authentication.-->
<!--            </h3>-->

<!--            <h3 class="text-lg font-medium text-gray-900" v-else>-->
<!--                You have not enabled two factor authentication.-->
<!--            </h3>-->

<!--            <div class="mt-3 max-w-xl text-sm text-gray-600">-->
<!--                <p>-->
<!--                    When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.-->
<!--                </p>-->
<!--            </div>-->

<!--            <div v-if="twoFactorEnabled">-->
<!--                <div v-if="qrCode">-->
<!--                    <div class="mt-4 max-w-xl text-sm text-gray-600">-->
<!--                        <p class="font-semibold">-->
<!--                            Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.-->
<!--                        </p>-->
<!--                    </div>-->

<!--                    <div class="mt-4 dark:p-4 dark:w-56 dark:bg-white" v-html="qrCode">-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div v-if="recoveryCodes.length > 0">-->
<!--                    <div class="mt-4 max-w-xl text-sm text-gray-600">-->
<!--                        <p class="font-semibold">-->
<!--                            Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.-->
<!--                        </p>-->
<!--                    </div>-->

<!--                    <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">-->
<!--                        <div v-for="code in recoveryCodes" :key="code">-->
<!--                            {{ code }}-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="mt-5">-->
<!--                <div v-if="! twoFactorEnabled">-->
<!--                    <jet-confirms-password @click="enableTwoFactorAuthentication">-->
<!--                        <jet-button type="button" :class="{ 'opacity-25': enabling }" :disabled="enabling">-->
<!--                            Enable-->
<!--                        </jet-button>-->
<!--                    </jet-confirms-password>-->
<!--                </div>-->

<!--                <div v-else>-->
<!--                    <jet-confirms-password@click="regenerateRecoveryCodes">-->
<!--                        <jet-secondary-button class="mr-3"-->
<!--                                        v-if="recoveryCodes.length > 0">-->
<!--                            Regenerate Recovery Codes-->
<!--                        </jet-secondary-button>-->
<!--                    </jet-confirms-password>-->

<!--                    <jet-confirms-password@click="showRecoveryCodes">-->
<!--                        <jet-secondary-button class="mr-3" v-if="recoveryCodes.length === 0">-->
<!--                            Show Recovery Codes-->
<!--                        </jet-secondary-button>-->
<!--                    </jet-confirms-password>-->

<!--                    <jet-confirms-password@click="disableTwoFactorAuthentication">-->
<!--                        <jet-danger-button-->
<!--                                        :class="{ 'opacity-25': disabling }"-->
<!--                                        :disabled="disabling">-->
<!--                            Disable-->
<!--                        </jet-danger-button>-->
<!--                    </jet-confirms-password>-->
<!--                </div>-->
<!--            </div>-->
<!--        </template>-->
<!--    </jet-action-section>-->
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Two Factor Authentication'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Add additional security to your account using two factor authentication.</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12" class="pa-3">
           <v-card>
               <v-card-title>
                   <h4 class="text-lg font-medium text-gray-900" v-if="twoFactorEnabled">
                       You have enabled two factor authentication.
                   </h4>

                   <h4 class="text-lg font-medium text-gray-900" v-else>
                       You have not enabled two factor authentication.
                   </h4>
               </v-card-title>
                <v-card-text>
                    <div class="mt-3 max-w-xl text-sm text-gray-600">
                        <p>
                            When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
                        </p>
                    </div>
                    <div v-if="twoFactorEnabled">
                        <div v-if="qrCode">
                            <div class="mt-4 max-w-xl text-sm text-gray-600">
                                <p class="font-semibold">
                                    Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.
                                </p>
                            </div>

                            <div class="mt-4 dark:p-4 dark:w-56 dark:bg-white" v-html="qrCode">
                            </div>
                        </div>

                        <div v-if="recoveryCodes.length > 0">
                            <div class="mt-4 max-w-xl text-sm text-gray-600">
                                <p class="font-semibold">
                                    Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.
                                </p>
                            </div>

                            <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                                <div v-for="code in recoveryCodes" :key="code">
                                    {{ code }}
                                </div>
                            </div>
                        </div>
                    </div>
                </v-card-text>
               <v-card-actions>
                   <div class="mt-5">
                       <v-spacer/>
                       <div v-if="! twoFactorEnabled">
                           <v-btn  color="primary" @click="enableTwoFactorAuthentication"
                                  :class="{ 'opacity-25': enabling }" :disabled="enabling"
                           >
                               Enable
                           </v-btn>
                       </div>

                       <div v-else>
                           <v-btn color="primary" @click="regenerateRecoveryCodes" v-if="recoveryCodes.length > 0">
                               Regenerate Recovery Codes
                           </v-btn>

                           <v-btn color="secondary" @click="showRecoveryCodes" v-if="recoveryCodes.length === 0">
                               Show Recovery Codes
                           </v-btn>
                           <v-btn color="error" @click="disableTwoFactorAuthentication"
                                  :class="{ 'opacity-25': disabling }"
                                  :disabled="disabling"
                           >
                               Disable
                           </v-btn>

                       </div>
                   </div>
               </v-card-actions>
           </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name:'TwoFactorAuthentication',
        components: {
        },

        data() {
            return {
                enabling: false,
                disabling: false,

                qrCode: null,
                recoveryCodes: [],
            }
        },

        methods: {
            enableTwoFactorAuthentication() {
                this.enabling = true

                this.$inertia.post('/user/two-factor-authentication', {}, {
                    preserveScroll: true,
                    onSuccess: () => Promise.all([
                        this.showQrCode(),
                        this.showRecoveryCodes(),
                        this.route('user.confirm-password'),
                    ]),
                    onFinish: () => (this.enabling = false),
                })
            },

            showQrCode() {
                return axios.get('/user/two-factor-qr-code')
                        .then(response => {
                            this.qrCode = response.data.svg
                        })
            },

            showRecoveryCodes() {
                return axios.get('/user/two-factor-recovery-codes')
                        .then(response => {
                            this.recoveryCodes = response.data
                        })
            },

            regenerateRecoveryCodes() {
                axios.post('/user/two-factor-recovery-codes')
                        .then(response => {
                            this.showRecoveryCodes()
                        })
            },

            disableTwoFactorAuthentication() {
                this.disabling = true

                this.$inertia.delete('/user/two-factor-authentication', {
                    preserveScroll: true,
                    onSuccess: () => (this.disabling = false),
                })
            },
        },

        computed: {
            twoFactorEnabled() {
                return ! this.enabling && this.$page.props.user.two_factor_enabled
            }
        }
    }
</script>
