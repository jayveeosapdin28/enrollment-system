<template>
    <div>
        <v-data-table
            :headers="tableColumns"
            :items="tableData"
            item-key="id"
            :loading="loading"
            loading-text="Loading... Please wait"
            hide-default-footer
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Pending Registrations</v-toolbar-title>
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
            <template v-slot:item.studsem="{ item }">
                <span>{{getSem(item.studsem)}}</span>
            </template>
            <template v-slot:item.yearlevel="{ item }">
                <span>{{getYearLevel(item.yearlevel)}}</span>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn v-if="item.idnumber == '' || item.idnumber == null"
                    small
                    color="success"
                    @click="accept(item.id,item.idnumber)"
                >
                   Accept
                </v-btn>
                <v-btn v-else
                       small
                       color="primary"
                       tag="inertia-link"
                       :href="route('admin.enrollment-applications.enroll-subjects.show',item.user.id)"
                >
                    Encode
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
                    This student have no ID number. Do you want to assign a new one to this student?
                </v-card-text>
                <v-card-actions>
                    <v-btn text color="red darken-1"  @click="dialog = false">No</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn text color="green darken-1"  @click="assignID">Yes</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Pagination from "../Widgets/Pagination";
import {getSem,getYearLevel} from "../../Utilities/Helper";

export default {
    name: 'PendingStudentTable',
    components: {Pagination},
    data() {
        return {
            dialog: false,
            id:null,
        }
    },
    computed: {
        ...mapGetters("PendingApplicationIndex", [
            "tableData",
            "pagination",
            "tableColumns",
            "serverQuery",
            "loading"
        ]),
    },
    methods: {
        ...mapActions("PendingApplicationIndex", [
            "fetchData",
            "setServerQuery",
            "destroyData",
        ]),
        ...mapActions("PendingApplicationSingle",["updateData","generateIDNumber"]),

        getSem(sem) {
            return getSem(sem)
        },
        getYearLevel(year) {
           return getYearLevel(year)
        },
        accept(id,idnumber){
            if(idnumber == '' || idnumber == null){
                this.id = id;
               this.dialog = true;
            }
        },
        async assignID(){
            await this.generateIDNumber(this.id)
                .then((data) => {
                    this.$toast.success("ID Number successfully assigned. ", this.$toastOption);
                    this.fetchData();
                })
                .catch((error) => {
                    this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                });
            this.dialog = false;
        }

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
