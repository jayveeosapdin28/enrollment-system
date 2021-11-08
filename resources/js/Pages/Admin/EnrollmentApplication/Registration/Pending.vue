<template>
    <main-layout>
      <pending-registration/>
    </main-layout>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout";
import PendingRegistration from "../../../../Components/Tables/Registration/PendingRegistration";

export default {
    name: "Pending",
    components: {PendingRegistration, MainLayout}
}
</script>

<style scoped>

</style>
