<template>
    <main-layout :app="this">
        <profile-information/>
    </main-layout>
</template>

<script>
import StudentForm from "../../../Components/Forms/ProfileInformation";
import ProfileInformation from "../../../Components/Forms/ProfileInformation";
import MainLayout from "../../../Layouts/MainLayout";
export default {
    name: "create",
    components: {MainLayout, ProfileInformation, StudentForm},
    data:() =>({
        title: 'Edit Information',
        valid: false,

    }),
}
</script>

<style scoped>

</style>
