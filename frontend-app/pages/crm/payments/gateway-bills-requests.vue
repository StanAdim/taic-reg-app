<script setup lang="ts">
import { ElTable } from 'element-plus'

definePageMeta({
  middleware:['auth','admin-role-checker']
})
const billStore = useBillStore();
// retrieveGatewayBillRequests,getGatewayBillRequest
const globalStore = useGlobalDataStore();
const indexMethod = (index: number) => index + 1
const initialize = async  () => {
  globalStore.toggleLoadingState('on')
  if(globalStore.hasPermission('can_view_bills')){
    await billStore.retrieveAllBills()
  }
  await  billStore.retrieveGatewayBillRequests()
}

onNuxtReady(()=> {
  initialize()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle title="PAYMENTS RECORD" />
    <h2 class="text-sky-700 font-bold">External Bill Request</h2>
    <div class="">
      <UsablesContentLoading />
    </div>
    <div class="border border-sky-100 p-4 rounded-md">
      <div class="bg-white shadow-lg rounded-lg ">
        <div class="my-4">
          <template  v-if="globalStore.hasPermission('can_view_bills')">
            <div class="mt-2">
                <el-table :data="billStore.getGatewayBillRequest" style="width: 100%">
                  <el-table-column type="selection" width="55" />
                  <el-table-column label="Sn" type="index" :index="indexMethod" />
                  <el-table-column label="Name" prop="customer_name"  />
                  <el-table-column label="Email" prop="customer_email"  />
                  <el-table-column label="Phone" prop="phone_number"  />
                  <el-table-column label="Amount" prop="amount"/>
<!--                  <el-table-column label="Bill" prop="bill_id"/>-->
                  <el-table-column label="Date" prop="date" width="120">
                    <template #default="scope">{{ scope.row.date }}</template>
                  </el-table-column>
                </el-table>
          </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>