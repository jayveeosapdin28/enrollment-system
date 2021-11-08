<template>
    <v-row no-gutters>
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Personal Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">All information about yourself</p>
            </v-sheet>
        </v-col>
        <v-col md="9" cols="12" class="pa-3">
            <form @submit.prevent="submit">
                <v-card  :loading="loading">
                    <template slot="progress">
                        <v-progress-linear
                            color="primary"
                            height="5"
                            indeterminate
                        ></v-progress-linear>
                    </template>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-text-field
                                        v-model="item.studnam3"
                                        label="First name"
                                        :error-messages="formErrors.studnam3"
                                    ></v-text-field>
                                </v-col>

                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-text-field
                                        v-model="item.studnam2"
                                        label="Middle name"
                                        :error-messages="formErrors.studnam2"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-text-field
                                        v-model="item.studnam1"
                                        label="Last name"
                                        :error-messages="formErrors.studnam1"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-text-field
                                        v-model="item.studnam4"
                                        label="Extension (eq. Jr.,Sr.)"
                                        :error-messages="formErrors.studnam4"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="4"
                                >
                                    <v-select
                                        :items="gender"
                                        item-value="key"
                                        v-model="item.gender"
                                        name="gender"
                                        item-text="label"
                                        :error-messages="formErrors.gender"
                                        label="Gender"
                                    />
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4"
                                >
                                    <v-select
                                        :items="civil_status"
                                        item-value="key"
                                        v-model="item.studcivilstat"
                                        name="civil_status"
                                        item-text="label"
                                        :error-messages="formErrors.studcivilstat"
                                        label="Marital Status"
                                    />
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4"
                                >
                                    <v-text-field
                                        v-model="item.nationality"
                                        label="Nationality"
                                        :error-messages="formErrors.nationality"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-text-field
                                        v-model="item.studbday"
                                        label="Birthday"
                                        type="date"
                                        :error-messages="formErrors.studbday"

                                    ></v-text-field>

                                </v-col>
                                <v-col
                                    cols="12"
                                    md="9"
                                >
                                    <v-select
                                        :items="religions"
                                        item-text="name"
                                        item-value="id"
                                        v-model="item.religion_id"
                                        name="religion"
                                        label="Religion"
                                        :error-messages="formErrors.religion_id"
                                        clearable
                                    />
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn  :disabled="loading" type="submit" color="primary">
                            {{ loading ?  'Please wait...' : 'Save Changes'}}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </form>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "PersonalForm",
    data: () => ({
        title: 'Edit Information',
        valid: false,
        gender: [
            {key: 'MALE', label: 'MALE'},
            {key: 'FEMALE', label: 'FEMALE'}
        ],
        civil_status: [
            {key: 'SINGLE', label: 'SINGLE'},
            {key: 'MARRIED', label: 'MARRIED'},
            {key: 'DIVORCED ', label: 'DIVORCED '},
            {key: 'SEPARATED', label: 'SEPARATED'},
            {key: 'WIDOWED', label: 'WIDOWED'},
        ],
        error: {
            position: "top-right",
            timeout: 3000,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
        },
    }),
    computed: {
        ...mapGetters("PersonalInformationSingle", ["formErrors", "item","errorMessage","loading"]),
        ...mapGetters("ReligionInformationIndex", {religions: "allData"}),
    },
    mounted() {
        this.fetchAllData()
    },
    methods: {
        //Personal Information
        ...mapActions("PersonalInformationSingle", [
            "setItem",
            "setNationality",
            "setReligion",
            "setStudCivilStat",
            "setStudBDay",
            "setStudNam1",
            "setStudNam2",
            "setStudNam3",
            "setStudNam4",
            "setGender",
            "storeData",
            "updateData",
            "resetState",
            "findData",
            "setFormErrors",
        ]),
        //Religion Information
        ...mapActions("ReligionInformationIndex", {fetchReligion: "fetchAllData"}),
        fetchAllData() {
            this.fetchReligion();
            this.findData(this.$page.props.user.id);
        },
        async submit() {
            this.setFormErrors({});
            if(!this.item.id){
                this.storeData()
                    .then((data) => {
                        this.$toast.success("Successfully saved.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                    });
            }
            else{
                this.updateData()
                    .then((data) => {
                        this.$toast.success("Successfully updated.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                    });
            }
        }
    }
}
</script>

<style scoped>

</style>
