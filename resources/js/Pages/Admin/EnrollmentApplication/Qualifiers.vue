<template>
 <main-layout>
    <qualifiers-table/>
 </main-layout>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout";
import QualifiersTable from "../../../Components/Tables/QualifiersTable";
export default {
    name: "Index",
    components: {QualifiersTable, MainLayout}
}
</script>

<style scoped>

</style>
