<script setup lang="ts">

definePageMeta({
  middleware:['auth','admin-role-checker']
})
const billStore = useBillStore();
const globalStore = useGlobalDataStore();
const initialize = async  () => {
  globalStore.toggleLoadingState('on')
  await  billStore.retrieveUserPayments()
}


onNuxtReady(()=> {
  initialize()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle title="BILL INVOICES" />
      <h2 class="text-sky-700 font-bold">Bills Generated</h2>
    <UsablesContentLoading />
    <div class="flex flex-wrap justify-between flex-row border border-sky-100 p-4 rounded-md">
      <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full">
        <div class="my-4">
          settled-payemnt
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>