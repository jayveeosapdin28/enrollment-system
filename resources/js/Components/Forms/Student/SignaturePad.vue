<template>
    <v-row no-gutters>
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'ID Picture and Signature'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Please provide a clear copy of your
                    2X2 ID picture and signature</p>
            </v-sheet>
        </v-col>
        <v-col md="9" cols="12" class="pa-3">
            <v-card :loading="false">
                <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation

                    @submit.prevent="submit"
                >
                    <template slot="progress">
                        <v-progress-linear
                            color="primary"
                            height="5"
                            indeterminate
                        ></v-progress-linear>
                    </template>
                    <v-card-text>
                        <v-file-input
                            v-model="item.id_picture"
                            chips
                            clearable
                            show-size
                            accept="image/*"
                            :error-messages="formErrors.id_picture"
                            label="Select 2X2 ID Picture"
                            hint="*Note: This will be used as your school ID picture."
                        ></v-file-input>
<!--                        <v-file-input-->
<!--                            v-model="item.signature_path"-->
<!--                            chips-->
<!--                            clearable-->
<!--                            ref="signature_path"-->
<!--                            show-size-->
<!--                            accept="image/*"-->
<!--                            @click="clear"-->
<!--                            :error-messages="formErrors.signature_path"-->
<!--                            label="Select image of your signature"-->
<!--                        ></v-file-input>-->
                        <p class="subtitle-1">Draw your signature</p>
                        <div style="border: 2px black solid">
                            <VueSignaturePad width="100%" height="300px" ref="signaturePad"
                                             :options="{ onBegin, onEnd }"
                            />
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="error"
                            @click="undo"
                        >
                            Undo
                        </v-btn>
                        <v-btn
                            color="success"
                            @click="clear"
                        >
                            Clear
                        </v-btn>
                    </v-card-actions>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn :disabled="loading" type="submit"  color="primary">
                            {{ loading ?  'Please wait...' : 'Save Changes'}}
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "SignaturePad",
    data: () => ({
        valid: true,
    }),
    computed: {
        ...mapGetters("SignaturePadSingle", ["formErrors", "loading", "item", "errorMessage"]),
    },
    methods: {
        ...mapActions("SignaturePadSingle", ["storeData", "setSignature", "resetState","setSignaturePath"]),
        undo() {
            this.$refs.signaturePad.undoSignature();
        },
        clear() {
            this.$refs.signaturePad.clearSignature();
        },
        onBegin() {
            this.setSignaturePath(null)
        },
        onEnd() {
            if (!this.$refs.signaturePad.isEmpty()) {
                this.setSignature(this.$refs.signaturePad.saveSignature('image/png').data)
            }
        },
        submit() {
            this.storeData()
                .then((data) => {
                    this.$toast.success("Successfully saved.", this.$toastOption);
                    this.$refs.signaturePad.clearSignature();
                    this.$refs.signaturePad.clearCacheImages();
                    this.resetState();
                })
                .catch((error) => {
                    this.$toast.error("Oops! " + this.errorMessage, this.$toastOption);
                });
        }
    }
}
</script>

<style scoped>

</style>
