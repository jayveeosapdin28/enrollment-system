<template>
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Educational Background'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Set of all the formal and informal education that you have achieved</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12" class="pa-3">
            <v-card  :loading="loading">
                <template slot="progress">
                    <v-progress-linear
                        color="primary"
                        height="5"
                        indeterminate
                    ></v-progress-linear>
                </template>
               <form @submit.prevent="submit">
                   <v-card-text>
                       <v-container>
                           <v-row>
                               <v-col
                                   cols="12"
                                   md="8"
                               >
                                   <v-text-field
                                       v-model="item.elemschool"
                                       label="Elementary / Primary"
                                       :error-messages="formErrors.elemschool"
                                   ></v-text-field>
                               </v-col>

                               <v-col
                                   cols="12"
                                   md="4"
                               >
                                   <v-text-field
                                       v-model="item.elemsy"
                                       label="Year Graduated"
                                       :error-messages="formErrors.elemsy"
                                   ></v-text-field>
                               </v-col>

                           </v-row>
                           <v-row>
                               <v-col
                                   cols="12"
                                   md="8"
                               >
                                   <v-text-field
                                       v-model="item.hsschool"
                                       label="High School / Secondary"
                                       :error-messages="formErrors.hsschool"
                                   ></v-text-field>
                               </v-col>

                               <v-col
                                   cols="12"
                                   md="4"
                               >
                                   <v-text-field
                                       v-model="item.hssy"
                                       label="Year Graduated"
                                       :error-messages="formErrors.hssy"
                                   ></v-text-field>
                               </v-col>

                           </v-row>
                           <v-row>
                               <v-col
                                   cols="12"
                                   md="8"
                               >
                                   <v-text-field
                                       v-model="item.college"
                                       label="College / Tertiary / Vocational"
                                       :error-messages="formErrors.college"
                                   ></v-text-field>
                               </v-col>

                               <v-col
                                   cols="12"
                                   md="4"
                               >
                                   <v-text-field
                                       v-model="item.collegesy"
                                       label="Year Graduated"
                                       :error-messages="formErrors.collegesy"
                                   ></v-text-field>
                               </v-col>

                           </v-row>
                       </v-container>
                   </v-card-text>
                   <v-card-actions>
                       <v-spacer/>
                       <v-btn  :disabled="loading" type="submit" color="primary">
                           {{ loading ?  'Please wait...' : 'Save Changes'}}
                       </v-btn>
                   </v-card-actions>
               </form>
           </v-card>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
name: "EducationalBackground",
    data:() =>({
        valid: false,
        fieldRules: [
            v => !!v || 'This field is required',
        ],

    }),
    computed:{
        ...mapGetters("EducationalBackgroundSingle",[ "formErrors","item","errorMessage","loading"]),
    },
    mounted() {
        this.findData(this.$page.props.user.id)
    },
    methods:{
        //Contact Information
        ...mapActions("EducationalBackgroundSingle",[
            "setElementaryName",
            "setElementaryGraduate",
            "setHighSchoolName",
            "setHighSchoolGraduate",
            "setCollegeName",
            "setCollegeGraduate",
            "setFormErrors",
            "storeData",
            "updateData",
            "findData",
        ]),

        async submit() {
            this.setFormErrors({});
            if (!this.item.id) {
                this.storeData()
                    .then((data) => {
                        this.$toast.success("Successfully saved.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                    });
            } else {
                this.updateData()
                    .then((data) => {
                        this.$toast.success("Successfully updated.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                    });
            }
        }

    }
}
</script>

<style scoped>

</style>
