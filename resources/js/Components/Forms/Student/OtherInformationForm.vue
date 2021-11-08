<template>
    <v-row no-gutters>
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Additional Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Please be honest with this information. This information will be use in as our reference</p>
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
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Personality</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="item.tribe"
                                            label="Tribe (if indigenous people)"
                                            :error-messages="formErrors.tribe"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-select
                                            :items="lgbt"
                                            v-model="item.lgbt"
                                            name="lgbt"
                                            label="LGBT Member?"
                                            :error-messages="formErrors.lgbt"
                                        />
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="student_type"
                                            item-text="text"
                                            item-value="value"
                                            v-model="item.student_type"
                                            name="student_type"
                                            label="Student Type"
                                            :error-messages="formErrors.student_type"
                                        />
                                    </v-col>
                                </v-row>
                            </div>
                            <div>
                                <v-row>
                                    <v-col>
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Scholarship (If more than one, separate with comma)</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="12"
                                    >
                                        <v-text-field
                                            v-model="item.scholarship"
                                            label="Scholarship"
                                            :error-messages="formErrors.scholarship"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </div>
                            <div>
                                <v-row>
                                    <v-col>
                                        <p class="mt-2 subtitle-1 font-weight-light font-italic">Flexible Learning Details</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="learning_module"
                                            v-model="item.learning_module"
                                            name="lgbt"
                                            label="Prepared Learning Method"
                                            :error-messages="formErrors.learning_module"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            :items="internet_connectivity"
                                            v-model="item.internet_connectivity"
                                            name="lgbt"
                                            label="Internet Connectivity Status"
                                            :error-messages="formErrors.internet_connectivity"
                                        />
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
    name: "OtherInformationForm",
    data: () => ({
        valid: false,
        lgbt: ['YES', 'NO', 'UNDECIDED'],
        student_type: [
            {value: 'WORKING',text: 'Working student'},
            {value: 'NOT WORKING',text: 'Full time student'},
            ],
        learning_module: ['LMS', 'Online Class', 'Modular'],
        internet_connectivity: ['Full Access', 'Limited Access', 'No Access'],

    }),
    mounted() {
        this.findData(this.$page.props.user.id)
    },
    computed: {
        ...mapGetters("AdditionalInformationSingle", ["formErrors", "item","errorMessage", "loading"]),
    },
    methods: {
        //Contact Information
        ...mapActions("AdditionalInformationSingle", [
            "setEmail",
            "setPhone",
            "storeData",
            "updateData",
            "findData",
            "setFormErrors"
        ]),
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

    }
}
</script>

<style scoped>

</style>
