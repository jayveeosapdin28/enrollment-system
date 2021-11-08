<template>
    <v-card class="my-4">
        <v-card-text>
            <v-data-table
                :headers="enrolledSubjectColumn"
                :items="enrolledSubjectList"
                item-key="id"
                :loading="enrolledSubjectLoading"
                disable-pagination
                loading-text="Loading... Please wait"
                hide-default-footer
                class=" my-4 pt-6"
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title>Enrolled Subjects</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <div v-if="filter">
                            <v-col
                                cols="3"
                                md="3"
                            >
                                <v-select
                                    :items="yearlevels"
                                    item-text="text"
                                    item-value="value"
                                    name="year_level"
                                    v-model="enrolledSubjectServerQuery.year"
                                    @change="setEnrolledSubjectQuery({name: 'query',value: ''})"
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
                                    v-model="enrolledSubjectServerQuery.semester"
                                    name="semester"
                                    @change="setEnrolledSubjectQuery({name: 'query',value: ''})"
                                    label="Filter by semester"
                                />
                            </v-col>
                        </div>
                        <div v-if="enrolledSubjectList.length > 0" class="text-right">
                            <v-btn small color="primary"
                                   @click="print"
                            >
                                <v-icon small class="mr-2">mdi-printer</v-icon>
                                Print
                            </v-btn>
                        </div>
                    </v-toolbar>
                </template>
                <template v-slot:item.status="{ item }">
                    <v-btn
                        :color="item.status == 'DROPPED' ? 'error' : 'success'"
                        small
                        text
                        class="ma-2"
                    >
                        {{item.status}}
                    </v-btn>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        v-if="item.enrollmen_application.step == 3 || item.enrollmen_application.step == 2"
                        color="error"
                        small
                        @click="handleDelete(item.id)"
                    >
                        Delete
                    </v-btn>
                    <v-btn
                        v-if="item.status != 'DROPPED' && (item.enrollmen_application.step == 3 || item.enrollmen_application.step == 2)"
                        color="warning"
                        small
                        @click="handleUpdate(item.id)"
                    >
                        Drop
                    </v-btn>
                </template>
            </v-data-table>
        </v-card-text>
        <v-card-text v-if="totalSubjects > 0">
            <p class="subtitle-1 font-weight-bold my-1  block">Total Subject/s: {{totalSubjects}}</p>
            <p class="subtitle-1 font-weight-bold my-1  block">Total Unit/s: {{totalUnits}}</p>
            <p class="subtitle-1 font-weight-bold my-1  block">Total Enrolled Subject/s: {{totalEnrolled}}</p>
            <p class="subtitle-1 font-weight-bold my-1  block">Total Dropped Subject/s: {{totalDropped}}</p>
        </v-card-text>
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {semesters, yearlevels} from "../../Utilities/Helper";
import {printCOR} from '../../Utilities/PrintLayouts/CertificateOfEnrollment'

export default {
    name: "EnrolledSubjectsTable",
    props:['student','filter'],
    data: () => ({
        selected: [],
        yearlevels: yearlevels(),
        semesters: semesters(),
    }),
    computed:{
        totalUnits(){
            if (this.enrolledSubjectList){
                return this.enrolledSubjectList.reduce((accumulator, current) =>
                    accumulator + parseInt(current.status == 'ENROLLED' ? current.subject.subunit  : 0), 0);
            }
            return 0;
        },
        totalDropped(){
            if (this.enrolledSubjectList){
                return this.enrolledSubjectList.reduce((accumulator, current) =>
                    accumulator + parseInt(current.status == 'DROPPED' ? 1  : 0), 0);
            }
            return 0;
        },
        totalEnrolled(){
            if (this.enrolledSubjectList){
                return this.enrolledSubjectList.reduce((accumulator, current) =>
                    accumulator + parseInt(current.status == 'ENROLLED' ? 1  : 0), 0);
            }
            return 0;
        },
        totalSubjects(){
            if (this.enrolledSubjectList){
                return this.enrolledSubjectList.length;
            }
            return 0;
        },

        ...mapGetters("EnrolledSubjectIndex",{enrolledSubjectList:"tableData"}),
        ...mapGetters("EnrolledSubjectIndex",{enrolledSubjectColumn:"tableColumns"}),
        ...mapGetters("EnrolledSubjectIndex",{enrolledSubjectServerQuery:"serverQuery"}),
        ...mapGetters("EnrolledSubjectIndex",{enrolledSubjectLoading:"loading"}),
        ...mapGetters("EnrolledSubjectIndex",{enrolledSubjectPagination:"pagination"}),
        ...mapGetters("EnrolledSubjectSingle",["errorMessage"]),
    },
    methods:{

        ...mapActions("EnrolledSubjectIndex",{fetchEnrolledSubjects: "fetchData"}),
        ...mapActions("EnrolledSubjectIndex",{setEnrolledSubjectQuery: "setServerQuery"}),
        ...mapActions("EnrolledSubjectIndex",["setProgram","setYear","setSemester","resetState","setAppID"]),
        ...mapActions("EnrolledSubjectSingle",["storeData","updateData","setSelectedID"]),
        ...mapActions("EnrolledSubjectIndex",["destroyData"]),

        handleDelete(id){
            this.destroyData(id);
            this.fetchSubjects()
        },
        handleUpdate(id){
            this.updateData(id)
                .then((data) => {
                    this.$toast.success("Subject successfully dropped.", this.$toastOption);
                    this.fetchSubjects()
                })
                .catch((error) => {
                    this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                });
        },
        print(){
            var schoolInfo = {
                name: 'MINDORO STATE UNIVERSITY',
                adddress: 'Main Campus'
            }
            // console.log('stud',this.student);
            // console.log('enroll',this.enrolledSubjectList);
            // console.log('info',schoolInfo);
            printCOR(this.student,this.enrolledSubjectList,schoolInfo);
        },
        async fetchSubjects(){
            await this.setProgram(this.student.program.id)
            await this.setAppID(this.student.id)
            await this.setProgram(this.student.program.id)
            await this.setYear(this.student.yearlevel)
            await this.setSemester(this.student.studsem)
            await this.setEnrolledSubjectQuery({name: 'query',value: ''});
        }
    },
    mounted(){
        this.filter = false;
        this.fetchSubjects()
        this.$root.$refs.enrolledSubjects = this;
    }
}
</script>

<style scoped>

</style>
