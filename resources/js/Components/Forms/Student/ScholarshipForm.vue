<template>
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Scholarship Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Your valid contacts that we will contact you.</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12" class="pa-3">
           <v-card>
              <v-card-text>
                  <v-form v-model="valid">
                      <v-container>
                          <v-row>
                              <v-col
                                  cols="12"
                                  md="12"
                              >
                                  <v-text-field
                                      v-model="item.EMAIL1"
                                      :rules="fieldRules"
                                      label="Scholarship Name"
                                      required
                                      @update:model-value="setEmail($event)"
                                  ></v-text-field>
                              </v-col>
                          </v-row>
                      </v-container>
                  </v-form>
              </v-card-text>
               <v-card-actions>
                   <v-btn
                       text
                   >
                       Add
                   </v-btn>
               </v-card-actions>
           </v-card>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
name: "ScholarshipForm",
    data:() =>({
        valid: false,
        fieldRules: [
            v => !!v || 'This field is required',
        ],

    }),
    computed:{
        ...mapGetters("ContactInformationSingle",[ "formErrors","item"]),
    },
    methods:{
        //Contact Information
        ...mapActions("ContactInformationSingle",[
            "setEmail",
            "setPhone",
        ]),

    }
}
</script>

<style scoped>

</style>
