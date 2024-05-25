<script setup lang="ts">
import {useBillStore} from "~/stores/useBillStore";

definePageMeta({
  middleware:'auth'
})
const billStore = useBillStore();
const billsHeader = [ {key:'conferenceName',name:'Event'} , {key:'conferenceFee',name:'Fee'},{key:'controlNumber',name:'Control Number'}, {key:'status',name:"Status"}]
const globalStore = useGlobalDataStore();
const initialize = async  () => {
  globalStore.toggleLoadingState('on')
  await  billStore.retrieveUserPayments()
}
initialize()
</script>

<template>
  <div class="">
    <AdminThePageTitle title="PAYMENTS HISTORY" />
      <h2 class="text-sky-600">Bill Generated</h2>
    <usables-simple-data-table :headers="billsHeader" :data="billStore.getUserPayments" />
  </div>
</template>

<style scoped>

</style>