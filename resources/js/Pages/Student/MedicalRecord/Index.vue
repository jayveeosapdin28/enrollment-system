<template>
    <main-layout :app="this">
        <medical-information/>
    </main-layout>
</template>

<script>

import MedicalInformation from "../../../Components/Forms/MedicalInformation";
import MainLayout from "../../../Layouts/MainLayout";
export default {
    name: "Index",
    components: {MainLayout, MedicalInformation},
    data:() =>({
        title: 'Edit Information',
        valid: false,

    }),

}
</script>

<style scoped>

</style>
