<script setup lang="ts">
definePageMeta({
  middleware:'auth'
})

</script>

<template>
  <div class="">
    <AdminThePageTitle title="SYSTEM REPORTS" />
    <h2 class="text-sky-700 font-bold">System Reports</h2>
    <!--    <no-data v-if="billStore.getUserPayments.length === 0" source="User's bills " />-->

    <div class="flex flex-wrap justify-between flex-row border border-sky-100 p-4 rounded-md">
      <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full">
        <div class="my-2">
          <p>Waiting...</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>