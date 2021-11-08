<template>
    <v-app id="inspire">
        <v-main>
            <v-container
                class="fill-height"
                fluid
            >
                <v-row
                    justify="center"
                >
                    <v-card color="transparent" class="elevation-0">
                        <v-card-text>
                            <v-card-text>
                                <v-row justify="center" align="center">
                                    <v-spacer/>
                                    <v-img :width="5" :src="'/img/logo_colored.png'"/>
                                    <v-spacer/>
                                </v-row>
                            </v-card-text>
                            <v-card-text>
                                <v-row justify="center" align="center">
                                    <v-col>
                                        <p class="display-2 block font-weight-bold text--white ">Mindoro State University</p>
                                        <p class="display-1 block font-weight-normal text-center text--white">Main Campus</p>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer/>
                            <v-btn :href="route('register')" class="ma-2" color="neutral">Register</v-btn>
                            <v-btn :href="route('login')" class="ma-2" color="primary">Login</v-btn>
                            <v-spacer/>
                        </v-card-actions>
                    </v-card>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>

</style>

<script>
export default {
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    }
}
</script>
