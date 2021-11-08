<template>
 <main-layout :app="this">
     <enrollment-information class="mb-8"/>
     <enrollment-table/>
 </main-layout>
</template>

<script>
import EnrollmentInformation from "../../../Components/Forms/EnrollmentInformation";
import EnrollmentTable from "../../../Components/Tables/EnrollmentTable";
import MainLayout from "../../../Layouts/MainLayout";
export default {
    name: "Index",
    components: {MainLayout, EnrollmentTable, EnrollmentInformation},
    data:() =>({
        title: 'Edit Information',
        valid: false,

    }),
}
</script>

<style scoped>

</style>
