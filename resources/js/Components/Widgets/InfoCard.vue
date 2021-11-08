<template>
    <v-card v-if="student">
        <v-card-text>
            <h1 class="">{{toTitleCase(student.user.name)}}</h1>
          <v-row>
              <v-col cols="12" sm="8">
                  <p class="font-weight-light pt-2 my-1"><span class="font-weight-bold">ID NUMBER:</span> {{student.idnumber}}</p>
                  <p class="font-weight-light my-1"><span class="font-weight-bold">PROGRAM:</span> {{student.program.cordesc}}</p>
                  <p class="font-weight-light my-1"><span class="font-weight-bold">MAJOR:</span> {{student.program.cormajor}}</p>
              </v-col>
              <v-col v-if="showAssessmentInfo && subject != null" cols="12" sm="4">
                  <p class="font-weight-light my-1"><span class="font-weight-bold">YEAR LEVEL:</span> {{getYearLevel(student.yearlevel)}}</p>
                  <p class="font-weight-light my-1"><span class="font-weight-bold">SEMESTER:</span> {{getSem(student.studsem)}}</p>
              </v-col>
          </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import { getSem,getYearLevel,toTitleCase } from "../../Utilities/Helper"
export default {
    props: {
        student :{
            default: null,
        },
        showAssessmentInfo :{
            default: false,
        },
        subject :{
            default: null,
        }
    },
    name: "InfoCard",
    computed:{
        totaUnits(){
            if (this.student.subject){
                return this.student.subject.reduce((accumulator, current) =>
                    accumulator + parseInt(current.subunit), 0);
            }
            return 0;
        },
        laboratories(){
                    if (this.student.subject){
                        return this.student.subject.reduce((accumulator, current) =>
                        accumulator + (current.subfee == "lab fee" ? 1 : 0), 0);
            }
            return 0;
        },
        comlab(){
            if (this.student.subject){
                return this.student.subject.reduce((accumulator, current) =>
                    accumulator + (current.subfee == "comp fee" ? 1 : 0), 0);
            }
            return 0;
        }
    },
    methods:{
        toTitleCase(str){
            return toTitleCase(str);
        },
        getYearLevel(year){
            return getYearLevel(year)
        },
        getSem(sem){
            return getSem(sem)
        }
    },


}
</script>

<style scoped>

</style>
