<script setup>
definePageMeta({
    middleware:'auth'
})
useHead({
    title: 'ICTC - Events'
})
const createUpdateConference = ref(null);
const events = ref([])
const globalStore = useGlobalDataStore()
const eventStore = useEventStore()
const setAction = ref('create')
const itemToUpdate = ref({})
const openDialog = (method, passedItem = '' )=>{
  itemToUpdate.value = passedItem
    setAction.value = method
    eventStore.toggleEventModal()
    createUpdateConference.value.setValueOfEvent();
}
const itemToBePassed = ref({})
const handleEventConfirmation = (passedItem)=> {
  globalStore.toggleConfirmToAttendModalStatus()
  itemToBePassed.value = passedItem
}
const goToEvent = (eventId) => navigateTo(`/crm/events/event-${eventId}`);
async function handleCall(){
    globalStore.toggleLoadingState('on')
    await eventStore.retrieveEvents()

}
const cancelEvent = () => {
  console.log('cancel!')
}
onNuxtReady(()=> {
    handleCall();
})

</script>
<template>
    <div>
        <confirm-to-attend-modal :show-status="globalStore.getConfirmToAttendModalStatus" :event-detail="itemToBePassed"/>
        <AdminThePageTitle title="EVENTS" />
        <adminCreateUpdateConference :passedItem ="itemToUpdate" ref="createUpdateConference"
        :showStatus="eventStore.eventDialogStatus"
        :eventAction="setAction"/>
        <div class="flex flex-wrap justify-between flex-row border border-sky-100 p-4 rounded-md">
            <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full">
            <div class="w-full max-w-sm mx-auto px-4 py-2">
                <div class="flex justify-center items-center border-b-2 border-teal-500 py-2">
                    <UsablesTheButton v-if="globalStore.hasPermission('can_create_event')"
                                      @click="openDialog('create', '')"
                                      :is-normal="true" name="Add Conference" iconClass="fa-solid fa-plus" />
                    <UsablesTheButton  v-if="globalStore.hasPermission('can_create_event')"
                        :is-normal="true" name="Add Mini Event" iconClass="fa-solid fa-plus" />
                </div>
            </div>
              <UsablesContentLoading />
            <ul class="divide-y divide-gray-300 py-1 px-4" v-if="eventStore.getEvents">
                <UsablesNoData v-if="eventStore.getEvents.length === 0" source="Events" />
                <li class="mb-3 mt-0.5 " v-for="item in eventStore.getEvents" :key="item">
                    <div class="flex flex-md-column  flex-wrap mt-3">
                        <div class="ml-3 text-gray-900 block">
                            <p
                            class=" bg-blue-200 mt-0.5 my-0.5 py-1 px-4 rounded-sm pl-4 md:text-lg text-sky-900 font-bold">
                              {{ item?.name }}
                            <span class="text-lg font-medium text-sky-900">{{item?.conferenceYear}}</span>
                            <span v-if="item?.lock" class=" ml-4 text-xl text-emerald-700 text-right"><i class="fa fa-check-double mx-2"></i></span>
                         </p>
                        </div>
                        <div class="ml-3 block text-teal-900">
                            <p class="my-0.5 py-0 font-medium line-clamp-1	">{{ item.theme }}</p>
                            <p class=" my-0.5 py-0 font-medium line-clamp-1	">Commence on</p>
                            <p class="my-0.5 py-0 font-medium line-clamp-1	">
                              <span class="text-blue-600">{{item.startDate}}</span> -
                              <span class="text-orange-700">{{item.endDate}}</span>
                            </p>

                        </div>


                        <div class="mx-2 flex md:justify-end flex-wrap gap-2" >
                          <!--    eventDetails-->
                              <usables-default-btn
                                  @click="goToEvent(item.id)"
                                  name="Details"
                                  color-name="green"
                                  icon-class="fa-solid fa-newspaper mx-2"/>
                          <template v-if="globalStore.hasPermission('can_modify_event')">
                            <usables-default-btn
                                @click="openDialog('update', item)"
                                name=""
                                color-name="emerald"
                                icon-class="fa-regular fa-pen-to-square mx-2"/>
                              <el-popconfirm
                                  confirm-button-text="Yes"
                                  cancel-button-text="No"
                                  :icon="InfoFilled"
                                  icon-color="#626AEF"
                                  title="are your sure!!"
                                  @confirm="eventStore.handleConferenceShowStatus(item.id)"
                                  @cancel="cancelEvent">
                                <template #reference >
                                  <usables-default-btn
                                      name="Show Status"
                                      color-name="gray"
                                      icon-class="fa-solid fa-hurricane"/>
                                </template>
                              </el-popconfirm>

                            <template v-if="!item?.lock">
                                <usables-default-btn
                                    @click="eventStore.handleConferenceActivation(item.id)"
                                    name="Activate"
                                    color-name="sky"
                                    icon-class="fa-brands fa-creative-commons-sampling"/>
                            </template>

                          </template>
                          <usables-default-btn v-if="globalStore.hasPermission('can_subscribe_event') && item?.status"
                              @click="handleEventConfirmation(item)"
                              name="Register"
                              color-name="teal"
                              icon-class="fa-solid fa-right-to-bracket mx-2"/>

                        </div>
                    </div>
                </li>
            </ul>
        </div>
        </div>
    </div>
</template>