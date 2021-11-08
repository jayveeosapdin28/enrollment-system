<template>
    <v-row no-gutters>
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Family Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Let us know you family background for our future reference.</p>
            </v-sheet>
        </v-col>
        <v-col md="9" cols="12" class="pa-3">
            <v-card  :loading="loading">
                <template slot="progress">
                    <v-progress-linear
                        color="primary"
                        height="5"
                        indeterminate
                    ></v-progress-linear>
                </template>
                <form @submit.prevent="submit">
                    <v-card-text>
                        <v-container>
                            <div>
                                <v-row>
                                    <v-col>
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Father's
                                            Information</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.fathnam3"
                                            label="First name"
                                            :error-messages="formErrors.fathnam3"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.fathnam2"
                                            label="Middle name"
                                            :error-messages="formErrors.fathnam2"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.fathnam1"
                                            label="Last name"
                                            :error-messages="formErrors.fathnam1"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.fathnam4"
                                            label="Extension (eq. Jr.,Sr.)"
                                            :error-messages="formErrors.fathnam4"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.fathoccup"
                                            label="Occupation"
                                            :error-messages="formErrors.fathoccup"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </div>
                            <div>
                                <v-row>
                                    <v-col>
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Mother's Maiden
                                            Information</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.mothnam3"
                                            label="First name"
                                            :error-messages="formErrors.mothnam3"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.mothnam2"
                                            label="Middle name"
                                            :error-messages="formErrors.mothnam2"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.mothnam1"
                                            label="Last name"
                                            :error-messages="formErrors.mothnam1"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-text-field
                                            v-model="item.mothoccup"
                                            label="Occupation"
                                            :error-messages="formErrors.mothoccup"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </div>
                            <div>
                                <v-row>
                                    <v-col>
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Guardian's
                                            Information</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.guardian"
                                            label="Full Name"
                                            :error-messages="formErrors.guardian"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.phone2"
                                            label="Phone number"
                                            :error-messages="formErrors.phone2"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.relationship"
                                            label="Relationship"
                                            :error-messages="formErrors.relationship"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="country"
                                            v-model="item.guardian_country"
                                            name="country"
                                            label="Country"
                                            @change="fetchGuardianProvinceData"
                                            :error-messages="formErrors.guardian_country"
                                        />
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="guardianProvinceData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.guardian_province"
                                            name="province"
                                            label="Province"
                                            @change="fetchGuardianCityData"
                                            :error-messages="formErrors.guardian_province"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="guardianCityData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.guardian_city"
                                            name="city/town"
                                            label="City/Town"
                                            @change="fetchGuardianBrgyData"
                                            :error-messages="formErrors.guardian_city"
                                        />
                                    </v-col>

                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="guardianBrgyData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.guardian_barangay"
                                            name="barangay"
                                            label="Barangay"
                                            :error-messages="formErrors.guardian_barangay"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.guardian_street"
                                            label="Street"
                                            :error-messages="formErrors.guardian_street"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.guardian_house"
                                            label="House No."
                                            :error-messages="formErrors.guardian_house"
                                        ></v-text-field>
                                    </v-col>

                                </v-row>
                            </div>
                            <div>
                                <v-row>
                                    <v-col>
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Other Information</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-select
                                            :items="parentStatus"
                                            v-model="item.parentstatus"
                                            name="parent_status"
                                            label="Parent Status"
                                            :error-messages="formErrors.parentstatus"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-select
                                            :items="annualIncome"
                                            v-model="item.annualfamincome"
                                            name="annual_income"
                                            label="Annual Income"
                                            :error-messages="formErrors.annualfamincome"
                                        />
                                    </v-col>
                                </v-row>
                            </div>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn  :disabled="loading" type="submit" color="primary">
                            {{ loading ?  'Please wait...' : 'Save Changes'}}
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "FamilyForm",
    data: () => ({
        valid: false,
        country: [
            'PHILIPPINES'
        ],
        parentStatus: [
            'Living Together',
            'Mother Deceased',
            'Father and Mother Deceased',
            'Father  Deceased',
            'Mother OFW',
            'Father OFW',
            'Father and Father OFW',
            'Separated'
        ],
        annualIncome: [
            'below 10k',
            '10k to 50k',
            '50k to 100k',
            '100k to 500k',
            'above 500k',
        ],
        fieldRules: [
            v => !!v || 'This field is required',
        ],

    }),
    watch:{
        item(){
            if(this.item.id){
                this.fetchGuardianProvinceData();
                this.fetchGuardianCityData(this.item.guardian_province);
                this.fetchGuardianBrgyData(this.item.guardian_city);
            }
        },
    },
    mounted() {
        this.findData(this.$page.props.user.id)
        this.fetchGuardianProvinceData();
    },

    computed: {
        ...mapGetters("FamilyInformationSingle", ["formErrors", "item","errorMessage","loading"]),
        ...mapGetters("AddressInformationIndex",["guardianBrgyData","guardianCityData","guardianProvinceData"]),
    },
    methods: {
        ...mapActions("AddressInformationIndex",["fetchGuardianProvinceData","fetchGuardianBrgyData","fetchGuardianCityData"]),
        //Contact Information
        ...mapActions("FamilyInformationSingle", [
            "setFatherName1",
            "setFatherName2",
            "setFatherName3",
            "setFatherName4",
            "setFatherOccupation",
            "setMotherName1",
            "setMotherName2",
            "setMotherName3",
            "setMotherOccupation",
            "setAnnualIncome",
            "setGuardian",
            "setGuardianPhone",
            "setParentStatus",
            "storeData",
            "updateData",
            "findData",
            "setFormErrors",
        ]),
        async submit() {
            this.setFormErrors({});
            if (!this.item.id) {
                this.storeData()
                    .then((data) => {
                        this.$toast.success("Successfully saved.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                    });
            } else {
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
