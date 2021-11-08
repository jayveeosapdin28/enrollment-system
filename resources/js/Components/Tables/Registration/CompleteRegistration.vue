<template>
    <div>
        <v-data-table
            :headers="tableColumns"
            :items="tableData"
            item-key="id"
            dense
            :loading="loading"
            loading-text="Loading... Please wait"
            hide-default-footer
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Enrolled Student</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="serverQuery.query"
                        :model-value="serverQuery.query"
                        @change="search($event)"
                        append-icon="mdi-magnify"
                        label="Search ID Number"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-toolbar>
            </template>
            <template v-slot:item.studsem="{ item }">
                <span>{{getSem(item.studsem)}}</span>
            </template>
            <template v-slot:item.yearlevel="{ item }">
                <span>{{getYearLevel(item.yearlevel)}}</span>
            </template>
            <template v-slot:item.status="{ item }">
                <v-chip
                    :color="item.status == 'ON PROCESS' ? 'warning' : 'success'"
                    small
                    class="ma-2"
                >
                    {{item.status}}
                </v-chip>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn
                    v-if="item.step == 5 || item.step == '5'"
                    small
                    color="neutral"
                    class="my-1"
                    tag="inertia-link"
                    :href="route('admin.enrollment-applications.enroll-subjects.show',item.user.id)"
                >
                    Print
                </v-btn>
                <v-btn
                    v-if="item.step == 5 || item.step == '5'"
                    small
                    color="error"
                    class="my-1"
                    @click="disenroll(item.id,item.idnumber)"
                >
                    Disenroll
                </v-btn>
            </template>
        </v-data-table>
        <v-pagination
            v-model="pagination.currentPage"
            :total-visible="5"
            circle
            :length="pagination.lastPage"
            @input="setServerQuery({ name: 'page', value: pagination.currentPage })"
        ></v-pagination>
        <v-dialog v-model="dialog" persistent max-width="400">
            <v-card>
                <v-card-title>Disenroll {{idnumber}}?</v-card-title>
                <v-card-text>
                    <p class="subtitle-1"><b>"DISENROLL"</b> will remove the student from enrolled list. Likewise,
                        enrollment <b>STATUS</b> will be changed from
                        <v-chip color="success" small class="ma-2">ENROLLED</v-chip>
                        to
                        <v-chip color="error" small class="ma-2">PENDING</v-chip>
                        .
                    </p>
                    <p class="subtitle-1">Do you still want to continue?</p>
                </v-card-text>
                <v-card-actions>
                    <v-btn text color="red darken-1" @click="dialog = false">No</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn text color="green darken-1" @click="submit">Yes</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {getSem, getYearLevel} from "../../../Utilities/Helper";

export default {
    name: 'CompleteRegistration',
    components: {},
    data() {
        return {
            dialog: false,
            id: null,
            idnumber: null,
        }
    },
    computed: {
        ...mapGetters("RegistrationIndex", [
            "tableData",
            "pagination",
            "tableColumns",
            "serverQuery",
            "loading"
        ]),
    },
    methods: {
        ...mapActions("RegistrationIndex", [
            "setServerQuery",
            "destroyData",
            "setStepFrom",
            "setStepTo",
        ]),
        ...mapActions("RegistrationSingle", ["confirmEnrollment", "cancelEnrollment"]),

        getSem(sem) {
            return getSem(sem)
        },
        getStatus() {

        },
        getYearLevel(year) {
            return getYearLevel(year)
        },
        confirm(id) {
            this.id = id;
            this.dialog = true;
        },
        search(e) {
            this.setStepFrom(5)
            this.setStepTo('')
            this.setServerQuery({name: 'query', value: e})
        },
        disenroll(id, idnumber) {
            this.id = id;
            this.idnumber = idnumber;
            this.dialog = true;
        },
        fetchList() {
            this.setStepFrom(5)
            this.setStepTo('')
            this.setServerQuery({name: '', value: ''})
        },
        async submit() {
            await this.cancelEnrollment(this.id)
                .then((data) => {
                    this.$toast.success("Enrollment registration of " + this.idnumber + " was successfully cancelled. ", this.$toastOption);
                    this.fetchList();
                })
                .catch((error) => {
                    this.$toast.error("Oops! " + this.errorMessage, this.$toastOption);
                });
            this.dialog = false;
        }

    },
    mounted() {
        this.fetchList();
    },
    created() {
        this.$root.$refs.enrollmentApplicationTable = this;
    }
}
</script>

<style scoped>

</style>
