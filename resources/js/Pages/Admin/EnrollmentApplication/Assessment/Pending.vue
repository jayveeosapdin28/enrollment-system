<template>
    <main-layout>
        <pending-assessment-table class="my-4"/>
    </main-layout>
</template>

<script>
import PendingAssessmentTable from "../../../../Components/Tables/Assessment/PendingAssessmentTable";
import MainLayout from "../../../../Layouts/MainLayout";
export default {
    name: "Pending",
    components: {MainLayout, PendingAssessmentTable}
}
</script>

<style scoped>

</style>
