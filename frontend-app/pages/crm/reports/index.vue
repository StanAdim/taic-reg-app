<script setup lang="ts">
definePageMeta({
  middleware:'auth'
})

</script>

<template>
  <div class="">
    <AdminThePageTitle title="SYSTEM REPORTS" />
    <h2 class="text-sky-700 font-bold"></h2>
    <!--    <no-data v-if="billStore.getUserPayments.length === 0" source="User's bills " />-->
    <div class="my-2">
      <p>Waiting...</p>
    </div>
  </div>
</template>

<style scoped>

</style>