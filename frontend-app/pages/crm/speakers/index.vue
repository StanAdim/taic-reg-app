<script setup>
import NoData from "~/components/usables/noData.vue";

useHead({
    title: 'TAIC - Speakers'
})
definePageMeta({
    middleware:'auth'
})
const initDialog = ref(null);
const isUpdating  = ref(false)
const globalData = useGlobalDataStore()
const keySpeakerStore = useSpeakerStore()
const handleItemUpdate = (item) => {
  isUpdating.value = true
  keySpeakerStore.assignDataToBeUpdated(item)
  initDialog.value.initDialogData();
  keySpeakerStore.toggleKeySpeakerModal(true)
}
const eventStore = useEventStore()

const handleInitializing = async ()=>{
    await keySpeakerStore.retrieveConferenceSpeakers()
    await keySpeakerStore.retrieveGoHSpeaker()
    await  eventStore.retrieveEvents()
}
const openDialog = (method)=>{
    keySpeakerStore.toggleKeySpeakerModal(true);
}
onNuxtReady(()=> {
  handleInitializing()

})
</script>
<template>
  <div class="">
    <AdminThePageTitle title="KEY SPEAKERS" />
    <AdminCreateUpdateKeySpeaker ref="initDialog" :is-update-mode="isUpdating" />
    <div class="">
      <div class=" mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="w-full max-w-sm mx-auto px-4 py-4">
          <div class="flex justify-center items-center border-b-2 border-teal-500 py-2">
<!--            <UsablesTheButton @click="handleInitializing()" :is-normal="true" name="Refresh" iconClass="fa-solid fa-arrows-rotate" />-->
            <UsablesTheButton v-if="globalData.hasPermission('can_manage_site')"  @click="openDialog('create')" :is-normal="true" name="Add Speaker" iconClass="fa-solid fa-plus" />
          </div>
        </div>
        <div class="flex justify-center items-center border-b-2 border-teal-500 py-2">
          <AdminSpeakerCard :info="keySpeakerStore.getSpeakerGoH" />
        </div>
        <ul class="flex justify-center divide-y divide-gray-300 px-4">
          <li class="mb-3 mt-2" >
            <div class="flex flex-initial flex-wrap" v-if="keySpeakerStore.getSpeakers">
              <no-data v-if="keySpeakerStore.getSpeakers.length === 0" source="Events Speakers" />
              <div class=" text-gray-900 " v-for="item in keySpeakerStore.getSpeakers" :key="item.email">
                <AdminSpeakerCard :info="item" />
              </div>

            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>