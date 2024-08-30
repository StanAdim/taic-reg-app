<script setup lang="ts">
import {useBillStore} from "~/stores/useBillStore";
import NoData from "~/components/usables/noData.vue";
import ContentLoading from "~/components/usables/contentLoading.vue";

definePageMeta({
  middleware:'auth'
})
const eventStore = useEventStore()
const authStore = useAuthStore()
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
const  goToUser = (pathKey)=> navigateTo(`/crm/users/user/${pathKey}`)
const  handleRequestResolve = async (requestId)=> {
   await  invitationStore.updateRequestStatus(requestId)
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
          <template v-if="authStore.getUserRole === 'admin'">
              <el-table-column prop="user" label="Request For"  />
          </template>
          <el-table-column label="Status">
            <template #default="scope">
              <div class="text-left text-xl">
                <span v-if="scope.row.status"><i class="fa-solid fa-hourglass-half text-yellow-500 font-bold"></i></span>
                <span v-else><i class="fa-solid fa-check text-sky-400 font-bold"></i></span>
              </div>
            </template>
          </el-table-column>

          <el-table-column prop="institutionName" label="Institution Name"  />
          <el-table-column prop="email_to" label="To-be Sent To"  />
          <el-table-column prop="addressingTo" label="Addressed To"  />
          <el-table-column prop="po_box" label="PO box"  />
          <el-table-column prop="region.name" label="Region"  />
          <el-table-column prop="conference" label="Conference Name"  />
          <el-table-column fixed="right" label="Operations" min-width="120">
            <template #default="scope">
              <el-button v-if="authStore.getUserRole === 'admin'" link type="primary" size="small" @click="goToUser(scope.row.userKey)">
                User details
              </el-button>
              <el-button v-if="authStore.getUserRole === 'attendee'" @click.prevent="handleRequestUpdate(scope.row)" link type="primary" size="small">Edit</el-button>
              <el-button v-if="authStore.getUserRole === 'admin'" @click.prevent="handleRequestResolve(scope.row.id)" link type="primary" size="small">Resolve</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
  </div>
</template>

<style scoped>

</style>