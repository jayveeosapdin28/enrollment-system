<template>
    <v-card  color="grey lighten-4">
        <personal-form/>
        <v-divider class="mx-4"/>
        <contact-form/>
        <v-divider class="mx-4"/>
        <address-form/>
        <v-divider class="mx-4"/>
        <educational-background/>
        <v-divider class="mx-4"/>
        <family-form/>
        <v-divider class="mx-4"/>
        <other-information-form/>
        <v-divider class="mx-4"/>
        <signature-pad/>
    </v-card>
</template>

<script>
import StudentLayout from "../../Layouts/MainLayout";
import PersonalForm from "./Student/PersonalForm";
import ContactForm from "./Student/ContactsForm";
import AddressForm from "./Student/AddressForm";
import EducationalBackground from "./Student/EducationalBackground";
import FamilyForm from "./Student/FamilyForm";
import OtherInformationForm from "./Student/OtherInformationForm";
import {mapGetters} from "vuex";
import SignaturePad from "./Student/SignaturePad";
export default {
    name: "ProfileInformation",
    components: {
        SignaturePad,
        OtherInformationForm,
        FamilyForm, EducationalBackground, AddressForm, ContactForm, PersonalForm, StudentLayout},
}
</script>

<style scoped>

</style>
