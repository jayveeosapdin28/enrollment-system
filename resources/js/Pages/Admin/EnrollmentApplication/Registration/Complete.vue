<template>
    <main-layout>
      <complete-registration/>
    </main-layout>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout";
import CompleteRegistration from "../../../../Components/Tables/Registration/CompleteRegistration";

export default {
    name: "Complete",
    components: {CompleteRegistration, MainLayout}
}
</script>

<style scoped>

</style>
