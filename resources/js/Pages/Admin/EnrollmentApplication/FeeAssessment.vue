<template>
    <main-layout>
        <info-card
            :student="application"
            :show-assessment-info="true"
            :subject="subject"
            class="mb-6"
        />
        <student-fee-table
            :subject="subject"
            :application="application"
        />
    </main-layout>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout";
import InfoCard from "../../../Components/Widgets/InfoCard";
import StudentFeeTable from "../../../Components/Tables/StudentFeeTable";

export default {
    props: ['application'],
    name: "FeeAssessment",
    components: {StudentFeeTable, InfoCard, MainLayout},
    computed: {
        subject() {
           if(this.application.subject_enrolled){
               var subject = this.application.subject_enrolled;
               return {
                   unitsCount: subject.reduce((accumulator, current) =>
                       accumulator + parseInt(current.subunit), 0),
                   laboratoriesCount: subject.reduce((accumulator, current) =>
                       accumulator + (current.subfee == "lab fee" ? 1 : 0), 0),
                   comlabCount: subject.reduce((accumulator, current) =>
                       accumulator + (current.subfee == "comp fee" ? 1 : 0), 0),
                   subjectCount: subject.length
               }
           }
           return null;
        },
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
