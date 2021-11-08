<template>
    <student-layout :app="this">
        <scholarship-information/>
    </student-layout>
</template>

<script>
import StudentLayout from "../../../Layouts/MainLayout";
import ScholarshipInformation from "../../../Components/Forms/ScholarshipInformation";
export default {
name: "Index",
    components: {ScholarshipInformation, StudentLayout},
    data:() =>({
        title: 'Edit Information',
        valid: false,

    }),
}
</script>

<style scoped>

</style>
