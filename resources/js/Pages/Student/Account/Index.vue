<template>
  <main-layout :app="this">
     <show-profile/>
  </main-layout>
</template>

<script>
import ShowProfile from "../../Profile/Show";
import MainLayout from "../../../Layouts/MainLayout";
export default {
    name: "Index",
    props:['session'],
    components: {MainLayout, ShowProfile}
}
</script>

<style scoped>

</style>
