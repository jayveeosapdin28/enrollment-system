<template>
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Browser Sessions'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic"> Manage and logout your active sessions on other browsers and devices.</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12" class="pa-3">
           <v-card>
               <v-card-title>
                   <p class="subtitle-1">
                       If necessary, you may logout of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.
                   </p>
               </v-card-title>
               <v-card-text  v-if="sessions.length > 0">
                   <v-row justify="start" align="center" v-for="(session, i) in sessions" :key="i">
                       <div style="height: 60px; width: 60px">
                           <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"  class="w-5 h-5" v-if="session.agent.is_desktop">
                               <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                           </svg>

                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-gray-500" v-else>
                               <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                           </svg>
                       </div>

                       <div class="ml-3">
                           <div class="text-sm text-gray-600">
                               {{ session.agent.platform }} - {{ session.agent.browser }}
                           </div>

                           <div>
                               <div class="text-xs text-gray-500">
                                   {{ session.ip_address }},

                                   <span class="text-green-500 font-semibold" v-if="session.is_current_device">This device</span>
                                   <span v-else>Last active {{ session.last_active }}</span>
                               </div>
                           </div>
                       </div>
                   </v-row>
               </v-card-text>
               <v-card-actions>
                   <v-spacer/>
                   <v-btn v-if="form.recentlySuccessful" text>
                       Done.
                   </v-btn>
                   <v-btn color="primary" @click="confirmLogout">
                       Logout Other Sessions
                   </v-btn>
               </v-card-actions>
           </v-card>
        </v-col>
        <v-dialog v-model="confirmingLogout" max-width="400px" persistent>
            <v-card>
                <v-card-title class="h4">Logout Other Browser Sessions?</v-card-title>
                <v-card-text>
                    Please enter your password to confirm you would like to logout of your other browser sessions across all of your devices.
                    <v-row>
                        <v-col>
                            <v-text-field type="password" class="mt-1 block w-3/4"
                                       ref="password"
                                          label="Password"
                                       v-model="form.password"
                                       @keyup.enter.native="logoutOtherBrowserSessions" />

                            <span color="error">
                                {{form.errors.password}}
                            </span>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn  color="error" @click="closeModal">
                        Nevermind
                    </v-btn>
                    <v-btn  color="primary"  @click="logoutOtherBrowserSessions" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Logout All Sessions
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        name: 'LogoutOtherSession',
        props: ['sessions'],

        components: {

        },

        data() {
            return {
                confirmingLogout: false,

                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            confirmLogout() {
                this.confirmingLogout = true

                setTimeout(() => this.$refs.password.focus(), 250)
            },

            logoutOtherBrowserSessions() {
                this.form.delete(route('other-browser-sessions.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                    onError: () => this.$refs.password.focus(),
                    onFinish: () => this.form.reset(),
                })
            },

            closeModal() {
                this.confirmingLogout = false

                this.form.reset()
            },
        },
    }
</script>
