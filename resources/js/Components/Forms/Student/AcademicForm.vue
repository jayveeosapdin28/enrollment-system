<template>
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Academics Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Your valid contacts that we will contact you.</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12" class="pa-3">
            <v-card>
                <form @submit.prevent="submit">
                    <v-card-text>
                        <v-container>
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
    name: "AcademicForm",
    data:() =>({
        valid: false,
        yearLevel:[
            { value: '1', text: 'FIRST YEAR'},
            { value: '2', text: 'SECOND YEAR'},
            { value: '3', text: 'THIRD YEAR'},
            { value: '4', text: 'FOURTH YEAR'},
            { value: '5', text: 'FIFTH YEAR'},
        ],
        campuses:[
            { id: 'MMC', text: 'MAIN CAMPUS (ALCATE, VICTORIA)'},
            // { id: 'MCC', text: 'CALAPAN CAMPUS (MASIPIT, CAPALAN CITY)'},
            // { id: 'MBC', text: 'BONGABONG CAMPUS (LABASAN, BONGABONG)'}
        ],
        semester:[
            { id: '1', text: 'FIRST SEMESTER'},
            { id: '2', text: 'SECOND SEMESTER'},
            { id: '3', text: 'SUMMER'}
        ],
        academic_year: ['2021-2022'],
        section:[

        ],
    }),
    mounted(){
        this.fetchPrograms();
    },
    computed:{
        ...mapGetters("AcademicInformationSingle",[ "formErrors","item","loading","m"]),
        ...mapGetters("CourseInformationIndex",{ allPrograms:"allData"}),
    },
    methods:{
        //Contact Information
        ...mapActions("AcademicInformationSingle",[
            "setCampus",
            "setCourse",
            "setYearLevel",
            "setSection",
            "setSemester",
            "setAcademicYear",
        ]),
        //Course Information
        ...mapActions("CourseInformationIndex",{fetchPrograms :"fetchAllData"}),
    },
}
</script>

<style scoped>

</style>
