<template>
<main-layout>
    <pending-assessment-table class="my-4"/>
    <processed-assessment-table/>
</main-layout>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout";
import PendingAssessmentTable from "../../../Components/Tables/Assessment/PendingAssessmentTable";
import ProcessedAssessmentTable from "../../../Components/Tables/Assessment/ProcessedAssessmentTable";

export default {
    name: "StudentAssessment",
    components: {ProcessedAssessmentTable, PendingAssessmentTable, MainLayout}
}
</script>

<style scoped>

</style>
