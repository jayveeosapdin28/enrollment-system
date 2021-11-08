<template>
    <main-layout>
        <student-medical-form/>
    </main-layout>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout";
import MedicalRecords from "../../../../Components/Tables/Medical/MedicalRecords";
import StudentMedicalForm from "../../../../Components/Forms/Clinic/StudentMedicalForm";

export default {
    name: "Pending",
    components: {StudentMedicalForm, MainLayout}
}
</script>

<style scoped>

</style>
