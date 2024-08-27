<script setup lang="ts">
import {useBillStore} from "~/stores/useBillStore";
import NoData from "~/components/usables/noData.vue";

definePageMeta({
  middleware:'auth'
})
const eventStore = useEventStore()
const invitationStore = useInvitationStore()
const  handleShowInviteModal = () => {
  invitationStore.toggleNewInvitationModalStatus(true)
  console.log(invitationStore.getInvitationModalStatus)
}
const init = async () => {
 await  eventStore.retrieveEvents()
 await  invitationStore.retrieveAllInvitationRequests()
}
const handleClick = () => {
  console.log('click')
}

const tableData = [
  {
    date: '2016-05-03',
    name: 'Tom',
    state: 'California',
    city: 'Los Angeles',
    address: 'No. 189, Grove St, Los Angeles',
    zip: 'CA 90036',
    tag: 'Home',
  },
  {
    date: '2016-05-02',
    name: 'Tom',
    state: 'California',
    city: 'Los Angeles',
    address: 'No. 189, Grove St, Los Angeles',
    zip: 'CA 90036',
    tag: 'Office',
  },
  {
    date: '2016-05-04',
    name: 'Tom',
    state: 'California',
    city: 'Los Angeles',
    address: 'No. 189, Grove St, Los Angeles',
    zip: 'CA 90036',
    tag: 'Home',
  },
  {
    date: '2016-05-01',
    name: 'Tom',
    state: 'California',
    city: 'Los Angeles',
    address: 'No. 189, Grove St, Los Angeles',
    zip: 'CA 90036',
    tag: 'Office',
  },
]
onNuxtReady(()=>{
  init()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle title="INVITATION LETTERS" />
    <CreateUpdateInvitationLetterRequest :is-update-mode="false" :show-status="invitationStore.getInvitationModalStatus" />
    <div class="flex flex-wrap md:justify-between gap-2">
      <div class="">
        <h2 class="text-sky-700 font-bold">Your Invitation letter Request</h2>
      </div>
      <div class="">
        <UsablesTheButton @click.prevent="handleShowInviteModal()" :is-normal="true" name="New Request" iconClass="fa-solid fa-plus" />
      </div>
    </div>
<!--    <no-data v-if="billStore.getUserPayments.length === 0" source="User's bills " />-->
      <div class="my-2">
        <el-table :data="tableData" style="width: 100%">
          <el-table-column fixed prop="date" label="Date"  />
          <el-table-column prop="name" label="Name"  />
          <el-table-column prop="state" label="State"  />
          <el-table-column prop="city" label="City"  />
          <el-table-column prop="address" label="Address"  />
          <el-table-column prop="zip" label="Zip"  />
          <el-table-column fixed="right" label="Operations" min-width="120">
            <template #default>
              <el-button link type="primary" size="small" @click="handleClick">
                Detail
              </el-button>
              <el-button link type="primary" size="small">Edit</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
  </div>
</template>

<style scoped>

</style>