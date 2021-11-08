<template>
    <v-card color="grey lighten-4">
        <enrollment-form/>
    </v-card>
</template>

<script>
import EnrollmentForm from "./Student/EnrollmentForm";
import AcademicForm from "./Student/AcademicForm";
export default {
    name: "EnrollmentInformation",
    components: {AcademicForm, EnrollmentForm}
}
</script>

<style scoped>

</style>
