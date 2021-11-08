<template>
    <main-layout>
        <to-confirm-registration/>
    </main-layout>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout";
import OnProcessRegistration from "../../../../Components/Tables/Registration/OnProcessRegistration";
import ToConfirmRegistration from "../../../../Components/Tables/Registration/ToConfirmRegistration";

export default {
    name: "ToConfirm",
    components: {ToConfirmRegistration, MainLayout}
}
</script>

<style scoped>

</style>
