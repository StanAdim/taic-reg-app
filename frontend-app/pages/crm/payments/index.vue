<script setup lang="ts">
import InvoiceTable from "~/components/participants/invoiceTable.vue";

definePageMeta({
  middleware:'auth'
})
const billStore = useBillStore();
const billsHeader = [{key: 'conferenceName', name: 'Event'},
  {key: 'conferenceFee', name: 'Fee'},
  {key: 'ReqId', name: 'Booking ID'},
  {key: 'controlNumber', name: 'Control Number'},
  {key: 'created_at', name: 'Created On'},
  {key: 'status', name: "Status"}]
const globalStore = useGlobalDataStore();
const initialize = async  () => {
  globalStore.toggleLoadingState('on')
  await  billStore.retrieveUserPayments()
}
const allBillsHeader =
    [{key:'user',name:'Attendee Name'}, {key:'conferenceName',name:'Event'} ,
      {key:'conferenceFee',name:'Fee'},{key:'controlNumber',name:'Control Number'},
      {key:'status',name:"Status"}]

onNuxtReady(()=> {
  initialize()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle title="BILL INVOICES" />
      <h2 class="text-sky-700 font-bold">Bills Generated</h2>
    <div class="flex flex-wrap justify-between flex-row border border-sky-100 p-4 rounded-md">
      <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full">
        <div class="my-4">
          <InvoiceTable />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>