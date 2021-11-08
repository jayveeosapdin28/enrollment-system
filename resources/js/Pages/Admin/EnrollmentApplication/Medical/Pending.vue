<template>
    <main-layout>
    <medical-records/>
    </main-layout>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout";
import MedicalRecords from "../../../../Components/Tables/Medical/MedicalRecords";

export default {
    name: "Pending",
    components: {MedicalRecords, MainLayout}
}
</script>

<style scoped>

</style>
