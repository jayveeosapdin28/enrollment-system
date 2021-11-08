<template>
    <v-card>
        <v-card-text>
            <v-row class="h">
                <v-col cols="12" sm="6">
                    <v-btn color="primary"
                           class="my-4" v-if="application.step < 5"
                           @click="computeFees"
                    >
                        <v-icon class="mr-2" small>mdi-repeat</v-icon>
                        Calculate Fees
                    </v-btn>
                    <v-data-table
                        :headers="tableColumns"
                        :items="feeTable"
                        dense
                        v-model="item.selected_fees"
                        :show-select ="true"
                        hide-default-footer
                        disable-pagination
                    >
                        <template v-slot:item.feeamount1="props">
                            <v-edit-dialog
                                :return-value.sync="props.item.feeamount1"
                            >
                                {{ props.item.feeamount1 }}
                                <template v-slot:input>
                                    <v-text-field
                                        v-model="props.item.feeamount1"
                                        label="Edit"
                                        single-line
                                    ></v-text-field>
                                </template>
                            </v-edit-dialog>
                        </template>
                    </v-data-table>
                    <h3 class="my-4">
                        Grand Total: {{formatPrice(sum)}}
                    </h3>
                </v-col>
                <v-col>
                    <v-divider
                        class="mx-2"
                        vertical
                    ></v-divider>
                </v-col>
                <v-col cols="12" sm="5">
                    <h1 class="my-4">
                        Summary
                    </h1>
                    <p class="font-weight-normal subtitle-2 my-1">Number of Units: {{subject.unitsCount}}</p>
                    <p class="font-weight-normal subtitle-2 my-1">Number of Subject/s: {{subject.subjectCount}}</p>
                    <p class="font-weight-normal subtitle-2 my-1">Number of Laboratory/ies:
                        {{subject.comlabCount> 0 ? subject.comlabCount : subject.laboratoriesCount}}
                    </p>
                    <!--                        <p class="font-weight-normal my-1">NO. OF TECH:</p>-->
                    <h2 class="my-4">
                        Grand Total: {{formatPrice(sum)}}
                    </h2>
                    <v-btn color="primary"
                           v-if="item.selected_fees.length > 0"
                           @click="submit()"
                    >
                        <v-icon class="mr-2" small>mdi-floppy</v-icon>
                        Save and Print
                    </v-btn>
                    <v-btn color="success"
                           @click="reprint(assessmentData)"
                           v-if="assessmentData.length > 0"
                    >
                        <v-icon class="mr-2" small>mdi-printer</v-icon>
                        Re-Print
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {printAssessment} from "../../Utilities/PrintLayouts/Assessment";
import {formatPrice} from "../../Utilities/Helper";

export default {
    name: "StudentFeeTable",
    props: ['application', 'subject'],
    data: () => ({
        selected: [],
        table: null,
        feeTable: [],
        fees: [],
        schoolInfo : {
            name: 'MINDORO STATE UNIVERSITY',
            adddress: 'Main Campus'
        },
    }),
    watch: {
        fees(){

        }
    },
    computed: {
        ...mapGetters("FeeIndex", ["tableColumns", "tableData", "allData","newFeeData","assessmentData"]),
        ...mapGetters("FeeSingle", ["errorMessage","item"]),
        sum() {
            return this.item.selected_fees.reduce((accumulator, current) =>
                accumulator + parseFloat(Number(current.feeamount1.replace(/[^0-9.-]+/g,""))), 0);
        }
    },
    methods: {
        ...mapActions("FeeIndex", ["fetchData","setAssessmentData" ,"fetchAllData", "setTableData","setNewFeeData","fetchAssessmentData"]),
        ...mapActions("FeeSingle", ["storeData","setSelectedFees","setEnrollmentAppId"]),
        formatPrice(value) {
            return formatPrice(value);
        },

        computeFees() {
            var feesTable= [];
            var subject = this.subject
            this.tableData.map((fee) => {
                var amount = fee.feeamount1;
                if (fee.id == 6) {
                    amount = parseFloat(fee.feeamount1 * subject.comlabCount ).toFixed(2);
                }
                if (fee.id == 12) {
                    amount = parseFloat(fee.feeamount1 * subject.laboratoriesCount).toFixed(2);
                }
                if (fee.id == 4) {
                    amount = parseFloat(fee.feeamount1 * subject.unitsCount).toFixed(2);
                }
                feesTable.push({
                    id: fee.id,
                    feeamount1: formatPrice(amount),
                    feename: fee.feename,
                    feeclass: fee.feeclass,
                })
            })
            this.feeTable = feesTable;
        },
        reprint(assessmentData){
            this.fetchAssessmentData(this.application.id)
            var user = {name: this.$page.props.user.name, position: this.$page.props.user.position}
            let fees = assessmentData.reduce((r, a) => {
                r[a.feeclass] = [...r[a.feeclass] || [], a];
                return r;
            }, {});
            printAssessment(this.application, this.subject, this.schoolInfo, fees, user);
        },
        print() {
            this.setAssessmentData([]);
            var user = {name: this.$page.props.user.name, position:this.$page.props.user.position}

            let fees = this.item.selected_fees.reduce((r, a) => {
                r[a.feeclass] = [...r[a.feeclass] || [], a];
                return r;
            }, {});
            printAssessment(this.application, this.subject, this.schoolInfo, fees, user);
        },
        submit(){
            this.setEnrollmentAppId(this.application.id)
            this.storeData()
                .then((data) => {
                    this.$toast.success("Successfully saved.", this.$toastOption);
                    this.print()
                })
                .catch((error) => {
                    this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                });
        }
    },

     async created() {
        await this.fetchData();
        await this.fetchAssessmentData(this.application.id)
    }
}
</script>

<style sass scoped>
.data-table-dense-row-height {
    height: 20px;
}
</style>
