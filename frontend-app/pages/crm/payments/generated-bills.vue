<script setup lang="ts">
import InvoiceTable from "~/components/participants/invoiceTable.vue";

definePageMeta({
  middleware:'auth'
})
const billStore = useBillStore();

const globalStore = useGlobalDataStore();
const initialize = async  () => {
  globalStore.toggleLoadingState('on')
  if(globalStore.hasPermission('can_view_bills')){
      await billStore.retrieveAllBills()
  }
  await  billStore.retrieveUserPayments()
}

onNuxtReady(()=> {
  initialize()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle title="PAYMENTS RECORD" />
      <h2 class="text-sky-700 font-bold">All Bills Generated</h2>
    <div class="flex flex-wrap justify-between flex-row border border-sky-100 p-4 rounded-md">
      <div class="bg-white shadow-lg rounded-lg ">
        <div class="my-4">
          <template  v-if="globalStore.hasPermission('can_view_bills')">
            <div class="mt-2">
              <AdminPartialsBillsGeneratedTable />
            </div>
          </template>
          <template v-else>
            <UsablesContentLoading />
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>