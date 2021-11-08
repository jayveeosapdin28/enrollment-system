<template>
 <main-layout>
    <pending-student-table/>
 </main-layout>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout";
import PendingStudentTable from "../../../Components/Tables/PendingStudentTable";
export default {
    name: "Index",
    components: {PendingStudentTable, MainLayout}
}
</script>

<style scoped>

</style>
