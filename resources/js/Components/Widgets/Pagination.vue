<template>
    <v-pagination
        v-model="data.current_page"
        :length="data.last_page"
    ></v-pagination>
</template>

<script>
export default {
    props:['data'],
    name: "Pagination",
}
</script>

<style scoped>

</style>
