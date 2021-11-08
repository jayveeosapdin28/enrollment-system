<template>
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Enrollment Details'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Please provide valid information. You can only cancel application with pending status.</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12" class="pa-3">
           <v-card>
               <form @submit.prevent="submit">
                   <v-card-text>
                       <v-container>
                           <v-row>
                               <v-col >
                                   <v-radio-group
                                       v-model="item.enrollment_status"
                                       row
                                       :error-messages="formErrors.enrollment_status"
                                   >
                                       <v-radio
                                           label="New"
                                           value="NEW"
                                       ></v-radio>
                                       <v-radio
                                           label="Transferee"
                                           value="TRANSFEREE"
                                       ></v-radio>
                                       <v-radio
                                           label="Old"
                                           value="OLD"
                                       ></v-radio>
                                   </v-radio-group>
                               </v-col>
                           </v-row>
                           <v-row>
                               <v-col v-if="item.enrollment_status == 'OLD'"   cols="12"
                                      md="6">
                                   <v-text-field
                                       v-model="item.idnumber"
                                       label="Student ID Number"
                                       :error-messages="formErrors.idnumber"
                                   ></v-text-field>
                               </v-col>
                           </v-row>
                           <v-row>
                               <v-col
                                   cols="12"
                                   md="5"
                               >
                                   <v-select
                                       :items="campuses"
                                       item-text="text"
                                       item-value="id"
                                       v-model="item.campcode"
                                       :error-messages="formErrors.campcode"
                                       name="Campus"
                                       label="Campus"
                                   />
                               </v-col>
                               <v-col
                                   cols="12"
                                   md="7"
                               >
                                   <v-select
                                       :items="allPrograms"
                                       v-model="item.corid"
                                       item-value="id"
                                       item-text="name"
                                       name="program"
                                       label="Program"
                                       single-line
                                       :error-messages="formErrors.corid"
                                   />
                               </v-col>
                           </v-row>
                           <v-row>
                               <v-col
                                   cols="12"
                                   md="3"
                               >
                                   <v-select
                                       :items="yearLevel"
                                       item-text="text"
                                       item-value="value"
                                       v-model="item.yearlevel"
                                       :error-messages="formErrors.yearlevel"
                                       name="year_level"
                                       label="Year Level"
                                   />
                               </v-col>
                               <v-col
                                   cols="12"
                                   md="3"
                               >
                                   <v-select
                                       :items="section"
                                       item-text="text"
                                       item-value="id"
                                       v-model="item.studsection"
                                       :error-messages="formErrors.studsection"
                                       name="section"
                                       label="Section"
                                   />
                               </v-col>
                               <v-col
                                   cols="12"
                                   md="3"
                               >
                                   <v-select
                                       :items="semester"
                                       item-text="text"
                                       item-value="id"
                                       v-model="item.studsem"
                                       :error-messages="formErrors.studsem"
                                       name="semester"
                                       label="Semester"
                                   />
                               </v-col>
                               <v-col
                                   cols="12"
                                   md="3"
                               >
                                   <v-select
                                       :items="academic_year"
                                       v-model="item.cureffec"
                                       name="academic_year"
                                       label="Academic Year"
                                       :error-messages="formErrors.cureffec"
                                   />
                               </v-col>
                           </v-row>
                       </v-container>
                   </v-card-text>
                   <v-card-actions>
                       <v-spacer/>
                       <v-btn  :disabled="loading" type="submit" color="primary">
                           {{ loading ?  'Please wait...' : 'Submit new application'}}
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
name: "EnrollmentForm",
    data:() =>({
        valid: false,
        yearLevel:[
            { value: '1', text: 'First Year'},
            { value: '2', text: 'Second Year'},
            { value: '3', text: 'Third Year'},
            { value: '4', text: 'Fourth Year'},
            { value: '5', text: 'Fifth Year'},
        ],
        campuses:[
            { id: 'MMC', text: 'Main Campus (Alcate, Victoria)'},
            // { id: 'MCC', text: 'Calapan Campus (Misipit, Capalan City)'},
            // { id: 'MBC', text: 'Bongabong Campus (Labasan, Bongabong)'}
        ],
        semester:[
            { id: '1', text: 'First Semester'},
            { id: '2', text: 'Second Semester'},
            { id: '3', text: 'Summer'}
        ],
        academic_year: ['2021-2022'],
        section:[

        ],
    }),
    mounted(){
        this.fetchPrograms();
    },
    computed:{
        ...mapGetters("EnrollmentInformationSingle",["formErrors", "item","errorMessage","loading"]),
        ...mapGetters("CourseInformationIndex",{ allPrograms:"allData"}),
    },
    methods:{
        //Contact Information
        ...mapActions("EnrollmentInformationSingle",[
            "setCampus",
            "setEnrollmentStatus",
            "setCourse",
            "setYearLevel",
            "setSection",
            "setIDNumber",
            "setSemester",
            "setAcademicYear",
            "storeData",
            "updateData",
            "findData",
            "setFormErrors",
            "resetState"
        ]),
        ...mapActions("CourseInformationIndex",{fetchPrograms :"fetchAllData"}),
        async submit() {
            this.setFormErrors({});
            if (!this.item.id) {
                this.storeData()
                    .then((data) => {
                        this.$toast.success("Successfully saved.", this.$toastOption);
                        this.$root.$refs.enrollmentApplicationTable.fetchData();
                        this.resetState();
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                    });
            } else {
                this.updateData()
                    .then((data) => {
                        this.$toast.success("Successfully updated.", this.$toastOption);
                        this.$root.$refs.enrollmentApplicationTable.fetchData();
                        this.resetState();
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
