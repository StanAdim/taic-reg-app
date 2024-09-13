<script setup lang="ts">
import ContentLoading from "~/components/usables/contentLoading.vue";
import {useSupportActionStore} from "~/stores/useSupportActionStore";

definePageMeta({
  middleware:'auth'
})
const supportStore = useSupportActionStore()
const  handleNewSupport = () => {
  supportStore.toggleModalStatus(true)
}
const passData = ref(null)
const init = async () => {
 await  supportStore.retrieveLatestSingleRequest()
 await  supportStore.retrieveUserSupportRequests()
  passData.value = supportStore.getSingleSupportRequest
}

const isUpdating  = ref(false)
const toBeEdited  = ref()
const handleRequestUpdate = (item) => {
  isUpdating.value = true
  toBeEdited.value = item
  supportStore.toggleModalStatus(true)
  // console.log(item)
}
const title = ref('REQUEST FOR HELP')
const handleShowData = async  (item) => {
  passData.value = item
}
onNuxtReady(()=>{
  init()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle :title="title" />
    <ContentLoading />
    <ParticipantsSupportRequestFormModal :invitationRequest="toBeEdited"
                                         :is-update-mode="isUpdating"
                                         :show-status="supportStore.getModalStatus" />
    <div class="flex flex-wrap gap-2 items-center">
      <div class="">
        <h2 class="text-sky-700 font-bold">Do you have any inquiry ?</h2>
      </div>
      <div class="">
        <UsablesTheButton @click.prevent="handleNewSupport()" :is-normal="true" name="New Request" iconClass="fa-solid fa-plus" />
      </div>
    </div>
      <div class="my-2 py-2">
        <div class="container md:py-8 md:px-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column: List of Support Requests -->
            <div class="bg-white rounded-lg shadow-md p-4">
              <h2 class="text-xl font-semibold mb-4">Support Requests</h2>
              <!-- block for each support request -->
              <div v-for="item in supportStore.getUserSupportRequests" :key="item.id" @click="handleShowData(item)"
                  class="mb-4 border-b border-gray-200 pb-4 hover:bg-sky-100 hover:cursor-pointer px-2 rounded-md">
                <h3 class="text-md font-medium text-blue-600">
                  <span>{{ item?.subject }}</span>
                </h3>
                <p class="text-sm text-gray-600 mt-1">Status: <span class="text-green-500">{{ item?.status }}</span></p>
                <p class="text-sm text-gray-600 mt-1">Responses: <small class="absolute top-[2px] bg-emerald-200/80 rounded-full px-2 mx-2 text-green-600">{{item?.responseCount}}</small></p>
              </div>
              <!-- End  block -->
            </div>

            <!-- Right Column: Selected Request and Responses -->
            <div class="col-span-2 bg-white rounded-lg shadow-md p-6">
                <ParticipantsSingleSupportRequest :request-data="passData" />
            </div>
          </div>
        </div>

      </div>
  </div>
</template>

<style scoped>

</style>