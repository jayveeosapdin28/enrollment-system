<template>
    <v-card>
        <v-data-table
            :headers="tableColumns"
            :items="tableData"
            item-key="id"
            :loading="loading"
            loading-text="Loading... Please wait"
            hide-default-footer
            class="elevation-1"
        >
            <template v-slot:item.status="{ item }">
                <v-chip
                    :color="item.status == 'ON PROCESS' ? 'warning' : 'success'"
                    small
                    class="ma-2"
                >
                    {{item.status}}
                </v-chip>
            </template>
            <template v-slot:item.studsem="{ item }">
                <span>{{getSem(item.studsem)}}</span>
            </template>
            <template v-slot:item.yearlevel="{ item }">
                <span>{{getYearLevel(item.yearlevel)}}</span>
            </template>
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Pending Assessment</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="serverQuery.query"
                        :model-value="serverQuery.query"
                        @change="setServerQuery({ name: 'query', value: $event })"
                        append-icon="mdi-magnify"
                        label="Search ID Number"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn
                    small
                    color="primary"
                    tag="inertia-link"
                    :href="route('admin.enrollment-applications.assessments.fees',item.user.id)"
                >
                    Assess
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
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {getSem,getYearLevel} from "../../../Utilities/Helper";

export default {
    name: 'PendingAssessmentTable',
    components: {},
    data() {
        return {
            expanded: [],
            selectedItem: '',
            deleteDialog: false,
            singleExpand: false,
        }
    },
    computed: {
        ...mapGetters("StudentAssessmentIndex", [
            "tableData",
            "pagination",
            "tableColumns",
            "serverQuery",
            "loading"
        ]),
    },
    methods: {
        ...mapActions("StudentAssessmentIndex", [
            "fetchData",
            "setServerQuery",
            "destroyData",
            "setStatus"
        ]),
        ...mapActions("StudentAssessmentIndex", {destroyApplication: "destroyData"}),

        getSem(sem) {
            return getSem(sem)
        },
        getYearLevel(year) {
          return getYearLevel(year)
        },
        showDeleteModal(item) {
            this.deleteDialog = true;
            this.selectedItem = item;
        },
        handleDelete() {
            this.destroyApplication(this.selectedItem.id)
                .then((data) => {
                    this.$toast.success("Enrollment application successfully deleted", this.$toastOption);
                    this.deleteDialog = false;
                    this.fetchData();
                })
                .catch((error) => {
                    this.$toast.error("Oops! " + error.data.message, this.$toastOption);
                    this.deleteDialog = false;
                });
        },
    },
    mounted() {
        this.setStatus(3);
        this.setServerQuery({name: 'query',value: ''})

    },
    created() {
        this.$root.$refs.enrollmentApplicationTable = this;
    }
}
</script>

<style scoped>

</style>
