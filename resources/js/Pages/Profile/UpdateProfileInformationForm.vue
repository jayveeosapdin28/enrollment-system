<template>
<!--    <jet-form-section @submitted="updateProfileInformation">-->
<!--        <template #title>-->
<!--            Profile Information-->
<!--        </template>-->

<!--        <template #description>-->
<!--            Update your account's profile information and email address.-->
<!--        </template>-->

<!--        <template #form>-->
<!--            &lt;!&ndash; Profile Photo &ndash;&gt;-->
<!--            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">-->
<!--                &lt;!&ndash; Profile Photo File Input &ndash;&gt;-->
<!--                <input type="file" class="hidden"-->
<!--                            ref="photo"-->
<!--                            @change="updatePhotoPreview">-->

<!--                <jet-label for="photo" value="Photo" />-->

<!--                &lt;!&ndash; Current Profile Photo &ndash;&gt;-->
<!--                <div class="mt-2" v-show="! photoPreview">-->
<!--                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">-->
<!--                </div>-->

<!--                &lt;!&ndash; New Profile Photo Preview &ndash;&gt;-->
<!--                <div class="mt-2" v-show="photoPreview">-->
<!--                    <span class="block rounded-full w-20 h-20"-->
<!--                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">-->
<!--                    </span>-->
<!--                </div>-->

<!--                <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewPhoto">-->
<!--                    Select A New Photo-->
<!--                </jet-secondary-button>-->

<!--                <jet-secondary-button type="button" class="mt-2" @click.native.prevent="deletePhoto" v-if="user.profile_photo_path">-->
<!--                    Remove Photo-->
<!--                </jet-secondary-button>-->

<!--                <jet-input-error :message="form.errors.photo" class="mt-2" />-->
<!--            </div>-->

<!--            &lt;!&ndash; Name &ndash;&gt;-->
<!--            <div class="col-span-6 sm:col-span-4">-->
<!--                <jet-label for="name" value="Name" />-->
<!--                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />-->
<!--                <jet-input-error :message="form.errors.name" class="mt-2" />-->
<!--            </div>-->

<!--            &lt;!&ndash; Email &ndash;&gt;-->
<!--            <div class="col-span-6 sm:col-span-4">-->
<!--                <jet-label for="email" value="Email" />-->
<!--                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />-->
<!--                <jet-input-error :message="form.errors.email" class="mt-2" />-->
<!--            </div>-->
<!--        </template>-->

<!--        <template #actions>-->
<!--            <jet-action-message :on="form.recentlySuccessful" class="mr-3">-->
<!--                Saved.-->
<!--            </jet-action-message>-->

<!--            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                Save-->
<!--            </jet-button>-->
<!--        </template>-->
<!--    </jet-form-section>-->
    <v-row no-gutters >
        <v-col md="3" cols="12">
            <v-sheet color="transparent"
                     class="pa-4"
            >
                <h6
                    class="title font-weight-medium"
                    v-text="'Account Information'"
                >
                </h6>
                <p class="mt-2 subtitle-2 font-weight-thin font-italic">Update your account's profile information and email address.</p>
            </v-sheet>
        </v-col>
        <v-col  md="9" cols="12" class="pa-3">
            <form @submit.prevent="updateProfileInformation">
                <v-card>
                    <v-card-text>
                        <v-form v-model="valid">
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="form.name"
                                            :rules="fieldRules"
                                            label="Name"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="form.email"
                                            :rules="fieldRules"
                                            label="Email"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn
                            color="success"
                            v-if="form.recentlySuccessful"
                            text
                        >
                            Saved
                        </v-btn>
                        <v-btn
                            type="submit"
                            color="primary"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        >
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </form>

        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'UpdateProfileInformation',
        components: {
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    photo: null,
                }),
                photoPreview: null,
                valid: false,
                fieldRules: [
                    v => !!v || 'This field is required',
                ],
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => (this.photoPreview = null),
                });
            },
        },
    }
</script>
