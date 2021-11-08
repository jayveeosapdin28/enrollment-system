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
                    <v-toolbar-title>On Process Registrations</v-toolbar-title>
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
                    v-if="item.step == 4 || item.step == '4'"
                    small
                    color="success"
                    @click="confirm(item.id)"
                >
                    Confirm
                </v-btn>
                <v-btn
                    v-if="item.step == 3 || item.step == '3'"
                    small
                    color="primary"
                    tag="inertia-link"
                    :href="route('admin.enrollment-applications.enroll-subjects.show',item.user.id)"
                >
                    Update
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
        <v-dialog v-model="dialog" persistent max-width="300">
            <v-card>
                <v-card-title></v-card-title>
                <v-card-text>
                    Do you want to confirm this enrollment registration?
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
    name: 'OnProcessRegistration',
    components: {},
    data() {
        return {
            dialog: false,
            id: null,
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
            "fetchData",
            "setServerQuery",
            "destroyData",
            "setStepFrom",
            "setStepTo",
        ]),
        ...mapActions("RegistrationSingle", ["confirmEnrollment"]),

        getSem(sem) {
            return getSem(sem)
        },
        getStatus(){

        },
        getYearLevel(year) {
            return getYearLevel(year)
        },
        confirm(id) {
            this.id = id;
            this.dialog = true;
        },
        search(e){
            this.setStepFrom(3)
            this.setStepTo('')
            this.setServerQuery({ name: 'query', value: e })
        },
        async submit() {
            await this.confirmEnrollment(this.id)
                .then((data) => {
                    this.$toast.success("Enrollment registration successfully confirmed. ", this.$toastOption);
                    this.fetchOnProcess();
                })
                .catch((error) => {
                    this.$toast.error("Oops! " + this.errorMessage, this.$toastOption);
                });
            this.dialog = false;
        }

    },
    mounted() {
        this.setStepFrom(3)
        this.setStepTo('')
        this.setServerQuery({ name: '', value: '' })
    },
    created() {
        this.$root.$refs.enrollmentApplicationTable = this;
    }
}
</script>

<style scoped>

</style>
