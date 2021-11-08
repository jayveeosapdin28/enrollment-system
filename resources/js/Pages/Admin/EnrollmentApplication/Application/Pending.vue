<template>
    <main-layout>
      <issue-id-number/>
    </main-layout>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout";
import IssueIdNumber from "../../../../Components/Tables/Application/IssueIDNumber";

export default {
    name: "Pending",
    components: {IssueIdNumber, MainLayout}
}
</script>

<style scoped>

</style>
