<template>
    <v-row no-gutters>
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Contact Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Your valid contacts that we will contact
                    you.</p>
            </v-sheet>
        </v-col>
        <v-col md="9" cols="12" class="pa-3">
            <v-card  :loading="loading">
                <template slot="progress">
                    <v-progress-linear
                        color="primary"
                        height="5"
                        indeterminate
                    ></v-progress-linear>
                </template>
               <form @submit.prevent="submit">
                   <v-card-text>
                       <v-container>
                           <v-row>
                               <v-col
                                   cols="12"
                                   md="3"
                               >
                                   <v-text-field
                                       v-model="item.phone1"
                                       label="Phone Number"
                                       :error-messages="formErrors.phone1"
                                   ></v-text-field>
                               </v-col>

                           </v-row>
                       </v-container>
                   </v-card-text>
                   <v-card-actions>
                       <v-spacer/>
                       <v-btn  :disabled="loading" type="submit" color="primary">
                           {{ loading ?  'Please wait...' : 'Save Changes'}}
                       </v-btn>
                   </v-card-actions>
               </form>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "ContactForm",
    computed: {
        ...mapGetters("ContactInformationSingle", ["formErrors", "item","errorMessage","loading"]),
    },
    async mounted() {
        await this.setEmail(this.$page.props.user.email)
    },
    beforeMount() {
         this.findData(this.$page.props.user.id)
    },
    methods: {
        //Contact Information
        ...mapActions("ContactInformationSingle", [
            "setEmail",
            "setPhone",
            "storeData",
            "updateData",
            "findData",
            "setFormErrors"
        ]),
        async submit() {
            this.setFormErrors({});
            if (!this.item.id) {
                this.storeData()
                    .then((data) => {
                        this.$toast.success("Successfully saved.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                    });
            } else {
                this.updateData()
                    .then((data) => {
                        this.$toast.success("Successfully updated.", this.$toastOption);
                    })
                    .catch((error) => {
                        this.$toast.error("Oops! "+this.errorMessage, this.$toastOption);
                    });
            }
        }

    }
}
</script>

<style scoped>

</style>
