<template>
<main-layout>
    <info-card :student="student" class="my-4"/>
    <enrolled-subjects-table :filter="false" :student="student"/>
    <v-card v-if="student.step > 1 && student.step < 4" class="my-4">
        <v-data-table
            v-model="selected"
            :headers="subjectColumn"
            :items="subjectList"
            item-key="id"
            show-select
            :loading="subjectLoading"
            loading-text="Loading... Please wait"
            hide-default-footer
            class="elevation-1 my-4 pt-6"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Subjects</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-col
                        cols="3"
                        md="3"
                    >
                        <v-select
                            :items="yearlevels"
                            item-text="text"
                            item-value="value"
                            name="year_level"
                            v-model="subjectServerQuery.year"
                            @change="setSubjectQuery({name: 'query',value: ''})"
                            label="Filter by year level"
                        />
                    </v-col>
                    <v-col
                        cols="3"
                        md="3"
                    >
                        <v-select
                            :items="semesters"
                            item-text="text"
                            item-value="id"
                            v-model="subjectServerQuery.semester"
                            name="semester"
                            @change="setSubjectQuery({name: 'query',value: ''})"
                            label="Filter by semester"
                        />
                    </v-col>
                </v-toolbar>
            </template>
            <template v-if="selected_subjects.length > 0" slot="body.append">
                <tr>
                    <th :colspan="subjectColumn.length " class="justify-content-end align-content-end"></th>
                    <th> <v-btn
                        small
                        color="success"
                        @click="submit"
                    >
                        ENROLL
                    </v-btn></th>
                </tr>
            </template>
        </v-data-table>
        <v-pagination
            v-model="subjectPagination.currentPage"
            :total-visible="6"
            circle
            :length="subjectPagination.lastPage"
            @input="setSubjectQuery({ name: 'page', value: subjectPagination.currentPage })"
        ></v-pagination>
    </v-card>
</main-layout>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout";
import { getSem,getYearLevel,yearlevels,semesters } from "../../../Utilities/Helper"
import InfoCard from "../../../Components/Widgets/InfoCard";
import {mapActions, mapGetters} from "vuex";
import EnrolledSubjectsTable from "../../../Components/Tables/EnrolledSubjectsTable";
export default {
    props:['student'],
    name: "EnrollSubject",
    components: {EnrolledSubjectsTable, InfoCard, MainLayout},
    data: () => ({
        selected: [],
        yearlevels: yearlevels(),
        semesters: semesters(),
    }),
    watch:{
      selected(){
         this.setSelectedSubject(this.selected.map(x => x.id))
      }
    },
    computed:{
      ...mapGetters("EnrollSubjectIndex",{subjectList:"tableData"}),
      ...mapGetters("EnrollSubjectIndex",{subjectColumn:"tableColumns"}),
      ...mapGetters("EnrollSubjectIndex",{subjectServerQuery:"serverQuery"}),
      ...mapGetters("EnrollSubjectIndex",{subjectLoading:"loading"}),
      ...mapGetters("EnrollSubjectIndex",{subjectPagination:"pagination"}),
      ...mapGetters("EnrollSubjectSingle",["selected_subjects","errorMessage"]),

    },
    methods:{
        ...mapActions("EnrollSubjectIndex",{fetchSubjects: "fetchData"}),
        ...mapActions("EnrollSubjectIndex",{setSubjectQuery: "setServerQuery"}),
        ...mapActions("EnrollSubjectIndex",["setProgram","setYear","setSemester","resetState"]),
        ...mapActions("EnrollSubjectSingle",{enrollSubjects: "storeData"}),
        ...mapActions("EnrollSubjectSingle",{setSelectedSubject: "setSelectedSubject"}),
        getYearLevel(year){
            return getYearLevel(year)
        },
        getSem(sem){
            return getSem(sem)
        },
        submit(){
            this.enrollSubjects(this.student.id)
                .then((data) => {
                    this.setSelectedSubject([]);
                    this.selected = [];
                    this.$root.$refs.enrolledSubjects.fetchSubjects();
                    this.$toast.success("Successfully saved.", this.$toastOption);
                })
                .catch((error) => {
                    this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                });
        }
    },
    async mounted(){
        await this.setProgram(this.student.program.id)
        await this.setYear(this.student.yearlevel)
        await this.setSemester(this.student.studsem)
        await this.setSubjectQuery({name: 'query',value: ''});
    }

}
</script>

<style scoped>

</style>
