<template>
    <v-row no-gutters>
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Addresses'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Particular place where you live</p>
            </v-sheet>
        </v-col>
        <v-col md="9" cols="12" class="pa-3">
            <v-card :loading="loading">
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
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Permanent Address</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="country"
                                            v-model="item.addcountry"
                                            name="country"
                                            label="Country"
                                            :error-messages="formErrors.addcountry"
                                        />
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="provinceData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.addprovince"
                                            name="province"
                                            label="Province"
                                            @change="fetchCityData"
                                            :error-messages="formErrors.addprovince"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="cityData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.addtown"
                                            name="city/town"
                                            label="City/Town"
                                            @change="fetchBarangayData"
                                            :error-messages="formErrors.addtown"
                                        />
                                    </v-col>

                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="barangayData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.addbrgy"
                                            name="barangay"
                                            label="Barangay"
                                            :error-messages="formErrors.addbrgy"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.addstreet"
                                            label="Street"
                                            :error-messages="formErrors.addstreet"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.addhouseno"
                                            label="House No."
                                            :error-messages="formErrors.addhouseno"
                                        ></v-text-field>
                                    </v-col>

                                </v-row>
                            </div>
                            <div>
                                <v-row>
                                    <v-col>
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Birth Address</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="country"
                                            v-model="item.brthcountry"
                                            name="country"
                                            label="Country"
                                            @change="fetchBirthProvinceData"
                                            :error-messages="formErrors.brthcountry"
                                        />
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="birthProvinceData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.brthprovince"
                                            name="province"
                                            label="Province"
                                            @change="fetchBirthCityData"
                                            :error-messages="formErrors.brthprovince"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="birthCityData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.brthtown"
                                            name="city/town"
                                            label="City/Town"
                                            @change="fetchBirthBrgyData"
                                            :error-messages="formErrors.brthtown"
                                        />
                                    </v-col>

                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="birthBrgyData"
                                            item-text="desc"
                                            item-value="id"
                                            v-model="item.brthbrgy"
                                            name="barangay"
                                            label="Barangay"
                                            :error-messages="formErrors.brthbrgy"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.brthstreet"
                                            label="Street"
                                            :error-messages="formErrors.brthstreet"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.brthhouseno"
                                            label="House No."
                                            :error-messages="formErrors.brthhouseno"
                                        ></v-text-field>
                                    </v-col>

                                </v-row>
                            </div>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn :disabled="loading" type="submit" color="primary">
                            {{ loading ? 'Please wait...' : 'Save Changes' }}
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
    name: "AddressForm",
    data: () => ({
        valid: false,
        country: [
            'PHILIPPINES'
        ],
        fieldRules: [
            v => !!v || 'This field is required',
        ],

    }),
    computed: {
        ...mapGetters("AddressInformationSingle", ["formErrors", "item", "errorMessage", "loading"]),
        ...mapGetters("AddressInformationIndex", ["barangayData", "cityData", "provinceData"]),
        ...mapGetters("AddressInformationIndex", ["birthBrgyData", "birthCityData", "birthProvinceData"]),
    },
    watch: {
        async item() {
            if (this.item.id) {
                await this.fetchProvinceData();
                await this.fetchBirthProvinceData();
                await this.fetchCityData(this.item.addprovince);
                await this.fetchBarangayData(this.item.addtown);
                await this.fetchBirthCityData(this.item.brthprovince);
                await this.fetchBirthBrgyData(this.item.brthtown);
            }
        }
    },
    mounted() {
        this.findData(this.$page.props.user.id)
        this.fetchProvinceData();
        this.fetchBirthProvinceData();

    },
    methods: {
        //Contact Information
        ...mapActions("AddressInformationSingle", [
            "setBirthHouseNo",
            "setBirthStreet",
            "setBirthBarangay",
            "setBirthTown",
            "setBirthZipcode",
            "setBirthProvince",
            "setBirthCountry",
            "setPermanentHouseNo",
            "setPermanentStreet",
            "setPermanentBarangay",
            "setPermanentTown",
            "setPermanentZipcode",
            "setPermanentProvince",
            "setPermanentCountry",
            "setFormErrors",
            "storeData",
            "updateData",
            "findData"
        ]),
        ...mapActions("AddressInformationIndex", ["fetchBarangayData", "fetchCityData", "fetchProvinceData"]),
        ...mapActions("AddressInformationIndex", ["fetchBirthBrgyData", "fetchBirthCityData", "fetchBirthProvinceData"]),
        async submit() {
            this.setFormErrors({});
            if (!this.item.id) {
                this.storeData()
                    .then((data) => {
                        this.$toast.success("Successfully saved.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! " + this.errorMessage, this.$toastOption);
                    });
            } else {
                this.updateData()
                    .then((data) => {
                        this.$toast.success("Successfully updated.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! " + this.errorMessage, this.$toastOption);
                    });
            }
        }
    },

}
</script>

<style scoped>

</style>
