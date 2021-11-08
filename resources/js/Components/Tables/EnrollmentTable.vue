<template>
    <div>
        <v-data-table
            :headers="tableColumns"
            :items="tableData"
            item-key="id"
            class="elevation-1"
        >
            <template v-slot:item.status="{ item }">
                <v-chip
                    :color="getColor(item.status)"
                    dark
                >
                    {{ item.status }}
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
                    <v-toolbar-title>Enrollment Application History</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-tooltip v-if="item.status === 'PENDING'" bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            v-bind="attrs"
                            v-on="on"
                            @click="showDeleteModal(item)"
                        >
                            <v-icon
                                small
                                color="red"
                            >
                                mdi-delete
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Delete</span>
                </v-tooltip>
                <v-tooltip v-if="item.status === 'ENROLLED'" bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon
                                small
                                color="primary"
                            >
                                mdi-eye
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Show Details</span>
                </v-tooltip>
            </template>
        </v-data-table>
        <v-dialog
            v-model="deleteDialog"
            persistent
            max-width="300"
        >
            <v-card>
                <v-card-title></v-card-title>
                <v-card-text> Delete this enrollment application?</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red darken-1"
                        text
                        @click="deleteDialog = false"
                    >
                        Disagree
                    </v-btn>
                    <v-btn
                        color="green darken-1"
                        text
                        @click="handleDelete"
                    >
                        Agree
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'EnrollmentTable',
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
        ...mapGetters("EnrollmentHistoryIndex", [
            "tableData",
            "pagination",
            "tableColumns",
            "perPageOptions",
            "serverQuery",
        ]),
    },
    methods: {
        ...mapActions("EnrollmentHistoryIndex", [
            "fetchData",
            "setServerQuery",
            "destroyData",
        ]),
        ...mapActions("EnrollmentInformationIndex", {destroyApplication: "destroyData"}),
        getColor(status) {
            if (status == 'ENROLLED') return 'green'
            if (status == 'ON PROCESS') return 'orange'
            if (status == 'PENDING') return 'red'
        },
        getSem(sem) {
            if (sem === 1 || sem === '1')
                return 'FIRST SEM'
            if (sem === 2 || sem === '2')
                return 'SECOND SEM'
            if (sem === 3 || sem === '3')
                return 'SUMMER'
        },
        getYearLevel(year) {
            if (year === 1 || year === '1')
                return 'FIRST YEAR'
            if (year === 2 || year === '2')
                return 'SECOND YEAR'
            if (year === 3 || year === '3')
                return 'THIRD YEAR'
            if (year === 4 || year === '5')
                return 'FOURTH YEAR'
            if (year === 5 || year === '5')
                return 'FIFTH YEAR'
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
        this.fetchData();

    },
    created() {
        this.$root.$refs.enrollmentApplicationTable = this;
    }
}
</script>

<style scoped>

</style>
