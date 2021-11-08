<template>
    <main-layout :app="this">
        <academic-information/>
    </main-layout>
</template>

<script>

import AcademicInformation from "../../../Components/Forms/AcademicInformation";
import MainLayout from "../../../Layouts/MainLayout";
export default {
    name: "Index",
    components: {MainLayout, AcademicInformation},
    data:() =>({
        title: 'Edit Information',
        valid: false,

    }),
}
</script>

<style scoped>

</style>
