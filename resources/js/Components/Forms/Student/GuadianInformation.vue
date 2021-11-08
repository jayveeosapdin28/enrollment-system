<template>
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet
                class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Guardian Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Your valid contacts that we will contact you.</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12">
            <v-form v-model="valid">
                <v-container>
                    <v-row>
                        <v-col
                            cols="12"
                            md="3"
                        >
                            <v-text-field
                                v-model="item.EMAIL1"
                                :rules="fieldRules"
                                label="Email"
                                required
                                @update:model-value="setEmail($event)"
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="3"
                        >
                            <v-text-field
                                v-model="item.PHONE1"
                                :rules="fieldRules"
                                label="Phone Number"
                                required
                                @update:model-value="setPhone($event)"
                            ></v-text-field>
                        </v-col>

                    </v-row>
                </v-container>
            </v-form>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
name: "GuardianForm",
    data:() =>({
        valid: false,
        fieldRules: [
            v => !!v || 'This field is required',
        ],

    }),
    computed:{
        ...mapGetters("ContactInformationSingle",[ "formErrors","item"]),
    },
    methods:{
        //Contact Information
        ...mapActions("ContactInformationSingle",[
            "setEmail",
            "setPhone",
        ]),

    }
}
</script>

<style scoped>

</style>
