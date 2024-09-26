
<script setup>

import BoothRequestTable from "~/components/participants/boothRequestTable.vue";

definePageMeta({
  middleware:'auth'
})
useHead({
  title: 'ICTC - Exhibitions'
})
const globalStore = useGlobalDataStore()
const boothRequestStore = useRequestBoothStore()
const eventStore = useEventStore()
const setAction = ref('create')
const itemToUpdate = ref({})

const itemToBePassed = ref({})

async function handleCall(){
  globalStore.toggleLoadingState('on')
  await eventStore.retrieveEvents();
  await boothStore.retrieveBooths();
  await boothRequestStore.retrieveUserBoothsRequests();

}
const boothStore = useBoothStore()
const handleBoothDialog = ()=> {
  boothStore.toggleCreateUpdateDialogState(true);
}
onNuxtReady(()=> {
  handleCall();
})

const isUpdateMode = ref(false)
const boothToBeUpdated = ref()
</script>
<template>
  <div>
    <create-update-exhibition-booth-modal :booth="boothToBeUpdated" :is-update-mode="isUpdateMode" :show-status="boothStore.getCreateUpdateBoothState"  />
    <AdminThePageTitle title="EXHIBITION BOOKING" />
    <h2 class="text-sky-700 font-bold">Booth request</h2>
    <div class="my-2">
      <BoothRequestTable :requests="boothRequestStore.getBoothRequests" />
    </div>
    <h2 class="text-sky-700 font-bold">Exhibition Booths available</h2>
    <adminCreateUpdateConference
        :passedItem ="itemToUpdate" ref="createUpdateConference"
        :showStatus="eventStore.eventDialogStatus"
        :eventAction="setAction"/>
    <div class="flex flex-wrap justify-between flex-row border border-sky-100 md:p-4 rounded-md">
      <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full">
        <div class="w-full max-w-sm mx-auto px-4 py-2">
          <div class="flex justify-center items-center border-b-2 border-teal-500 py-2">
            <UsablesTheButton v-if="globalStore.hasPermission('can_create_event')"
                              @click="handleBoothDialog()"
                              :is-normal="true" name="Add Exhibition Booth" iconClass="fa-solid fa-plus" />
          </div>
        </div>
        <div v-if="!globalStore.hasPermission('can_create_event')"
             class="flex flex-col flex-wrap justify-center md:flex-row  mx-2 my-1">
            <div v-for="item in boothStore.getBooths"  :key="item.id" class="">
                  <ParticipantsBoothCard :booth-data="item" />
            </div>
        </div>
        <div class="" v-else>
              <AdminPartialsBoothsTable :booths="boothStore.getBooths" />
        </div>

      </div>
    </div>
  </div>
</template>