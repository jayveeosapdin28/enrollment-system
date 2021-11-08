<template>
    <div v-if="hasErrors" class="pa-4">
        <v-alert v-for="(error, key) in errors" :key="key" type="error">
            {{ error }}
        </v-alert>
    </div>
</template>

<script>
export default {
    name: 'ErrorAlert',
    computed: {
        errors() {
            return this.$page.props.errors
        },

        hasErrors() {
            return Object.keys(this.errors).length > 0;
        },
    }
}
</script>
