<template>
    <v-card color="grey lighten-4">
        <academic-form/>
    </v-card>
</template>

<script>

import AcademicForm from "./Student/AcademicForm";
import ScholarshipForm from "./Student/ScholarshipForm";

export default {
    name: "AcademicInformation",
    components: {ScholarshipForm, AcademicForm}
}
</script>

<style scoped>

</style>
