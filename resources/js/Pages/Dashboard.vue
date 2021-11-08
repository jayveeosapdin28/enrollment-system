<template>
    <main-layout>
        <admin-dashboard v-if="$can('access dashboard')"/>
        <student-dashboard v-if="$role('Student')" />
    </main-layout>
</template>

<script>
import MainLayout from "../Layouts/MainLayout";
import AdminDashboard from "../Components/Dashboard/AdminDashboard";
import StudentDashboard from "../Components/Dashboard/StudentDashboard";

export default {
    components: {
        StudentDashboard,
        AdminDashboard,
        MainLayout,
    },
}
</script>
