<script setup lang="ts">
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
  if(globalStore.hasPermission('can_view_bills')){
      await billStore.retrieveAllBills()
  }
  await  billStore.retrieveUserPayments()
}
const allBillsHeader =
    [{key:'user',name:'Attendee Name'}, {key:'conferenceName',name:'Event'} ,
      {key:'conferenceFee',name:'Fee'},{key:'controlNumber',name:'Control Number'},
      {key:'status',name:"Status"}]

initialize()
</script>

<template>
  <div class="">
    <AdminThePageTitle title="PAYMENTS HISTORY" />
      <h2 class="text-sky-700 font-bold">Bills Generated</h2>
    <UsablesContentLoading />

    <UsablesNoData v-if="billStore.getUserPayments.length === 0" source="User's bills " />
    <usables-simple-data-table v-else :headers="billsHeader" :data="billStore.getUserPayments" />
<!--    <ParticipantsInvoiceTable />-->
    <template  v-if="globalStore.hasPermission('can_view_bills')">
      <div class="mt-2">
        <h2 class="text-emerald-600 font-bold">All Payment Bills Generated</h2>
        <UsablesNoData v-if="billStore.getAllBills.length === 0" source="Bill Payments" />
        <usables-simple-data-table v-else :headers="allBillsHeader" :data="billStore.getAllBills" />
      </div>
    </template>
  </div>
</template>

<style scoped>

</style>