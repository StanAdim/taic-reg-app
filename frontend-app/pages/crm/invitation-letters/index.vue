<script setup lang="ts">
import {useBillStore} from "~/stores/useBillStore";
import NoData from "~/components/usables/noData.vue";
import ContentLoading from "~/components/usables/contentLoading.vue";

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
const indexMethod = (index: number) => index + 1
const handleClick = () => {
  console.log('click')
}
const isUpdating  = ref(false)
const toBeEdited  = ref()
const handleRequestUpdate = (item) => {
  isUpdating.value = true
  toBeEdited.value = item
  invitationStore.toggleNewInvitationModalStatus(true)
  // console.log(item)
}
onNuxtReady(()=>{
  init()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle title="INVITATION LETTERS" />
    <CreateUpdateInvitationLetterRequest :invitationRequest="toBeEdited"
                                         :is-update-mode="isUpdating"
                                         :show-status="invitationStore.getInvitationModalStatus" />
    <div class="flex flex-wrap gap-2 items-center">
      <div class="">
        <h2 class="text-sky-700 font-bold">Your Invitation letter Request</h2>
      </div>
      <div class="">
        <UsablesTheButton @click.prevent="handleShowInviteModal()" :is-normal="true" name="New Request" iconClass="fa-solid fa-plus" />
      </div>
    </div>

      <div class="my-2 py-2">
        <ContentLoading />
        <el-table :data="invitationStore.getInvitationRequests" style="width: 100%">
            <el-table-column label="Sn" type="index" :index="indexMethod" />
          <el-table-column prop="institutionName" label="Name"  />
          <el-table-column prop="email_to" label="To-be Sent To"  />
          <el-table-column prop="addressingTo" label="Addressed To"  />
          <el-table-column prop="po_box" label="PO box"  />
          <el-table-column prop="region.name" label="Region"  />
          <el-table-column prop="conference" label="Conference Name"  />
          <el-table-column fixed="right" label="Operations" min-width="120">
            <template #default="scope">
              <el-button link type="primary" size="small" @click="handleClick">
                Detail
              </el-button>
              <el-button @click.prevent="handleRequestUpdate(scope.row)" link type="primary" size="small">Edit</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
  </div>
</template>

<style scoped>

</style>