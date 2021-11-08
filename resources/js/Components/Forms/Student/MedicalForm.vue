<template>
    <v-row no-gutters>
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Medical Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Before you proceed in answering this form,
                    please LOG IN to your facebook account and add "MAIN COLLEGECLINIC" then like and follow "MMC Aiders
                    and Medical Team". These social media accounts are the OFFICIAL media platform of the University's
                    Medical Unit. </p>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">You also have to answer the following questions
                    diligently and honestly as this form could also be used as a basis for your inclusion in
                    face-to-face classes (once approved by the IATF, CHED, DOH, and this University's Academic
                    Council)</p>

            </v-sheet>
        </v-col>
        <v-col md="9" cols="12" class="pa-3">
            <v-card :loading="loading || saving">
                <v-card-text>
                    <v-form v-model="valid">
                        <v-container>
                            <v-row v-for="(categories,i) in medicalQuestions" :key="i">
                                <v-col>
                                    <v-data-table
                                        :headers="columns"
                                        :items="categories"
                                        hide-default-footer
                                        disable-pagination
                                        hide-default-header
                                    >
                                        <template v-slot:top>
                                            <v-toolbar flat>
                                                <v-toolbar-title>{{ i }}</v-toolbar-title>
                                                <v-spacer></v-spacer>
                                            </v-toolbar>
                                        </template>
                                        <template v-slot:item.question="{ item }">
                                            <span>{{
                                                    !item.sub_category ? item.question : item.question + '(' + item.sub_category + ' only)'
                                                }}</span>
                                        </template>
                                        <template v-slot:item.answer="{ item }">
                                            <v-row>
                                                <v-col cols="12" lg="6">
                                                    <v-select
                                                        v-if="item.type == 'boolean' || item.type == 'file'"
                                                        :items="selection"
                                                        label="Answer"
                                                        :hint="item.hint"
                                                        :value="loadAnswer(item.id,'answer')"
                                                        @change="getAnswer(item.id,$event)"
                                                    />
                                                    <v-text-field
                                                        value="YES"
                                                        :hint="item.hint"
                                                        v-if="item.type == 'text'"
                                                        :value="loadAnswer(item.id,'answer')"
                                                        @input="getAnswer(item.id,$event)"
                                                        :label="item.sub_question"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col v-if="item.sub_question" cols="12" lg="6">
                                                    <v-file-input
                                                        chips
                                                        v-if="item.type == 'file'"
                                                        @input="getSubAnswer(item.id,$event)"
                                                        :label="item.sub_question"
                                                    ></v-file-input>
                                                    <v-text-field
                                                        v-else
                                                        :label="item.sub_question"
                                                        :value="loadAnswer(item.id,'sub_answer')"
                                                        @input="getSubAnswer(item.id,$event)"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col v-if="item.date" cols="12" lg="6">
                                                    <v-text-field
                                                        type="date"
                                                        :label="item.date"
                                                        :value="loadAnswer(item.id,'date')"
                                                        @input="getAnswerDate(item.id,$event)"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </template>
                                    </v-data-table>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="submit" :disabled="loading" type="button" color="primary">
                        {{ loading ? 'Please wait...' : 'Save Changes' }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "MedicalForm",
    data: () => ({
        valid: false,
        answer: [],
        selection: ['YES', 'NO'],
        columns: [
            {text: 'Question', value: 'question'},
            {text: 'Answer', value: 'answer'},
        ],
        fieldRules: [
            v => !!v || 'This field is required',
        ],

    }),
    watch:{
      allData(){
           this.setAnswer(this.allData)
      }
    },
    computed: {
        ...mapGetters("MedicalInformationIndex", ["medicalQuestions","allData","loading"]),
        ...mapGetters("MedicalInformationSingle", ["item", "errorMessage"]),
        ...mapGetters("MedicalInformationSingle", {saving: "loading"}),
    },
    methods: {
        ...mapActions("MedicalInformationIndex", ["fetchMedicalQuestion","fetchAllData"]),
        ...mapActions("MedicalInformationSingle", ["storeData","setAnswer"]),
        getAnswer(id, answer) {
            if(this.item.answer.length >0){
                var found = false;
                var ans = null;
                for (var i = 0; i < this.item.answer.length; i++) {
                    if (this.item.answer[i].quid === id) {
                        found = true;
                        ans = this.item.answer[i];
                        this.item.answer.splice(i, 1);
                    }
                }
                if(found){
                    if (ans.sub_answer &&  ans.date) {
                        this.item.answer.push( {
                            quid: ans.quid,
                            answer: answer,
                            sub_answer: ans.sub_answer,
                            date: ans.date
                        });
                    }
                    if (ans.sub_answer &&  !ans.date) {
                        this.item.answer.push( {
                            quid: ans.quid,
                            answer: answer,
                            sub_answer: ans.sub_answer,
                        });
                    }
                    if (!ans.sub_answer &&  ans.date) {
                        this.item.answer.push( {
                            quid: ans.quid,
                            answer: answer,
                            date: ans.date
                        });
                    }
                    if (!ans.sub_answer &&  !ans.date) {
                        this.item.answer.push( {
                            quid: ans.quid,
                            answer: answer,
                        });

                    }
                }
                else{
                    this.item.answer.push( {
                        quid: id,
                        answer: answer,
                    });
                }
            }
            else{
                this.item.answer.push({
                    quid: id,
                    answer: answer,
                });
            }
        },
        getSubAnswer(id, sub_answer) {
            if(this.item.answer.length >0){
                var found = false;
                var ans = null;
                for (var i = 0; i < this.item.answer.length; i++) {
                    if (this.item.answer[i].quid === id) {
                        found = true;
                         ans = this.item.answer[i];
                        this.item.answer.splice(i, 1);
                    }
                }
                if(found){
                    if (ans.answer &&  ans.date) {
                        this.item.answer.push( {
                            quid: ans.quid,
                            answer: ans.answer,
                            sub_answer: sub_answer,
                            date: ans.date
                        });
                    }
                    if (ans.answer &&  !ans.date) {
                        this.item.answer.push( {
                            quid: ans.quid,
                            answer: ans.answer,
                            sub_answer: sub_answer,
                        });
                    }
                    if (!ans.answer &&  ans.date) {
                        this.item.answer.push( {
                            quid: ans.quid,
                            sub_answer: ans.sub_answer,
                            date: ans.date
                        });
                    }
                    if (!ans.answer &&  !ans.date) {
                        this.item.answer.push( {
                            quid: ans.quid,
                            sub_answer: sub_answer,
                        });

                    }
                }
                else{
                    this.item.answer.push( {
                        quid: id,
                        sub_answer: sub_answer,
                    });
                }
            }
            else{
                this.item.answer.push({
                    quid: id,
                    sub_answer: sub_answer,
                });
            }
        },
        getAnswerDate(id, date) {
            if(this.item.answer.length >0){
                var found = false;
                var ans = null;
                for (var i = 0; i < this.item.answer.length; i++) {
                    if (this.item.answer[i].quid === id) {
                        found = true;
                        ans = this.item.answer[i];
                        this.item.answer.splice(i, 1);
                    }
                }
                if(found){
                    if (ans.answer && ans.sub_answer)  {
                        this.item.answer.push( {
                            quid: ans.quid,
                            answer: ans.answer,
                            sub_answer: ans.sub_answer,
                            date: date
                        });
                    }
                    if (ans.answer && !ans.sub_answer)  {
                        this.item.answer.push( {
                            quid: ans.quid,
                            answer: ans.answer,
                            date: date
                        });
                    }
                    if (!ans.answer && ans.sub_answer)  {
                        this.item.answer.push( {
                            quid: ans.quid,
                            sub_answer: ans.sub_answer,
                            date: date
                        });
                    }
                    if (!ans.answer && !ans.sub_answer)  {
                        this.item.answer.push( {
                            quid: ans.quid,
                            date: date,
                        });

                    }
                }
                else{
                    this.item.answer.push( {
                        quid: id,
                        date: date,
                    });
                }
            }
            else{
                this.item.answer.push({
                    quid: id,
                    date: date
                });
            }
        },
        loadAnswer(id,field){
            for (var i = 0; i < this.allData.length; i++) {
                if (this.allData[i].quid === id) {
                    if(field == 'answer'){
                        return this.allData[i].answer
                    }
                    if(field == 'sub_answer'){
                        if(!this.allData[i].sub_answer === 'null'){
                            return this.allData[i].sub_answer
                        }
                    }
                    if(field == 'date'){
                        return this.allData[i].date
                    }
                    break;
                }
            }
        },
        async submit() {
            this.storeData()
                .then((data) => {
                    this.$toast.success("Successfully saved.", this.$toastOption);
                    this.fetchAllData();
                })
                .catch((error) => {
                    this.$toast.error("Oops! " + this.errorMessage, this.$toastOption);
                });
        }


    },
    async mounted() {
        await this.fetchAllData();
        await this.fetchMedicalQuestion();
    }
}
</script>

<style scoped>

</style>
