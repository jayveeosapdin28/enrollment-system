<template>
    <div>
        <h2 class="my-4">Total Enrolled: {{totalEnrolled}}</h2>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-text>
                        <v-data-table
                            :headers="columns"
                            :items="tableData"
                            hide-default-footer
                            disable-pagination
                        >
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "AdminDashboard",
    data:() => ({
       columns: [
           {value: 'name', text: 'Program'},
           {value: 'count', text: 'Total'}
       ]
    }),
    computed: {
        ...mapGetters("DashboardIndex", ["tableData"]),
        totalEnrolled() {
            return this.tableData.reduce((accumulator, current) =>
                accumulator + parseInt(current.count), 0);
        }
    },
    methods: {
        ...mapActions("DashboardIndex", ["fetchData"]),
    },
    mounted() {
        this.fetchData();
        console.log(this.tableData)
    }
}
</script>

<style scoped>

</style>
