<template>
    <main-layout>
      <on-process-registration/>
    </main-layout>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout";
import OnProcessRegistration from "../../../../Components/Tables/Registration/OnProcessRegistration";

export default {
    name: "OnProcess",
    components: {OnProcessRegistration, MainLayout}
}
</script>

<style scoped>

</style>
