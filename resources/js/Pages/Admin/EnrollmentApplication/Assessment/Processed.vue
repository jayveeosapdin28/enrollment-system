<template>
    <main-layout>
        <processed-assessment-table class="my-4"/>
    </main-layout>
</template>

<script>
import ProcessedAssessmentTable from "../../../../Components/Tables/Assessment/ProcessedAssessmentTable";
import MainLayout from "../../../../Layouts/MainLayout";
export default {
    name: "Processed",
    components: {MainLayout, ProcessedAssessmentTable}
}
</script>

<style scoped>

</style>
