<template>
 <main-layout>
<!--     <div  class="title font-weight-bold my-4 block" v-text="'Pending Student'"></div>-->
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

